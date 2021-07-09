<?php


namespace App\Service;


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
        QueryFilterInterface $queryFilter,
        TransformerInterface $productTransformer
    )
    {
        $this->repository = $repository;
        $this->queryFilter = $queryFilter;
        $this->filterService = $filterService;
        $this->productTransformer = $productTransformer;
    }

    public function getProductTransformer(): TransformerInterface
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

    public function applyFilterWithPaginate(string $transformType='simple')
    {
        return $this->getFilterService()
            ->getByQueryFilter($this->repository, $this->queryFilter)
            ->paginateWithTransformer($this->productTransformer, $transformType);
    }

}