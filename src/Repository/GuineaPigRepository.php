<?php

namespace App\Repository;

use App\Entity\GuineaPig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GuineaPig>
 *
 * @method GuineaPig|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuineaPig|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuineaPig[]    findAll()
 * @method GuineaPig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuineaPigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuineaPig::class);
    }

//    /**
//     * @return GuineaPig[] Returns an array of GuineaPig objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GuineaPig
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
