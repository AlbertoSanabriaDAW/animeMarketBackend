<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReseniasController extends AbstractController
{
    #[Route('/resenias', name: 'app_resenias')]
    public function index(): Response
    {
        return $this->render('resenias/index.html.twig', [
            'controller_name' => 'ReseniasController',
        ]);
    }
}
