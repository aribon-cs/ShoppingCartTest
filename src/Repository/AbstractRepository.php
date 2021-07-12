<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class AbstractRepository.
 *
 * @author Saeed Jazei <cs.jazei@gmail.com>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @param $object
     *
     * @throws ORMException
     */
    public function save($object): void
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    public function getEntityByPage($page, $perPage = 100, $orderColumn = 'id')
    {
        return
            $this->createQueryBuilder('q')
                ->select('q')
                ->orderBy("q.$orderColumn", 'ASC')
                ->setMaxResults($perPage)
                ->setFirstResult($perPage * $page)
                ->getQuery()
                ->getResult();
    }

    public function getEntityCountAllById(): int
    {
        try {
            return intval($this
                ->createQueryBuilder('q')
                ->select('COUNT(q.id)')
                ->getQuery()
                ->getSingleScalarResult());
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function findManyByIds(array $ids, string $field = 'id')
    {
        return
            $this->createQueryBuilder('q')
                ->where("q.$field in ( :ids )")
                ->setParameter('ids', $ids)
                ->getQuery()
                ->getResult();
    }

    // /**
    //  * @return RenderProp[] Returns an array of RenderProp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RenderProp
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
