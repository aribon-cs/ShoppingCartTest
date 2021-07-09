<?php


namespace App\Service\Filter;


use App\Filter\QueryFilterInterface;
use App\Repository\FilterableRepositoryInterface;
use App\Transformer\TransformerInterface;

interface FilterServiceInterface
{
    public function paginateWithTransformer(
        TransformerInterface $serviceTransformer,
        string $paginatorType = 'simple',
        array $extra = []
    ): array;

    public function getByQueryFilter(FilterableRepositoryInterface $repository, QueryFilterInterface $filter);
}