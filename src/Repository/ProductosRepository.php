<?php


namespace App\Repository;

use App\Entity\Productos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Productos>
 */
class ProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productos::class);
    }

    /**
     * @return Productos[] Returns an array of Productos objects
     */
    public function findAllProductos(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.nombre, p.imagen, p.descripcion, p.precio, p.id_tematica')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Filtrar productos por temática
     *
     * @param int $idTematica
     * @return array
     */
    public function filterProductosByTematica(int $idTematica): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.nombre, p.imagen, p.descripcion, p.precio, p.id_tematica')
            ->where('p.id_tematica = :idTematica')
            ->setParameter('idTematica', $idTematica)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

// 2----------------------------------------------------------------------------
//namespace App\Repository;
//
//use App\Entity\Productos;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Productos>
// */
//class ProductosRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Productos::class);
//    }
//
//    /**
//     * @return Productos[] Returns an array of Productos objects
//     */
//    public function findAllProductos(): array
//    {
//        return $this->createQueryBuilder('p')
//            ->select('p.id, p.nombre, p.imagen, p.descripcion, p.precio, p.id_tematica')
//            ->orderBy('p.id', 'ASC')
//            ->getQuery()
//            ->getResult();
//    }
//}



//1----------------------------------------------------------------------------
//namespace App\Repository;
//
//use App\Entity\Productos;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Productos>
// */
//class ProductosRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Productos::class);
//    }

    //2----------------------------------------------------------------------------

//    /**
//     * @return Productos[] Returns an array of Productos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Productos
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//}
