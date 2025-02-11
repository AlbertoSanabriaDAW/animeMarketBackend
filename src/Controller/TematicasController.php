<?php

namespace App\Controller;

use App\Repository\TematicasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tematicas', name: 'app_tematicas')]
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

//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;

//final class TematicasController extends AbstractController
//{
//    #[Route('/tematicas', name: 'app_tematicas')]
//    public function index(): Response
//    {
//        return $this->render('tematicas/index.html.twig', [
//            'controller_name' => 'TematicasController',
//        ]);
//    }
//}

//#[Route('/tematicas', name: 'app_tematicas')]
//final class TematicasController extends AbstractController
//{
//    #[Route('/all', name: 'app_tematicas', methods: ['GET'])]
//    public function getAlltematicas(TematicasRepository $tematicasRepository): Response
//    {
//        $listaTematicas = array_map(function ($tematica) {
//            return [
//                'id' => $tematica->getId(),
//                'nombre' => $tematica->getNombre(),
//            ];
//        }, $tematicasRepository->findAll());
//        return $this->json($listaTematicas);
//    }
//}
