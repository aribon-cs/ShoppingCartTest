<?php

namespace App\DataFixtures;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use LogicException;

abstract class BaseFixtures extends Fixture implements FixtureGroupInterface
{
    private ?ObjectManager $manager;

    protected Generator $faker;

    private array $referencesIndex = [];

    abstract protected function loadData(ObjectManager $manager): void;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    /**
     * Create many objects at once:.
     *
     *      $this->createMany(10, function(int $i) {
     *          $user = new User();
     *          $user->setFirstName('Ryan');
     *
     *           return $user;
     *      });
     *
     * @param string $groupName tag these created objects with this group name,
     *                          and use this later with getRandomReference(s)
     *                          to fetch only from this specific group
     */
    protected function createMany(int $count, string $groupName, callable $factory): void
    {
        for ($i = 0; $i < $count; ++$i) {
            $entity = $factory($i);
            if (null === $entity) {
                throw new LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }
            $this->manager->persist($entity);
            // store for usage later as groupName_#COUNT#
            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }

    protected function getRandomReference(string $groupName)
    {
        if (!isset($this->referencesIndex[$groupName])) {
            $this->referencesIndex[$groupName] = [];
            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (0 === strpos($key, $groupName.'_')) {
                    $this->referencesIndex[$groupName][] = $key;
                }
            }
        }
        if (empty($this->referencesIndex[$groupName])) {
            throw new InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"', $groupName));
        }
        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$groupName]);

        return $this->getReference($randomReferenceKey);
    }

    protected function getRandomReferences(string $className, int $count)
    {
        $references = [];
        while (count($references) < $count) {
            $references[] = $this->getRandomReference($className);
        }

        return $references;
    }

    /**
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    protected function getRandomEntity(ServiceEntityRepository $repository)
    {
        return $this->getQueryForRandomEntity($repository, 1)->getSingleResult(AbstractQuery::HYDRATE_OBJECT);
    }

    /**
     * @return mixed
     */
    protected function getRandomEntities(ServiceEntityRepository $repository, int $number = 1)
    {
        return $this->getQueryForRandomEntity($repository, $number)->getResult();
    }

    protected function getQueryForRandomEntity(ServiceEntityRepository $repository, int $number = 1)
    {
        $rows =
            $repository
                ->createQueryBuilder('q')
                ->select('COUNT(q.id)')
                ->getQuery()
                ->getSingleScalarResult();
        $offset = max(0, rand(0, $rows - $number - 1));

        return $repository
            ->createQueryBuilder('q')
            ->setMaxResults($number)
            ->setFirstResult($offset)
            ->getQuery();
    }
}
