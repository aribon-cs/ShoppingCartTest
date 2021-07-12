<?php

namespace App\Service;

use App\Entity\Discount;
use App\Entity\Product;
use App\Filter\QueryFilterInterface;
use App\Repository\DiscountRepository;
use App\Service\Filter\FilterServiceInterface;
use App\Transformer\TransformerInterface;
use function Psy\info;

class DiscountService
{
    private FilterServiceInterface $filterService;
    private DiscountRepository $repository;
    private QueryFilterInterface $queryFilter;
    private TransformerInterface $discountTransformer;

    public function __construct(
        FilterServiceInterface $filterService,
        DiscountRepository $repository,
        QueryFilterInterface $discountQueryFilter,
        TransformerInterface $discountTransformer
    ) {
        $this->repository = $repository;
        $this->queryFilter = $discountQueryFilter;
        $this->filterService = $filterService;
        $this->discountTransformer = $discountTransformer;
    }

    public function getTransformer(): TransformerInterface
    {
        return $this->discountTransformer;
    }

    public function getRepo(): DiscountRepository
    {
        return $this->repository;
    }

    public function getFilterService(): FilterServiceInterface
    {
        return $this->filterService;
    }

    public function applyFilterWithPaginate(string $transformType = 'simple')
    {
        return $this->getFilterService()
            ->getByQueryFilter($this->repository, $this->queryFilter)
            ->paginateWithTransformer($this->discountTransformer, $transformType);
    }

    public function insert($input, Product $product): Discount
    {
        $discount = new Discount();
        $discount->dynamicSet($input);
        $discount->setProduct($product);

        $this->repository->save($discount);

        return $discount;
    }

    public function update(Discount $discount, $input): Discount
    {
        $discount->dynamicSet($input);
        $this->repository->save($discount);

        return $discount;
    }
}
