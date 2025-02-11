<?php

namespace App\Controller;

use App\Repository\CarritosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carritos')]
final class CarritosController extends AbstractController
{
    #[Route('/all', name: 'app_carritos_all', methods: ['GET'])]
    public function getAllCarritos(CarritosRepository $carritosRepository): JsonResponse
    {
        return $this->json($carritosRepository->findAllCarritos());
    }

    #[Route('/byusuario/{usuarioId}', name: 'app_carritos_by_usuario', methods: ['GET'])]
    public function getCarritosByUsuario(CarritosRepository $carritosRepository, int $usuarioId): JsonResponse
    {
        return $this->json($carritosRepository->findCarritosByUsuario($usuarioId));
    }
}

//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//#[Route('/carritos')]
//final class CarritosController extends AbstractController
//{
//    #[Route('/all', name: 'app_carritos', methods: ['GET'])]
//    public function getAllCarritos(CarritosRepository $carritosRepository): Response
//    {
//        $listaCarritos = array_map(function ($carrito) {
//            return [
//                'id' => $carrito->getId(),
//                'id_usuario' => $carrito->getIdUsuario(),
//                'estado' => $carrito->getEstado(),
//            ];
//        }, $carritosRepository->findAll());
//        return $this->json($listaCarritos);
//    }
//}
////final class CarritosController extends AbstractController
////{
////    #[Route('/carritos', name: 'app_carritos')]
////    public function index(): Response
////    {
////        return $this->render('carritos/index.html.twig', [
////            'controller_name' => 'CarritosController',
////        ]);
////    }
////}
