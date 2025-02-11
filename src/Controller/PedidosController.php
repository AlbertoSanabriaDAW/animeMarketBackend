<?php

namespace App\Controller;

use App\Repository\PedidosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pedidos', name: 'app_pedidos')]
final class PedidosController extends AbstractController
{
    #[Route('/all', name: 'app_pedidos_all', methods: ['GET'])]
    public function getAllPedidos(PedidosRepository $pedidosRepository): Response
    {
        return $this->json($pedidosRepository->findAllPedidos());
    }

    #[Route('/usuario/{id}', name: 'app_pedidos_usuario', methods: ['GET'])]
    public function getPedidosByUsuario(int $id, PedidosRepository $pedidosRepository): Response
    {
        return $this->json($pedidosRepository->findPedidosByUsuario($id));
    }
}

//// FUNCIONA PERO AÑADO COSAS ARRIBA
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//#[Route('/pedidos')]
//final class PedidosController extends AbstractController
//{
//    #[Route('/all', name: 'app_pedidos', methods: ['GET'])]
//    public function getAllPedidos(PedidosRepository $pedidosRepository): Response
//    {
//        $listaPedidos = array_map(function ($pedido) {
//            return [
//                'id' => $pedido->getId(),
//                'precio' => $pedido->getPrecio(),
//                'fecha' => $pedido->getFecha(),
//                'id_usuario' => $pedido->getIdUsuario(),
//                'id_carrito' => $pedido->getIdCarrito(),
//            ];
//        }, $pedidosRepository->findAll());
//        return $this->json($listaPedidos);
//    }
//}
//final class PedidosController extends AbstractController
//{
//    #[Route('/pedidos', name: 'app_pedidos')]
//    public function index(): Response
//    {
//        return $this->render('pedidos/index.html.twig', [
//            'controller_name' => 'PedidosController',
//        ]);
//    }
//}

