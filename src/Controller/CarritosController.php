<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Repository\CarritosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/carritos')]
final class CarritosController extends AbstractController
{
    #[Route('/all', name: 'app_carritos_all', methods: ['GET'])]
    public function getAllCarritos(CarritosRepository $carritosRepository): JsonResponse
    {
        return $this->json($carritosRepository->findAllCarritos());
    }

    #[Route('/byusuario', name: 'app_carritos_by_usuario', methods: ['GET'])]
    public function getCarritosByUsuario(CarritosRepository $carritosRepository): JsonResponse
    {
        /** @var Usuarios $user */
        $user = $this->getUser();
        $carritos = $carritosRepository->findCarritosByUsuario($user->getId());
        return $this->json($carritos);
    }
}

