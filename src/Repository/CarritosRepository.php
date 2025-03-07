<?php

namespace App\Repository;

use App\Entity\Carritos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carritos>
 */
class CarritosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carritos::class);
    }

    /**
     * Obtiene todos los carritos con información detallada.
     */
    public function findAllCarritos(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, u.id AS id_usuario, c.estado')
            ->innerJoin('c.usuario', 'u')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene los carritos de un usuario específico.
     */
    public function findCarritosByUsuario(int $usuarioId): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, u.id AS id_usuario, c.estado')
            ->innerJoin('c.usuario', 'u')
            ->where('u.id = :usuarioId')
            ->setParameter('usuarioId', $usuarioId)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}


