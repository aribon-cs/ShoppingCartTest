<?php

namespace App\Traits;

use App\Filter\QueryFilterInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Trait Filterable.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
trait Filterable
{
    public function getResultByQueryFilter(QueryFilterInterface $filter, array $data)
    {
        /*
         * @var ServiceEntityRepository $this
         */
        $filter->apply($this, $data);

        return $filter->getResult();
    }

    public function getQueryByQueryFilter(QueryFilterInterface $filter, array $data): Query
    {
        /*
         * @var ServiceEntityRepository $this
         */
        $filter->apply($this, $data);

        return $filter->getBuilder()->getQuery();
    }

    public function getBuilderByQueryFilter(QueryFilterInterface $filter, array $data): QueryBuilder
    {
        /*
         * @var ServiceEntityRepository $this
         */
        $filter->apply($this, $data);

        return $filter->getBuilder();
    }
}
