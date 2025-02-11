<?php

namespace App\Controller;

use App\Repository\CarritosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carritos', name: 'app_carritos')]
final class CarritosController extends AbstractController
{
    #[Route('/all', name: 'app_carritos_all', methods: ['GET'])]
    public function getAllCarritos(CarritosRepository $carritosRepository): Response
    {
        return $this->json($this->mapCarritos($carritosRepository->findAllCarritos()));
    }

    private function mapCarritos(array $carritos): array
    {
        return array_map(function ($carrito) {
            return [
                'id' => $carrito['id'],
                'id_usuario' => $carrito['id_usuario'],
            ];
        }, $carritos);
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
