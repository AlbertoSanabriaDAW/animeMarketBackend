<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/pedidos')]
final class PedidosController extends AbstractController
{
    #[Route('/all', name: 'app_pedidos', methods: ['GET'])]
    public function getAllPedidos(PedidosRepository $pedidosRepository): Response
    {
        $listaPedidos = array_map(function ($pedido) {
            return [
                'id' => $pedido->getId(),
                'precio' => $pedido->getPrecio(),
                'fecha' => $pedido->getFecha(),
                'id_usuario' => $pedido->getIdUsuario(),
                'id_carrito' => $pedido->getIdCarrito(),
            ];
        }, $pedidosRepository->findAll());
        return $this->json($listaPedidos);
    }
}
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

