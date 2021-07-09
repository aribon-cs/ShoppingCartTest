<?php


namespace App\Filter;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

interface QueryFilterInterface
{
    public function apply(ServiceEntityRepository $entityRepository, array $data): void;

}