<?php

namespace App\Repository;

use App\Entity\CarritoProductos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarritoProductos>
 */
class CarritoProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarritoProductos::class);
    }

    /**
     * Obtiene todos los productos en el carrito con sus detalles
     * @return CarritoProductos[]
     */
    public function findAllCarritoProductos(): array
    {
        return $this->createQueryBuilder('cp')
            ->select('cp', 'c', 'p')
            ->leftJoin('cp.carrito', 'c')
            ->leftJoin('cp.producto', 'p')
            ->orderBy('cp.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

//
//namespace App\Repository;
//
//use App\Entity\CarritoProductos;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<CarritoProductos>
// */
//class CarritoProductosRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, CarritoProductos::class);
//    }
//
//    //    /**
//    //     * @return CarritoProductos[] Returns an array of CarritoProductos objects
//    //     */
//    //    public function findByExampleField($value): array
//    //    {
//    //        return $this->createQueryBuilder('c')
//    //            ->andWhere('c.exampleField = :val')
//    //            ->setParameter('val', $value)
//    //            ->orderBy('c.id', 'ASC')
//    //            ->setMaxResults(10)
//    //            ->getQuery()
//    //            ->getResult()
//    //        ;
//    //    }
//
//    //    public function findOneBySomeField($value): ?CarritoProductos
//    //    {
//    //        return $this->createQueryBuilder('c')
//    //            ->andWhere('c.exampleField = :val')
//    //            ->setParameter('val', $value)
//    //            ->getQuery()
//    //            ->getOneOrNullResult()
//    //        ;
//    //    }
//}
