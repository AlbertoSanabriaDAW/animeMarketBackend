<?php

namespace App\Repository;

use App\Entity\Pedidos;
use App\Entity\Usuarios;
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

    public function findPedidosByUsuario(int $usuarioId): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.fecha, p.precio')
            ->where('p.id_usuario = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->orderBy('p.fecha', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function crearPedido(int $idCarrito, Usuarios $usuarios): void
//    {
//        $conn = $this->getEntityManager()->getConnection();
//
//        $sql = '
//            INSERT INTO pedidos (id_carrito, id_usuario, fecha, precio)
//            SELECT :idCarrito, :idUsuario, NOW(), c.total
//            FROM carritos c
//            WHERE c.id = :idCarrito
//        ';
//
//        $result = $conn->executeQuery($sql, [
//            'idCarrito' => $idCarrito,
//            'idUsuario' => $usuarios->getId(),
//        ]);
//
//        $result->fetchAllAssociative();
//    }
}

