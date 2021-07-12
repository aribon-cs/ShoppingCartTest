<?php

namespace App\Service;

use App\Entity\Product;
use App\Filter\QueryFilterInterface;
use App\Repository\ProductRepository;
use App\Service\Filter\FilterServiceInterface;
use App\Transformer\TransformerInterface;

class ProductService
{
    private FilterServiceInterface $filterService;
    private ProductRepository $repository;
    private QueryFilterInterface $queryFilter;
    private TransformerInterface $productTransformer;

    public function __construct(
        FilterServiceInterface $filterService,
        ProductRepository $repository,
        QueryFilterInterface $productQueryFilter,
        TransformerInterface $productTransformer
    ) {
        $this->repository = $repository;
        $this->queryFilter = $productQueryFilter;
        $this->filterService = $filterService;
        $this->productTransformer = $productTransformer;
    }

    public function getTransformer(): TransformerInterface
    {
        return $this->productTransformer;
    }

    public function getRepo(): ProductRepository
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
            ->paginateWithTransformer($this->productTransformer, $transformType);
    }

    public function insert($input): Product
    {
        $product = new Product();
        $product->dynamicSet($input);
        $this->repository->save($product);

        return $product;
    }

    public function update(Product $product, $input): Product
    {
        $product->dynamicSet($input);
        $this->repository->save($product);

        return $product;
    }
}
