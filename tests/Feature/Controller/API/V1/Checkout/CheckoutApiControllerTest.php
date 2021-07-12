<?php

namespace App\Tests\Feature\Controller\API\V1\Checkout;

use App\Tests\AbstractWebTestCase;
use App\Tests\DevolonDataProviderTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * "/checkout".
 */
class CheckoutApiControllerTest extends AbstractWebTestCase
{
    use DevolonDataProviderTrait;

    /**
     * @dataProvider devolonDataProvider
     */
    public function testCheckoutSuccess($actual, $expected)
    {
        $this->loadDefaultEntity();
        $data = [
            'product' => $actual,
        ];
        $this->client->request('POST', '/api/v1/checkout', [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();

        $this->assertEquals($this->getResponseBody()->data->total, $expected);
    }

    public function testCheckoutInExtraInfoInRequestGet400()
    {
        $this->loadDefaultEntity();
        $data = [
            'product' => [
                ['id' => 1, 'number' => 1],
            ],
            'extraField' => 'Ok',
        ];
        $this->client->request('POST', '/api/v1/checkout', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

    public function testCheckoutInExtraInfoInProductsRequestGet400()
    {
        $this->loadDefaultEntity();
        $data = [
            'product' => [
                [
                    'id' => 1,
                    'number' => 1,
                    'extraField' => 'Ok',
                ],
            ],
        ];
        $this->client->request('POST', '/api/v1/checkout', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

    public function testCheckoutInEmptyProductsRequestGet400()
    {
        $this->loadDefaultEntity();
        $data = [
            'product' => [],
        ];
        $this->client->request('POST', '/api/v1/checkout', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

    public function testCheckoutInEmptyRequestGet400()
    {
        $this->loadDefaultEntity();
        $data = [];
        $this->client->request('POST', '/api/v1/checkout', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }


    public function testCheckoutInNotExistProduct()
    {
        $this->loadDefaultEntity();
        $data = [
            'product' => [
                ['id' => 1, 'number' => 1],
                ['id' => 2, 'number' => 1],
                ['id' => 3, 'number' => 1],
                ['id' => 100, 'number' => 1],
            ],
            'extraField' => 'Ok',
        ];
        $this->client->request('POST', '/api/v1/checkout', [], [], [], json_encode($data));
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $response = $this->getResponseBody();
        $this->assertEquals($response->status, Response::HTTP_BAD_REQUEST);
    }

}
