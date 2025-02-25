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
