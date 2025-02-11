<?php

namespace App\Repository;

use App\Entity\Tematicas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tematicas>
 */
class TematicasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tematicas::class);
    }

    /**
     * @return Tematicas[] Returns an array of Tematicas objects
     */
    public function findAllTematicas(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.id, t.nombre')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

// // 1 -----------------------------------------------------------------------------
//namespace App\Repository;
//
//use App\Entity\Tematicas;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Tematicas>
// */
//class TematicasRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Tematicas::class);
//    }
    // 2--------------------------------------------------------------------------

    //    /**
    //     * @return Tematicas[] Returns an array of Tematicas objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tematicas
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

