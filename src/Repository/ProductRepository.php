<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $container;

    public function __construct(RegistryInterface $registry, Container $container)
    {
        parent::__construct($registry, Product::class);

        $this->container = $container;
    }

    public function getListProducts($page = 1) {
        $paginator = $this->container->get('knp_paginator');

        dump($page);

        $query = $this->createQueryBuilder('p')
            ->setMaxResults(10)
            ->addOrderBy('p.id', 'DESC')
            ->getQuery();

        return $paginator->paginate($query, $page, 1);
    }
}
