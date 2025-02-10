<?php

namespace App\Controller;

use App\DTO\CreateUserDTO;
use App\DTO\LoginUserDTO;
use App\Entity\Usuarios;
use App\Repository\UsuariosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/usuarios')]
final class UsuariosController extends AbstractController
{
    #[Route('/all', name: 'app_usuarios', methods: ['GET'])]
    public function getAllUsuarios(UsuariosRepository $usuariosRepository): Response
    {
        $listaUsuarios = array_map(function ($usuario) {
            return [
                'id' => $usuario->getId(),
                'nick' => $usuario->getNick(),
                'correo' => $usuario->getCorreo(),
                'contrasenia' => $usuario->getContrasenia(),
                'perfil' => $usuario->getPerfil(),
                'foto' => $usuario->getFoto(),
                'rol' => $usuario->getRol(),
            ];
        }, $usuariosRepository->findAll());
        return $this->json($listaUsuarios);
    }

    #[Route('/registro', name: 'registrar_usuario', methods: ['POST'])]
    public function registrarUsuario(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        #[MapRequestPayload] CreateUserDTO $request
    ): JsonResponse
    {

        $user = new Usuarios();

        $user->setNick($request->getNick());
        $user->setCorreo($request->getCorreo());
        $user->setContrasenia($passwordHasher->hashPassword($user, $request->getContrasenia()));
        $user->setPerfil($request->getPerfil());
        $user->setFoto($request->getFoto());
        $user->setRol(0);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'Usuario registrado correctamente'
        ]);
    }

    #[Route('/login', name: 'login_usuario', methods: ['POST'])]
    public function loginUsuario(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $JWTManager,
        #[MapRequestPayload] LoginUserDTO $request
    ): JsonResponse {
        try {
            $user = $entityManager->getRepository(Usuarios::class)->findOneBy([
                'nick' => $request->getNick()
            ]);

            if (!$user || !$passwordHasher->isPasswordValid($user, $request->getContrasenia())) {
                return $this->json([
                    'message' => 'Usuario o contraseña incorrectos'
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Generar token JWT
            $token = $JWTManager->create($user);

            return $this->json([
                'message' => 'Usuario logueado correctamente',
                'token' => $token
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'Ocurrió un error en el servidor',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




}


