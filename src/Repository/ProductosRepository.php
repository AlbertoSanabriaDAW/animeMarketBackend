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

    /**
     * Obtener un producto por su ID
     *
     * @param int $id
     * @return array|null
     */
    public function findProductoById(int $id): ?array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.nombre, p.imagen, p.descripcion, p.precio, p.id_tematica')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
