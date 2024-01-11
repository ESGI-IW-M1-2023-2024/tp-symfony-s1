<?php

namespace App\Repository;

use App\Entity\Atelier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Atelier>
 *
 * @method Atelier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Atelier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Atelier[]    findAll()
 * @method Atelier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtelierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Atelier::class);
    }


    /**
     * @return Atelier[] Returns an array of Atelier objects
     */
    public function findAllOrderByLyceen(): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.lyceens', 'l')
            ->orderBy('a.id', 'l')
            ->getQuery()
            ->getResult()
        ;
    }
}
