<?php

namespace App\Model;

use App\Entity\Discount;
use App\Entity\Product;

class ProductModel
{
    private int $totalPrice;
    private int $totalCounter;
    private int $discountTotalPrice;
    private int $discountCounterItems;
    private Product $productObject;
    private array $discountsObject;

    public function __construct()
    {
        $this->totalPrice = 0;
        $this->totalCounter = 0;
        $this->discountTotalPrice = 0;
        $this->discountCounterItems = 0;
        $this->discountsObject = [];
    }

    /**
     * @param $number
     * @param $unitPrice
     */
    public function addItem($number, $unitPrice): void
    {
        $value = $number * $unitPrice;
        $this->addTotalPrice($value);
        $this->addTotalCounter($number);
    }

    public function addDiscount(Discount $discount, int $packageNumber): void
    {
        $value = $packageNumber * $discount->getPrice();
        $this->addTotalPrice($value);
        $this->addTotalDiscountPrice($value);

        $numbers = $packageNumber * $discount->getNumber();
        $this->addTotalCounter($numbers);
        $this->addDiscountCounterItems($numbers);

        $this->addDiscountItems($discount);
    }

    private function addTotalPrice(int $value): void
    {
        $this->totalPrice += $value;
    }

    private function addTotalDiscountPrice(int $value): void
    {
        $this->discountTotalPrice += $value;
    }

    private function addDiscountCounterItems(int $value): void
    {
        $this->discountCounterItems += $value;
    }

    private function addDiscountItems(Discount $discount): void
    {
        $this->discountsObject[] = $discount;
    }

    private function addTotalCounter(int $value): void
    {
        $this->totalCounter += $value;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function getDiscountTotalPrice(): int
    {
        return $this->discountTotalPrice;
    }

    public function setProductObject(Product $productObject): ProductModel
    {
        $this->productObject = $productObject;

        return $this;
    }

    public function getProductObject(): Product
    {
        return $this->productObject;
    }

    public function getDiscountCounterItems(): int
    {
        return $this->discountCounterItems;
    }

    public function getDiscountsObject(): array
    {
        return $this->discountsObject;
    }

    public function getTotalCounter(): int
    {
        return $this->totalCounter;
    }
}
