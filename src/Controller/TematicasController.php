<?php

namespace App\Controller;

use App\Repository\TematicasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/tematicas', name: 'app_tematicas')]
final class TematicasController extends AbstractController
{
    #[Route('/all', name: 'app_tematicas_all', methods: ['GET'])]
    public function getAllTematicas(TematicasRepository $tematicasRepository): Response
    {
        return $this->json($this->mapTematicas($tematicasRepository->findAllTematicas()));
    }

    private function mapTematicas(array $tematicas): array
    {
        return array_map(function ($tematica) {
            return [
                'id' => $tematica['id'],
                'nombre' => $tematica['nombre'],
            ];
        }, $tematicas);
    }
}
