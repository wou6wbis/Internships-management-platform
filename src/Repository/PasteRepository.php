<?php

namespace App\Repository;

use App\Entity\Paste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Paste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paste[]    findAll()
 * @method Paste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Paste::class);
    }

//    /**
//     * @return Paste[] Returns an array of Paste objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Paste
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
