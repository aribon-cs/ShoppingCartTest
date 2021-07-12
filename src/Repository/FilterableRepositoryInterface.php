<?php

namespace App\Repository;

use App\Filter\QueryFilterInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface FilterableRepositoryInterface
{
    public function getResultByQueryFilter(QueryFilterInterface $filter, array $data);

    public function getQueryByQueryFilter(QueryFilterInterface $filter, array $data): Query;

    public function getBuilderByQueryFilter(QueryFilterInterface $filter, array $data): QueryBuilder;
}
