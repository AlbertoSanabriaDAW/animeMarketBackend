<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/resenias')]
final class ReseniasController extends AbstractController
{
    #[Route('/all', name: 'app_resenias', methods: ['GET'])]
    public function getAllResenias(ReseniasRepository $reseniasRepository): Response
    {
        $listaResenias = array_map(function ($resenia) {
            return [
                'id' => $resenia->getId(),
                'id_producto' => $resenia->getIdProducto(),
                'id_usuario' => $resenia->getIdUsuario(),
                'calificacion' => $resenia->getCalificacion(),
                'comentario' => $resenia->getComentario(),
            ];
        }, $reseniasRepository->findAll());
        return $this->json($listaResenias);
    }
}
//final class ReseniasController extends AbstractController
//{
//    #[Route('/resenias', name: 'app_resenias')]
//    public function index(): Response
//    {
//        return $this->render('resenias/index.html.twig', [
//            'controller_name' => 'ReseniasController',
//        ]);
//    }
//}
