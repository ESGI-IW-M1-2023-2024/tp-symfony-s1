<?php

namespace App\Repository;

use App\Entity\Lyceen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lyceen>
 *
 * @method Lyceen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lyceen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lyceen[]    findAll()
 * @method Lyceen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LyceenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lyceen::class);
    }

    public function findByLycee($idLycee): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.lycee = :val')
            ->setParameter('val', $idLycee)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByAtelier($idAtelier): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.atelier = :val')
            ->setParameter('val', $idAtelier)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Lyceen[] Returns an array of Lyceen objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Lyceen
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
