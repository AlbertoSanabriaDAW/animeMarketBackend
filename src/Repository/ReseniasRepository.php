<?php


namespace App\Repository;

use App\Entity\Resenias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resenias>
 */
class ReseniasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resenias::class);
    }

    /**
     * @return Resenias[] Returns an array of Resenias objects
     */
    public function findAllResenias(): array
    {
        return $this->createQueryBuilder('r')
            ->select(
                'r.id',
                'IDENTITY(r.id_producto) AS id_producto',
                'IDENTITY(r.id_usuario) AS id_usuario',
                'r.comentario',
                'r.calificacion'
            )
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

//namespace App\Repository;
//
//use App\Entity\Resenias;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Resenias>
// */
//class ReseniasRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Resenias::class);
//    }
    // -------------------------------------------------------------------------

    //    /**
    //     * @return Resenias[] Returns an array of Resenias objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Resenias
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
//}
