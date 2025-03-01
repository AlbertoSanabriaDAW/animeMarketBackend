<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Carritos;
use App\Entity\Usuarios;
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

    #[Route('/comprar/{carritoId}', name: 'app_comprar_carrito', methods: ['POST'])]
    public function comprarCarrito(
        int                        $carritoId,
        CarritosRepository         $carritosRepository,
        CarritoProductosRepository $carritoProductosRepository,
        ProductosRepository        $productosRepository,
        PedidosRepository          $pedidosRepository,
        EntityManagerInterface     $entityManager
    ): JsonResponse {

        /** @var Usuarios $usuario */
        $usuario = $this->getUser();

        // Buscar el carrito activo del usuario
        $carrito = $carritosRepository->findOneBy(['id' => $carritoId, 'estado' => 0]);

        if (!$carrito) {
            return new JsonResponse(['error' => 'No se encontró un carrito activo para el usuario'], Response::HTTP_BAD_REQUEST);
        }

        // Obtener productos del carrito
        $carritoProductos = $carritoProductosRepository->findBy(['carrito' => $carrito->getId()]);
        if (!$carritoProductos) {
            return new JsonResponse(['error' => 'El carrito está vacío'], Response::HTTP_BAD_REQUEST);
        }

        $precioTotal = 0;
        foreach ($carritoProductos as $carritoProducto) {
            $producto = $productosRepository->find($carritoProducto->getProducto()->getId());
            if ($producto) {
                $precioTotal += $producto->getPrecio() * $carritoProducto->getCantidad();
            }
        }

        // Crear un nuevo pedido
        $pedido = new Pedidos();
        $pedido->setIdUsuario($usuario);
        $pedido->setFecha(new \DateTime());
        $pedido->setPrecio($precioTotal);
        $pedido->setCarritos($carrito);

        $entityManager->persist($pedido);

        // Marcar el carrito como finalizado
        $carrito->setEstado(1);
        $entityManager->persist($carrito);

        // Guardar cambios en la base de datos
        $entityManager->flush();

        return new JsonResponse(['message' => 'Compra realizada con éxito', 'pedidoId' => $pedido->getId()], Response::HTTP_OK);
    }
}


