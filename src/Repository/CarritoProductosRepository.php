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
     * Obtiene todos los productos en los carritos con información detallada.
     */
    public function findAllCarritoProductos(): array
    {
        return $this->createQueryBuilder('cp')
            ->select('cp.id, c.id AS id_carrito, u.id AS id_usuario, p.id AS id_producto, p.nombre, p.precio, cp.cantidad')
            ->innerJoin('cp.carrito', 'c')
            ->innerJoin('c.usuario', 'u')
            ->innerJoin('cp.producto', 'p')
            ->orderBy('cp.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene los productos en el carrito de un usuario específico.
     */
    public function findCarritoProductosByUsuario(int $usuarioId): array
    {
        return $this->createQueryBuilder('cp')
            ->select('cp.id, c.id AS id_carrito, u.id AS id_usuario, p.id AS id_producto, p.nombre, p.precio, cp.cantidad')
            ->innerJoin('cp.carrito', 'c')
            ->innerJoin('c.usuario', 'u')
            ->innerJoin('cp.producto', 'p')
            ->where('u.id = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->orderBy('cp.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}



