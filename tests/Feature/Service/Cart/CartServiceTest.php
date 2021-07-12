<?php

namespace App\Tests\Feature\Service\Cart;

use App\Service\Cart\CartService;
use App\Service\Rule\CartRuleService;
use App\Tests\AbstractTest;
use App\Tests\DevolonDataProviderTrait;

class CartServiceTest extends AbstractTest
{
    use DevolonDataProviderTrait;

    /**
     * @dataProvider getRequestProductDataProvider
     */
    public function testSumInFillCart($actual, $expected)
    {
        $cartService = $this->getFilledCart($actual['product']);

        foreach ($expected as $expect) {
            self::assertSame($cartService->getCart()->getProductsIds()[$expect['id']], $expect['sum']);
        }
    }

    /**
     * @dataProvider getRequestProductDataProvider
     */
    public function testExistProductInCartAfterFillCart($actual, $expected)
    {
        $cartService = $this->getFilledCart($actual['product']);

        foreach ($expected as $expect) {
            self::assertTrue(isset($cartService->getCart()->getProductsIds()[$expect['id']]));
        }
    }

    protected function getCurlService(): CartService
    {
        $checkoutServiceMock = $this->getMockBuilder(CartRuleService::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([self::getContainer()->get('doctrine.orm.entity_manager')])
            ->getMock();

        return new CartService($checkoutServiceMock);
    }

    protected function getFilledCart($actual): CartService
    {
        $cartService = $this->getCurlService();
        $cartService->fillCart($actual);

        return $cartService;
    }
}
