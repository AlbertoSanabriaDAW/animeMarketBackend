<?php

namespace App\Controller;

use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductosController extends AbstractController
{
    #[Route('/productos', name: 'app_productos')]
    public function index(): Response
    {
        return $this->render('productos/index.html.twig', [
            'controller_name' => 'ProductosController',
        ]);
    }
    #[Route('/all', name: 'app_productos_all', methods: ['GET'])]
    public function getAllproductos(ProductosRepository $productosRepository): Response
    {
        $listaProductos = array_map(function ($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio(),
                'id_tematica' => $producto->getIdTematica(),
            ];
        }, $productosRepository->findAll());
        return $this->json($listaProductos);
    }
}
