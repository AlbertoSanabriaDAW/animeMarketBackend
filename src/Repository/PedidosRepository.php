<?php

namespace App\Repository;

use App\Entity\Pedidos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pedidos>
 */
class PedidosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pedidos::class);
    }

    public function findAllPedidos(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.fecha, p.precio, u.nick AS usuario')
            ->join('p.id_usuario', 'u')
            ->orderBy('p.fecha', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

//
//namespace App\Repository;
//
//use App\Entity\Pedidos;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Pedidos>
// */
//class PedidosRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Pedidos::class);
//    }
//
////    /**
////     * @return Pedidos[] Returns an array of Pedidos objects
////     */
////    public function findByExampleField($value): array
////    {
////        return $this->createQueryBuilder('p')
////            ->andWhere('p.exampleField = :val')
////            ->setParameter('val', $value)
////            ->orderBy('p.id', 'ASC')
////            ->setMaxResults(10)
////            ->getQuery()
////            ->getResult()
////        ;
////    }
//
////    public function findOneBySomeField($value): ?Pedidos
////    {
////        return $this->createQueryBuilder('p')
////            ->andWhere('p.exampleField = :val')
////            ->setParameter('val', $value)
////            ->getQuery()
////            ->getOneOrNullResult()
////        ;
////    }
//}
