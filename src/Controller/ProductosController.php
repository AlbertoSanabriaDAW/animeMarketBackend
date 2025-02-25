<?php


namespace App\Controller;

use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/productos', name: 'app_productos')]
final class ProductosController extends AbstractController
{
    #[Route('/all', name: 'app_productos_all', methods: ['GET'])]
    public function getAllProductos(ProductosRepository $productosRepository): Response
    {
        return $this->json($this->mapProductos($productosRepository->findAllProductos()));
    }

//    #[Route('/get/{id}', name: 'app_productos_get', methods: ['GET'])]
    #[Route('/get/{id}', name: 'app_productos_get', methods: ['GET'])]
    public function getProductoById(int $id, ProductosRepository $productosRepository): Response
    {
        $producto = $productosRepository->findProductoById($id);

        if (!$producto) {
            return $this->json(['error' => 'Producto no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'imagen' => $producto['imagen'],
            'descripcion' => $producto['descripcion'],
            'precio' => $producto['precio'],
            'id_tematica' => $producto['id_tematica'],
        ]);
    }

    private function mapProductos(array $productos): array
    {
        return array_map(function ($producto) {
            return [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'imagen' => $producto['imagen'],
                'descripcion' => $producto['descripcion'],
                'precio' => $producto['precio'],
                'id_tematica' => $producto['id_tematica'],
            ];
        }, $productos);
    }



    #[Route('/bobobo', name: 'app_productos_bobobo', methods: ['GET'])]
    public function getBoboboProductos(ProductosRepository $productosRepository): Response
    {
        return $this->json($this->mapProductos($productosRepository->filterProductosByTematica(1)));
    }

    #[Route('/dragonball', name: 'app_productos_dragonball', methods: ['GET'])]
    public function getDragonBallProductos(ProductosRepository $productosRepository): Response
    {
        return $this->json($this->mapProductos($productosRepository->filterProductosByTematica(2)));
    }

    #[Route('/doraemon', name: 'app_productos_doraemon', methods: ['GET'])]
    public function getDoraemonProductos(ProductosRepository $productosRepository): Response
    {
        return $this->json($this->mapProductos($productosRepository->filterProductosByTematica(3)));
    }

    #[Route('/pokemon', name: 'app_productos_pokemon', methods: ['GET'])]
    public function getPokemonProductos(ProductosRepository $productosRepository): Response
    {
        return $this->json($this->mapProductos($productosRepository->filterProductosByTematica(4)));
    }

    #[Route('/kimetsu', name: 'app_productos_kimetsu', methods: ['GET'])]
    public function getKimetsuProductos(ProductosRepository $productosRepository): Response
    {
        return $this->json($this->mapProductos($productosRepository->filterProductosByTematica(5)));
    }
}


//
//namespace App\Controller;
//
//use App\Repository\ProductosRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//
//#[Route('/productos', name: 'app_productos')]
//final class ProductosController extends AbstractController
//{
//    #[Route('/all', name: 'app_productos_all', methods: ['GET'])]
//    public function getAllProductos(ProductosRepository $productosRepository): Response
//    {
//        return $this->json($this->mapProductos($productosRepository->findAll()));
//    }
//
//    private function mapProductos(array $productos): array
//    {
//        return array_map(function ($producto) {
//            return [
//                'id' => $producto->getId(),
//                'nombre' => $producto->getNombre(),
//                'imagen' => $producto->getImagen(),
//                'descripcion' => $producto->getDescripcion(),
//                'precio' => $producto->getPrecio(),
//                'id_tematica' => $producto->getIdTematica(),
//            ];
//        }, $productos);
//    }
//
//    private function filterProductosByTematica(ProductosRepository $productosRepository, int $idTematica): array
//    {
//        return array_values(array_filter($this->mapProductos($productosRepository->findAll()), function ($producto) use ($idTematica) {
//            return $producto['id_tematica'] === $idTematica;
//        }));
//    }
//
//    #[Route('/bobobo', name: 'app_productos_bobobo', methods: ['GET'])]
//    public function getBoboboProductos(ProductosRepository $productosRepository): Response
//    {
//        return $this->json($this->filterProductosByTematica($productosRepository, 1));
//    }
//
//    #[Route('/dragonball', name: 'app_productos_dragonball', methods: ['GET'])]
//    public function getDragonBallProductos(ProductosRepository $productosRepository): Response
//    {
//        return $this->json($this->filterProductosByTematica($productosRepository, 2));
//    }
//
//    #[Route('/doraemon', name: 'app_productos_doraemon', methods: ['GET'])]
//    public function getDoraemonProductos(ProductosRepository $productosRepository): Response
//    {
//        return $this->json($this->filterProductosByTematica($productosRepository, 3));
//    }
//
//    #[Route('/pokemon', name: 'app_productos_pokemon', methods: ['GET'])]
//    public function getPokemonProductos(ProductosRepository $productosRepository): Response
//    {
//        return $this->json($this->filterProductosByTematica($productosRepository, 4));
//    }
//
//    #[Route('/kimetsu', name: 'app_productos_kimetsu', methods: ['GET'])]
//    public function getKimetsuProductos(ProductosRepository $productosRepository): Response
//    {
//        return $this->json($this->filterProductosByTematica($productosRepository, 5));
//    }
//}
