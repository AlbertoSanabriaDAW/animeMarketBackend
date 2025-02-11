<?php

namespace App\Controller;

use App\Repository\CarritoProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carritoproductos')]
final class CarritoProductosController extends AbstractController
{
    #[Route('/all', name: 'app_carrito_productos_all', methods: ['GET'])]
    public function getAllCarritoProductos(CarritoProductosRepository $carritoProductosRepository): JsonResponse
    {
        $productos = $carritoProductosRepository->findAllCarritoProductos();

        $response = array_map(function ($item) {
            return [
                'id' => $item->getId(),
                'carrito' => [
                    'id' => $item->getCarrito()->getId(),
                    'usuario' => $item->getCarrito()->getIdUsuario()->getId(),
                ],
                'producto' => [
                    'id' => $item->getProducto()->getId(),
                    'nombre' => $item->getProducto()->getNombre(),
                    'precio' => $item->getProducto()->getPrecio(),
                ],
                'cantidad' => $item->getCantidad(),
            ];
        }, $productos);

        return $this->json($response);
    }
}

//
//namespace App\Repository;
//
//use App\Entity\CarritoProductos;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<CarritoProductos>
// */
//class CarritoProductosRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, CarritoProductos::class);
//    }
//
//    /**
//     * Obtiene todos los productos en los carritos con información detallada.
//     */
//    public function findAllCarritoProductos(): array
//    {
//        return $this->createQueryBuilder('cp')
//            ->select('cp.id, c.id AS id_carrito, p.id AS id_producto, p.nombre, p.precio, cp.cantidad')
//            ->innerJoin('cp.idCarrito', 'c')
//            ->innerJoin('cp.idProducto', 'p')
//            ->orderBy('cp.id', 'ASC')
//            ->getQuery()
//            ->getResult();
//    }
//}
//
////
////namespace App\Controller;
////
////use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
////use Symfony\Component\HttpFoundation\Response;
////use Symfony\Component\Routing\Attribute\Route;
////#[Route('/carritoproductos')]
////final class CarritoProductosController extends AbstractController
////{
////    #[Route('/all', name: 'app_carritoproductos', methods: ['GET'])]
////    public function getAllCarritoProductos(CarritoProductosRepository $carritoProductosRepository): Response
////    {
////        $listaCarritoProductos = array_map(function ($carritoProducto) {
////            return [
////                'id' => $carritoProducto->getId(),
////                'id_carrito' => $carritoProducto->getIdCarrito(),
////                'id_producto' => $carritoProducto->getIdProducto(),
////                'cantidad' => $carritoProducto->getCantidad(),
////            ];
////        }, $carritoProductosRepository->findAll());
////        return $this->json($listaCarritoProductos);
////    }
////}
//////final class CarritoProductosController extends AbstractController
//////{
//////    #[Route('/carrito/productos', name: 'app_carrito_productos')]
//////    public function index(): Response
//////    {
//////        return $this->render('carrito_productos/index.html.twig', [
//////            'controller_name' => 'CarritoProductosController',
//////        ]);
//////    }
//////}
