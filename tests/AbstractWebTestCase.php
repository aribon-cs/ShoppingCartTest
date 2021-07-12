<?php

namespace App\Tests;

use App\Entity\Discount;
use App\Entity\Product;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected $entityManage;
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();

        $kernel = self::$kernel;

        $container = $kernel->getContainer();
        $this->entityManage = $container->get('doctrine')->getManager();

        //method 1 :  create DB and schema's
        $schemaTool = new SchemaTool($this->entityManage);
        $schemaTool->dropDatabase();
        static $metadata = null;
        if (is_null($metadata)) {
            $metadata = $this->entityManage->getMetadataFactory()->getAllMetadata();
        }

        if (!empty($metadata)) {
            $schemaTool->createSchema($metadata);
        }

        // method 2 : use rollback transaction in tear down to have clean DB instead of create and delete in each test
        $this->entityManage->getConnection()->beginTransaction();
        $this->entityManage->getConnection()->setAutoCommit(false);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManage->getConnection()->rollBack();
    }

    // @todo load fixtures instead of this function
    public function loadDefaultEntity()
    {
        $lists = [
            'A' => [
                'unit' => 50,
                'discounts' => [
                    ['number' => 3, 'price' => 130],
                ],
            ],
            'B' => [
                'unit' => 30,
                'discounts' => [
                    ['number' => 2, 'price' => 45],
                ],
            ],
            'C' => ['unit' => 20, 'discounts' => []],
            'D' => ['unit' => 15, 'discounts' => []],
        ];
        foreach ($lists as $name => $info) {
            $product = new Product();
            $product->setName($name);
            $product->setPrice($info['unit']);
            foreach ($info['discounts'] as $discountInfo) {
                $discount = new Discount();
                $discount->setProduct($product);
                $discount->setNumber($discountInfo['number']);
                $discount->setPrice($discountInfo['price']);
                $this->entityManage->persist($discount);
                $product->addDiscount($discount);
            }
            $this->entityManage->persist($product);
        }
        $this->entityManage->flush();
    }

    protected function getResponseBody($assoc = false)
    {
        return json_decode($this->client->getResponse()->getContent(), $assoc);
    }
}
