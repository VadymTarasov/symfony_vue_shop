<?php

namespace App\Utils\Manager;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractBaseManager
{

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @return ObjectRepository
     */
    abstract public function getRepository(): ObjectRepository;

    /**
     * @param Object $entity
     * @return void
     */
    public function save(Object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

//    /**
//     * @param object $entity
//     */
//    public function remove(object $entity): void
//    {
//        $this->entityManager->remove($entity);
//        $this->entityManager->flush();
//    }

    /**
     * @param string $id
     * @return object|null
     */
    public function find(string $id): ?object
    {
        return $this->getRepository()->find($id);
    }

}