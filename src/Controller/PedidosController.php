<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Carritos;
use App\Repository\PedidosRepository;
use App\Repository\CarritosRepository;
use App\Repository\CarritoProductosRepository;
use App\Repository\ProductosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/pedidos', name: 'app_pedidos')]
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

    #[Route('/comprar/{usuarioId}', name: 'app_comprar_carrito', methods: ['POST'])]
    public function comprarCarrito(
        int $usuarioId,
        CarritosRepository $carritosRepository,
        CarritoProductosRepository $carritoProductosRepository,
        ProductosRepository $productosRepository,
        PedidosRepository $pedidosRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        // Buscar el carrito activo del usuario
        $carrito = $carritosRepository->findOneBy(['id_usuario' => $usuarioId, 'estado' => 'activo']);

        if (!$carrito) {
            return new JsonResponse(['error' => 'No se encontró un carrito activo para el usuario'], Response::HTTP_BAD_REQUEST);
        }

        // Obtener productos del carrito
        $carritoProductos = $carritoProductosRepository->findBy(['id_carrito' => $carrito->getId()]);
        if (!$carritoProductos) {
            return new JsonResponse(['error' => 'El carrito está vacío'], Response::HTTP_BAD_REQUEST);
        }

        $precioTotal = 0;
        foreach ($carritoProductos as $carritoProducto) {
            $producto = $productosRepository->find($carritoProducto->getIdProducto()->getId());
            if ($producto) {
                $precioTotal += $producto->getPrecio() * $carritoProducto->getCantidad();
            }
        }

        // Crear un nuevo pedido
        $pedido = new Pedidos();
        $pedido->setIdUsuario($carrito->getIdUsuario());
        $pedido->setFecha(new \DateTime());
        $pedido->setPrecio($precioTotal);

        $entityManager->persist($pedido);

        // Marcar el carrito como finalizado
        $carrito->setEstado('finalizado');
        $entityManager->persist($carrito);

        // Guardar cambios en la base de datos
        $entityManager->flush();

        return new JsonResponse(['message' => 'Compra realizada con éxito', 'pedidoId' => $pedido->getId()], Response::HTTP_OK);
    }
}
//// ---------------------------------------------------------------------------------------------------------------------
//// ESTO DE ABAJO VA PERO AÑADO FUNCIONES ARRIBA --------------------------------------------------------------
//namespace App\Controller;
//
//use App\Repository\PedidosRepository;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//
//#[Route('/pedidos', name: 'app_pedidos')]
//final class PedidosController extends AbstractController
//{
//    #[Route('/all', name: 'app_pedidos_all', methods: ['GET'])]
//    public function getAllPedidos(PedidosRepository $pedidosRepository): Response
//    {
//        return $this->json($pedidosRepository->findAllPedidos());
//    }
//
//    #[Route('/usuario/{id}', name: 'app_pedidos_usuario', methods: ['GET'])]
//    public function getPedidosByUsuario(int $id, PedidosRepository $pedidosRepository): Response
//    {
//        return $this->json($pedidosRepository->findPedidosByUsuario($id));
//    }
//}
/// ---------------------------------------------------------------------------------------------------------------------
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

