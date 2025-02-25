<?php


namespace App\Controller;

use App\Repository\ReseniasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/resenias', name: 'app_resenias')]
final class ReseniasController extends AbstractController
{
    #[Route('/all', name: 'app_resenias_all', methods: ['GET'])]
    public function getAllResenias(ReseniasRepository $reseniasRepository): Response
    {
        return $this->json($this->mapResenias($reseniasRepository->findAllResenias()));
    }

    private function mapResenias(array $resenias): array
    {
        return array_map(function ($resenia) {
            return [
                'id' => $resenia['id'],
                'id_producto' => $resenia['id_producto'],
                'id_usuario' => $resenia['id_usuario'],
                'comentario' => $resenia['comentario'],
                'calificacion' => $resenia['calificacion'],
            ];
        }, $resenias);
    }
}

//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//
//#[Route('/resenias')]
//final class ReseniasController extends AbstractController
//{
//    #[Route('/all', name: 'app_resenias', methods: ['GET'])]
//    public function getAllResenias(ReseniasRepository $reseniasRepository): Response
//    {
//        $listaResenias = array_map(function ($resenia) {
//            return [
//                'id' => $resenia->getId(),
//                'id_producto' => $resenia->getIdProducto(),
//                'id_usuario' => $resenia->getIdUsuario(),
//                'calificacion' => $resenia->getCalificacion(),
//                'comentario' => $resenia->getComentario(),
//            ];
//        }, $reseniasRepository->findAll());
//        return $this->json($listaResenias);
//    }
//}
////final class ReseniasController extends AbstractController
////{
////    #[Route('/resenias', name: 'app_resenias')]
////    public function index(): Response
////    {
////        return $this->render('resenias/index.html.twig', [
////            'controller_name' => 'ReseniasController',
////        ]);
////    }
////}
