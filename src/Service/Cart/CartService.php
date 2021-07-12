<?php

namespace App\Service\Cart;

use App\Model\CartModel;
use App\Service\Rule\CartRuleService;

class CartService
{
    private CartModel $cart;

    private CartRuleService $checkoutService;

    public function __construct(CartRuleService $checkoutService)
    {
        $this->cart = new CartModel();
        $this->checkoutService = $checkoutService;
    }

    public function getCart(): CartModel
    {
        return $this->cart;
    }

    public function setCart(CartModel $cart): CartService
    {
        $this->cart = $cart;

        return $this;
    }

    public function fillCart(array $productsArray)
    {
        array_walk($productsArray, fn ($product) => $this->cart->addProducts($product['id'], $product['number']));

        return $this;
    }

    public function calculate()
    {
        $this->cart = $this->checkoutService->apply($this->cart);

        return $this;
    }

    public function handleCart($productArray): CartModel
    {
        return $this->fillCart($productArray)->calculate()->getCart();
    }
}
