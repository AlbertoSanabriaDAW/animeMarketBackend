<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carritos;
use App\Entity\CarritoProductos;
use App\Entity\Productos;
use App\Repository\CarritosRepository;
use App\Repository\CarritoProductosRepository;
use App\Repository\ProductosRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface; // 🔥 USO TokenStorageInterface en lugar de Security

#[Route('/carritoproductos')]
final class CarritoProductosController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private TokenStorageInterface $tokenStorage; // 🔥 Cambio de Security a TokenStorageInterface

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/all', name: 'app_carrito_productos_all', methods: ['GET'])]
    public function getAllCarritoProductos(CarritoProductosRepository $carritoProductosRepository): JsonResponse
    {
        $productos = $carritoProductosRepository->findAllCarritoProductos();
        return $this->json($productos);
    }

    #[Route('/byusuario/{usuarioId}', name: 'app_carrito_productos_by_usuario', methods: ['GET'])]
    public function getCarritoProductosByUsuario(int $usuarioId, CarritoProductosRepository $carritoProductosRepository): JsonResponse
    {
        $productos = $carritoProductosRepository->findCarritoProductosByUsuario($usuarioId);
        return $this->json($productos);
    }

    #[Route('/api/carrito/agregar', name: 'agregar_producto_carrito', methods: ['POST'])]
    public function agregarProductoAlCarrito(
        Request $request,
        CarritosRepository $carritosRepository,
        CarritoProductosRepository $carritoProductosRepository,
        ProductosRepository $productosRepository
    ): JsonResponse {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        if (!$user || !is_object($user)) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);
        $productoId = $data['id_producto'] ?? null;

        if (!$productoId) {
            return new JsonResponse(['error' => 'ID de producto no proporcionado'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Obtener el carrito del usuario
        $carrito = $carritosRepository->findOneBy(['usuario' => $user]);
        if (!$carrito) {
            return new JsonResponse(['error' => 'Carrito no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Obtener el producto
        $producto = $productosRepository->find($productoId);
        if (!$producto) {
            return new JsonResponse(['error' => 'Producto no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Verificar si el producto ya está en el carrito
        $carritoProducto = $carritoProductosRepository->findOneBy([
            'carrito' => $carrito,
            'producto' => $producto
        ]);

        if ($carritoProducto) {
            // Si ya existe, aumentar la cantidad
            $carritoProducto->setCantidad($carritoProducto->getCantidad() + 1);
        } else {
            // Si no existe, agregarlo con cantidad 1
            $carritoProducto = new CarritoProductos();
            $carritoProducto->setCarrito($carrito);
            $carritoProducto->setProducto($producto);
            $carritoProducto->setCantidad(1);

            $this->entityManager->persist($carritoProducto);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'mensaje' => 'Producto agregado al carrito con éxito',
            'producto' => [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'cantidad' => $carritoProducto->getCantidad()
            ]
        ], JsonResponse::HTTP_OK);
    }
}


//
//namespace App\Controller;
//
//use App\Repository\CarritoProductosRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//
//#[Route('/carritoproductos')]
//final class CarritoProductosController extends AbstractController
//{
//    #[Route('/all', name: 'app_carrito_productos_all', methods: ['GET'])]
//    public function getAllCarritoProductos(CarritoProductosRepository $carritoProductosRepository): JsonResponse
//    {
//        $productos = $carritoProductosRepository->findAllCarritoProductos();
//
//        return $this->json($productos);
//    }
//
//    #[Route('/byusuario/{usuarioId}', name: 'app_carrito_productos_by_usuario', methods: ['GET'])]
//    public function getCarritoProductosByUsuario(int $usuarioId, CarritoProductosRepository $carritoProductosRepository): JsonResponse
//    {
//        $productos = $carritoProductosRepository->findCarritoProductosByUsuario($usuarioId);
//
//        return $this->json($productos);
//    }
//}

