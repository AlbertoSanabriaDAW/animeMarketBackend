<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarritosController extends AbstractController
{
    #[Route('/carritos', name: 'app_carritos')]
    public function index(): Response
    {
        return $this->render('carritos/index.html.twig', [
            'controller_name' => 'CarritosController',
        ]);
    }
}
