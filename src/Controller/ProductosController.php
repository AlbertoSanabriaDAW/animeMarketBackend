<?php

namespace App\Controller;

use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/productos', name: 'app_productos')]
final class ProductosController extends AbstractController
{
//    #[Route('/productos', name: 'app_productos')]
//    public function index(): Response
//    {
//        return $this->render('productos/index.html.twig', [
//            'controller_name' => 'ProductosController',
//        ]);
//    }
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
    #[Route('/bobobo', name: 'app_productos_bobobo', methods: ['GET'])]
    public function getBoboboproductos(ProductosRepository $productosRepository): Response
    {
        $listaProductos = array_filter(array_map(function ($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio(),
                'id_tematica' => $producto->getIdTematica(),
            ];
        }, $productosRepository->findAll()), function ($producto) {
            return $producto['id_tematica'] == 1;
        });

        return $this->json(array_values($listaProductos));
    }

    #[Route('/dragonball', name: 'app_productos_dragonball', methods: ['GET'])]
    public function getDragonballproductos(ProductosRepository $productosRepository): Response
    {
        $listaProductos = array_filter(array_map(function ($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio(),
                'id_tematica' => $producto->getIdTematica(),
            ];
        }, $productosRepository->findAll()), function ($producto) {
            return $producto['id_tematica'] == 2;
        });

        return $this->json(array_values($listaProductos));
    }
    #[Route('/doraemon', name: 'app_productos_doraemon', methods: ['GET'])]
    public function getDoraemonproductos(ProductosRepository $productosRepository): Response
    {
        $listaProductos = array_filter(array_map(function ($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio(),
                'id_tematica' => $producto->getIdTematica(),
            ];
        }, $productosRepository->findAll()), function ($producto) {
            return $producto['id_tematica'] == 3;
        });

        return $this->json(array_values($listaProductos));
    }
    #[Route('/pokemon', name: 'app_productos_pokemon', methods: ['GET'])]
    public function getPokemonproductos(ProductosRepository $productosRepository): Response
    {
        $listaProductos = array_filter(array_map(function ($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio(),
                'id_tematica' => $producto->getIdTematica(),
            ];
        }, $productosRepository->findAll()), function ($producto) {
            return $producto['id_tematica'] == 4;
        });

        return $this->json(array_values($listaProductos));
    }

    #[Route('/kimetsu', name: 'app_productos_kimetsu', methods: ['GET'])]
    public function getKimetsuproductos(ProductosRepository $productosRepository): Response
    {
        $listaProductos = array_filter(array_map(function ($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'descripcion' => $producto->getDescripcion(),
                'precio' => $producto->getPrecio(),
                'id_tematica' => $producto->getIdTematica(),
            ];
        }, $productosRepository->findAll()), function ($producto) {
            return $producto['id_tematica'] == 5;
        });

        return $this->json(array_values($listaProductos));
    }

}
