<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/carritos')]
final class CarritosController extends AbstractController
{
    #[Route('/all', name: 'app_carritos', methods: ['GET'])]
    public function getAllCarritos(CarritosRepository $carritosRepository): Response
    {
        $listaCarritos = array_map(function ($carrito) {
            return [
                'id' => $carrito->getId(),
                'id_usuario' => $carrito->getIdUsuario(),
                'estado' => $carrito->getEstado(),
            ];
        }, $carritosRepository->findAll());
        return $this->json($listaCarritos);
    }
}
//final class CarritosController extends AbstractController
//{
//    #[Route('/carritos', name: 'app_carritos')]
//    public function index(): Response
//    {
//        return $this->render('carritos/index.html.twig', [
//            'controller_name' => 'CarritosController',
//        ]);
//    }
//}
