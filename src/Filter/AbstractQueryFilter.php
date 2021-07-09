<?php

namespace App\Filter;

use App\Helpers\Helpers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class QueryFilter.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
abstract class AbstractQueryFilter
{

    protected array $data;

    protected QueryBuilder $builder;

    public function apply(ServiceEntityRepository $entityRepository, array $data): void
    {
        $this->builder = $entityRepository->createQueryBuilder('filter');
        $this->data = $data;

        if (isset($this->data['ManyIds'])) {
            if (method_exists($this, 'ManyIds')) {
                $manyIDs =
                    'string' == gettype($this->data['ManyIds']) ?
                        (array) explode(',', $this->data['ManyIds']) :
                        $this->data['ManyIds'];

                $manyIDs = array_map(function ($row) {
                    return (int) $row;
                }, $manyIDs);
                call_user_func_array([$this, 'ManyIds'], [$manyIDs]);

                unset($this->data['ManyIds']);
            }
        }

        foreach ($this->fields() as $field => $value) {
            $method = Helpers::convertToCamelCaseStatic($field);
            if (method_exists($this, $method)) {
                if (strpos($value, '|')) {
                    call_user_func_array([$this, $method], [explode('|', $value)]);
                } else {
                    call_user_func_array([$this, $method], (array) explode(',', $value));
                }
            }
        }

        if (method_exists($this, 'defaultFilter')) {
            foreach (call_user_func([$this, 'defaultFilter']) as $method => $value) {
                if (!array_key_exists($method, $this->fields())) {
                    call_user_func_array([$this, $method], (array) explode(',', $value));
                }
            }
        }
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return array_filter(
            array_map(function ($input) {
                if (!is_array($input)) {
                    return trim($input);
                }
                if (sizeof($input) > 0) {
                    return $input;
                }

                return null;
            }, $this->data),
            function ($value) {
                return null !== $value && false !== $value && '' !== $value;
            }
        );
    }

    /**
     * override this method to have a default filter if user not send any query filter.
     *
     * example:
     * <code>
     *  public function defaultFilter(): array
     * {
     *      return [
     *          'order'=> 'id,ASC' ,
     *          'active'=>true ,
     *      ];
     * }
     * </code>
     */
    public function defaultFilter(): array
    {
        return [];
    }

    /**
     * Limit
     * be aware => this will override by paginator!
     *
     * @param $number
     */
    public function limit($number): void
    {
        $this->builder->setMaxResults($number);
    }

    /**
     * Order By.
     *
     * @param $field
     * @param string $order
     */
    public function order($field, $order = 'DESC'): void
    {
        $this->builder->orderBy('filter.'.$field, $order);
    }

    /**
     * Add Order By.
     *
     * @param $field
     * @param string $order
     */
    public function orderP($field, $order = 'DESC'): void
    {
        $this->builder->addOrderBy('filter.'.$field, $order);
    }

    /**
     * Group By.
     *
     * @param $field
     */
    public function group($field): void
    {
        $this->builder->groupBy('filter.'.$field);
    }

    /**
     * Add Group By.
     *
     * @param $field
     */
    public function groupP($field): void
    {
        $this->builder->addGroupBy('filter.'.$field);
    }

    /**
     * find many by ids.
     * @param array $ids
     */
    public function ManyIds(array $ids): void
    {
        $this->builder->andWhere('filter.id  IN (:ids)')
            ->setParameter('ids', $ids);
    }

    public function createdFrom(string $createdAt): void
    {
        $createdAt = new \DateTime("$createdAt");

        $this->builder->andWhere('filter.createdAt >= :createdAt')
            ->setParameter('createdAt', $createdAt);
    }

    public function createdUntil(string $createdUntil): void
    {
        $createdUntil = new \DateTime("$createdUntil");

        $this->builder->andWhere('filter.createdAt <= :createdUntil')
            ->setParameter('createdUntil', $createdUntil);
    }

    public function updatedFrom(string $updatedFrom): void
    {
        $updatedFrom = new \DateTime("$updatedFrom");

        $this->builder->andWhere('filter.updatedAt >= :updatedAt')
            ->setParameter('updatedAt', $updatedFrom);
    }

    public function updatedUntil(string $updatedFrom): void
    {
        $updatedFrom = new \DateTime("$updatedFrom");

        $this->builder->andWhere('filter.updatedAt <= :updatedAtUntil')
            ->setParameter('updatedAtUntil', $updatedFrom);
    }

    public function getBuilder(): QueryBuilder
    {
        return $this->builder;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->builder->getQuery()->getResult();
    }
}
