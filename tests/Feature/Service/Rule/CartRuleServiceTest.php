<?php

namespace App\Tests\Feature\Service\Rule;

use App\Entity\Discount;
use App\Entity\Product;
use App\Exceptions\RuleExceptions\NotExistRuleException;
use App\Helpers\CalculatorHelpers;
use App\Model\CartModel;
use App\Service\Rule\CartRuleService;
use App\Tests\AbstractTest;
use App\Tests\DevolonDataProviderTrait;

class CartRuleServiceTest extends AbstractTest
{
    use DevolonDataProviderTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->loadDefaultEntity();
    }

    public function testApplyRulesNotExistProductRequested()
    {
        $cart = new CartModel();
        $cart->addProducts(1, 100);
        $cart->addProducts(2, 20);
        $cart->addProducts(1, 100);
        $cart->addProducts(2, 20);
        $cart->addProducts(1, 100);
        $cart->addProducts(2, 30);
        $cart->addProducts(200, 30);

        self::expectException(NotExistRuleException::class);

        $checkoutService = new CartRuleService($this->entityManage);

        $checkoutService->apply($cart);
    }

    /**
     * @dataProvider devolonDataProvider
     */
    public function testApplyDevolonExamples($actual, $expected)
    {
        $cart = new CartModel();
        foreach ($actual as $item) {
            $cart->addProducts($item['id'], $item['number']);
        }
        $checkoutService = new CartRuleService($this->entityManage);

        $cart = $checkoutService->apply($cart);
        self::assertEmpty($cart->getRemainProductIds());
        self::assertSame(CalculatorHelpers::getTotalPriceOfCheckoutsStatic($cart->getProductModels()), $expected);
    }
}
