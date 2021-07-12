<?php

namespace App\Model;

class CartModel
{
    private array $productsIds;
    private array $remainProductIds;
    /**
     * @var ProductModel[]
     */
    private array $productModels;

    public function __construct()
    {
        $this->productModels = [];
        $this->remainProductIds = [];
    }

    public function addProducts($id, $number): void
    {
        $this->productsIds[$id] = ($this->productsIds[$id] ?? 0) + $number;
        $this->remainProductIds[$id] = ($this->remainProductIds[$id] ?? 0) + $number;
    }

    public function handleProductId($id, $number)
    {
        if (isset($this->remainProductIds[$id])) {
            $this->remainProductIds[$id] = $this->remainProductIds[$id] - $number;
            if ($this->remainProductIds[$id] <= 0) {
                unset($this->remainProductIds[$id]);
            }
        }
    }

    public function getRemainProductIds(): array
    {
        return $this->remainProductIds;
    }

    public function getProductsIds(): array
    {
        return $this->productsIds;
    }

    public function getProductModels(): array
    {
        return $this->productModels;
    }

    public function addCheckouts(ProductModel $checkouts): CartModel
    {
        $this->productModels[] = $checkouts;
        $this->handleProductId($checkouts->getProductObject()->getId(), $checkouts->getTotalCounter());

        return $this;
    }
}
