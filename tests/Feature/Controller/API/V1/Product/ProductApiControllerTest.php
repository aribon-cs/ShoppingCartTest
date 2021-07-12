<?php

namespace App\Tests\Feature\Controller\API\V1\Product;

use App\Entity\Product;
use App\Exceptions\NotFoundException;
use App\Exceptions\OperationFailedException;
use App\Tests\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductApiControllerTest extends AbstractWebTestCase
{
    public function testIndexWhenProductsNotExist()
    {
        $this->client->request('GET', '/api/v1/product');
        $this->assertResponseIsSuccessful();
    }

    public function testIndexIsSuccessful()
    {
        $this->loadDefaultEntity();
        $this->client->request('GET', '/api/v1/product');
        $this->assertResponseIsSuccessful();
    }

    public function testIndexIsSuccessfulInQueryWithNotExistId()
    {
        $this->loadDefaultEntity();
        $this->client->request('GET', '/api/v1/product?id=123');
        $this->assertResponseIsSuccessful();
    }

    public function testIndexReturnOneResultInQueryResult()
    {
        $this->loadDefaultEntity();
        $this->client->request('GET', '/api/v1/product?id=1');
        $body = $this->getResponseBody(true);
        $this->assertResponseIsSuccessful();
        $this->assertSameSize($body['data']['items'], ['onceResult']);
    }

    public function testIndexIsSuccessfulInQueryNotExistKey()
    {
        $this->loadDefaultEntity();
        $this->client->request('GET', '/api/v1/product?UNKOWNKEY=123');
        $this->assertResponseIsSuccessful();
    }

    public function dataProduct()
    {
        return [
            // name, price
            ['A', 10],
            ['B', 20],
            ['C', 30],
            ['D', 51],
        ];
    }

    /**
     * @dataProvider dataProduct
     */
    public function testCreateProductSuccessful($name, $price)
    {
        $data = [
            'name' => $name,
            'price' => $price,
        ];
        $this->client->request('POST', '/api/v1/product', [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();

        self::assertNotNull($this->entityManage->getRepository(Product::class)->find(1));
        self::assertEquals(sizeof($this->entityManage->getRepository(Product::class)->findAll()), 1);

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    /**
     * @dataProvider dataProduct
     */
    public function testCreateProductCheckResponseBody($name, $price)
    {
        $data = [
            'name' => $name,
            'price' => $price,
        ];
        $this->client->request('POST', '/api/v1/product', [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();

        $body = $this->getResponseBody(true);

        self::assertEquals($body['data'], $data);
    }

    public function testCreateProductErrorInDuplicateName()
    {
        $products = [
            ['A', 10],
            ['B', 20],
            ['B', 20],
        ];
        $this->expectException(OperationFailedException::class);
        foreach ($products as $product) {
            $data = [
                'name' => $product[0],
                'price' => $product[1],
            ];
            $this->client->request('POST', '/api/v1/product', [], [], [], json_encode($data));
        }
    }

    public function testCreateProductInEmptyRequestGet400()
    {
        $data = [];
        $this->client->request('POST', '/api/v1/product', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testCreateProductInExtraInfoInRequestGet400()
    {
        $data = [
            'name' => 'A',
            'price' => 20,
            'extraField' => 'wooow',
        ];
        $this->client->request('POST', '/api/v1/product', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

    public function testCreateProductInCaseSensitiveBodyGet400()
    {
        $data = [
            'Name' => 'A',
            'Price' => 20,
        ];
        $this->client->request('POST', '/api/v1/product', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

    public function testGetProductSuccessful()
    {
        $this->loadDefaultEntity();

        $this->client->request('GET', '/api/v1/product/1');
        $this->assertResponseIsSuccessful();
    }

    public function testGetProductNotExist()
    {
        $this->loadDefaultEntity();

        $this->expectException(NotFoundException::class);
        $this->client->request('GET', '/api/v1/product/100');
    }

    public function dataUpdateProduct()
    {
        return [
            // name, price
            [['id' => 1, 'name' => 'A', 'price' => 10]],
            [['id' => 2, 'name' => 'B', 'price' => 20]],
            [['id' => 3, 'name' => 'C', 'price' => 30]],
            [['id' => 4, 'name' => 'D', 'price' => 51]],
        ];
    }

    /**
     * @dataProvider dataUpdateProduct
     */
    public function testUpdateProductSuccessful($item)
    {
        $this->loadDefaultEntity();
        $data = [
            'name' => $item['name'],
            'price' => $item['price'] + 111,
        ];
        $this->client->request('PUT', '/api/v1/product/'.$item['id'], [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();

        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @dataProvider dataUpdateProduct
     */
    public function testUpdateProductSuccessfulShouldNotAddNewItemInDB($item)
    {
        $this->loadDefaultEntity();
        $before = $this->entityManage->getRepository(Product::class)->findAll();
        $data = [
            'name' => $item['name'],
            'price' => $item['price'] + 111,
        ];
        $this->client->request('PUT', '/api/v1/product/'.$item['id'], [], [], [], json_encode($data));

        $after = $this->entityManage->getRepository(Product::class)->findAll();
        self::assertSameSize($after, $before);
    }

    /**
     * @dataProvider dataUpdateProduct
     */
    public function testUpdateProductNotExist($item)
    {
        $this->loadDefaultEntity();
        $data = [
            'name' => $item['name'],
            'price' => $item['price'] + 111,
        ];
        $this->expectException(NotFoundException::class);
        $this->client->request('PUT', '/api/v1/product/'.($item['id'] * 100), [], [], [], json_encode($data));
    }

    /**
     * @dataProvider dataUpdateProduct
     */
    public function testUpdateProductCheckResponseBody($item)
    {
        $this->loadDefaultEntity();
        $data = [
            'name' => $item['name'],
            'price' => $item['price'] + 111,
        ];
        $this->client->request('PUT', '/api/v1/product/'.$item['id'], [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();

        $body = $this->getResponseBody(true);

        self::assertEquals($body['data'], $data);
    }

    public function testUpdateProductInEmptyRequestGet200()
    {
        $this->loadDefaultEntity();
        $data = [];
        $this->client->request('PUT', '/api/v1/product/1', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUpdateProductInExtraInfoInRequestGet400()
    {
        $this->loadDefaultEntity();
        $data = [
            'name' => 'A',
            'price' => 20,
            'extraField' => 'wooow',
        ];
        $this->client->request('PUT', '/api/v1/product/1', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

    public function testUpdateProductInCaseSensitiveBodyGet400()
    {
        $this->loadDefaultEntity();
        $data = [
            'Name' => 'A',
            'Price' => 20,
        ];
        $this->client->request('PUT', '/api/v1/product/1', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }
}
