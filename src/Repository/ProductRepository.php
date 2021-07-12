<?php

namespace App\Repository;

use App\Entity\Product;
use App\Traits\FilterableTrait;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractRepository implements FilterableRepositoryInterface
{
    use FilterableTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getExistIds(array $ids)
    {
        return $this->createQueryBuilder('q')
            ->select('q.id')
            ->where('q.id in ( :ids )')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getArrayResult();
    }

    // todo : change to get union left & inner
    public function findWithDiscounts(array $ids)
    {
        // join and select to prevent n+1 problem!
        return $this->createQueryBuilder('q')
            ->innerJoin('q.discounts', 'd')
            ->addSelect('d')
            ->where('q.id in ( :ids )')
            ->orderBy('q.id', 'DESC')
            ->addOrderBy('d.number', 'DESC')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult()
            ;
    }
}
