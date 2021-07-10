<?php

namespace App\Filter;

/**
 * Class DiscountFilter.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class DiscountFilter extends AbstractQueryFilter implements QueryFilterInterface
{
    public function id(string $id): void
    {
        $this->builder->andWhere('filter.id = :id')
            ->setParameter('id', intval($id));
    }

    public function number(string $number): void
    {
        $this->builder->andWhere('filter.number = :number')
            ->setParameter('number', $number);
    }

    public function price(string $price): void
    {
        $this->builder->andWhere('filter.price = :price')
            ->setParameter('price', $price);
    }

    public function priceGt(string $priceGt): void
    {
        $this->builder->andWhere('filter.price >= :priceGt')
            ->setParameter('priceGt', $priceGt);
    }

    public function priceLt(string $priceLt): void
    {
        $this->builder->andWhere('filter.price <= :priceLt')
            ->setParameter('priceLt', $priceLt);
    }

    public function productId(string $productId): void
    {
        $this->builder->andWhere('filter.product = :productId')
            ->setParameter('productId', $productId);
    }

}
