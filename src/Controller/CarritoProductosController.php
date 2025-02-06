<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarritoProductosController extends AbstractController
{
    #[Route('/carrito/productos', name: 'app_carrito_productos')]
    public function index(): Response
    {
        return $this->render('carrito_productos/index.html.twig', [
            'controller_name' => 'CarritoProductosController',
        ]);
    }
}
