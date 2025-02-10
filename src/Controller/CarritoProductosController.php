<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/carritoproductos')]
final class CarritoProductosController extends AbstractController
{
    #[Route('/all', name: 'app_carritoproductos', methods: ['GET'])]
    public function getAllCarritoProductos(CarritoProductosRepository $carritoProductosRepository): Response
    {
        $listaCarritoProductos = array_map(function ($carritoProducto) {
            return [
                'id' => $carritoProducto->getId(),
                'id_carrito' => $carritoProducto->getIdCarrito(),
                'id_producto' => $carritoProducto->getIdProducto(),
                'cantidad' => $carritoProducto->getCantidad(),
            ];
        }, $carritoProductosRepository->findAll());
        return $this->json($listaCarritoProductos);
    }
}
//final class CarritoProductosController extends AbstractController
//{
//    #[Route('/carrito/productos', name: 'app_carrito_productos')]
//    public function index(): Response
//    {
//        return $this->render('carrito_productos/index.html.twig', [
//            'controller_name' => 'CarritoProductosController',
//        ]);
//    }
//}
