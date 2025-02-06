<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TematicasController extends AbstractController
{
    #[Route('/tematicas', name: 'app_tematicas')]
    public function index(): Response
    {
        return $this->render('tematicas/index.html.twig', [
            'controller_name' => 'TematicasController',
        ]);
    }
}
