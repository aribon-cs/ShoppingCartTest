<?php

namespace App\Filter;

/**
 * Class ProductFilter.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
class ProductFilter extends AbstractQueryFilter implements QueryFilterInterface
{
    public function id(string $id): void
    {
        $this->builder->andWhere('filter.id = :id')
            ->setParameter('id', intval($id));
    }

    public function name(string $name): void
    {
        $this->builder->andWhere('filter.name = :name')
            ->setParameter('name', $name);
    }

    public function nameLike(string $name): void
    {
        $this->builder->andWhere('filter.name like :name')
            ->setParameter('name', "%".$name."%");
    }

    public function price(string $price): void
    {
        $this->builder->andWhere('filter.price = :price')
            ->setParameter('price', $price);
    }

}
