<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Repository\UsuariosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/usuarios')]
final class UsuariosController extends AbstractController
{
     /**
     * Registro de usuario
     */
    #[Route('/register', name: 'registro_usuario', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        UsuariosRepository $usuariosRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validar datos requeridos
        if (!isset($data['nick'], $data['correo'], $data['contrasenia'])) {
            return new JsonResponse(['error' => 'Faltan datos obligatorios'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Verificar si el nick ya está en uso
        if ($usuariosRepository->findOneBy(['nick' => $data['nick']])) {
            return new JsonResponse(['error' => 'El nick ya está en uso'], JsonResponse::HTTP_CONFLICT);
        }

        // Verificar si el correo ya está en uso
        if ($usuariosRepository->findOneBy(['correo' => $data['correo']])) {
            return new JsonResponse(['error' => 'El correo ya está en uso'], JsonResponse::HTTP_CONFLICT);
        }

        // Crear el usuario
        $usuario = new Usuarios();
        $usuario->setNick($data['nick']);
        $usuario->setCorreo($data['correo']);
        $usuario->setRol($data['rol'] ?? 'USER');

        // Encriptar la contraseña
        $hashedPassword = $passwordHasher->hashPassword($usuario, $data['contrasenia']);
        $usuario->setContrasenia($hashedPassword);

        // Datos opcionales
        if (!empty($data['perfil'])) {
            $usuario->setPerfil($data['perfil']);
        }
        if (!empty($data['foto'])) {
            $usuario->setFoto($data['foto']);
        }

        // Validar la entidad antes de guardarla
        $errors = $validator->validate($usuario);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Guardar usuario en la base de datos
        $entityManager->persist($usuario);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Usuario registrado con éxito',
            'usuario' => [
                'id' => $usuario->getId(),
                'nick' => $usuario->getNick(),
                'correo' => $usuario->getCorreo(),
                'rol' => $usuario->getRol(),
            ]
        ], JsonResponse::HTTP_CREATED);
    }

    /**
     * Login de usuario y generación de JWT
     */
    #[Route('/login', name: 'login_usuario', methods: ['POST'])]
    public function login(
        Request $request,
        UsuariosRepository $usuariosRepository,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validar datos requeridos
        if (!isset($data['nick'], $data['contrasenia'])) {
            return new JsonResponse(['error' => 'Nick y contraseña son obligatorios'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Buscar usuario por nick
        $usuario = $usuariosRepository->findOneBy(['nick' => $data['nick']]);

        if (!$usuario) {
            return new JsonResponse(['error' => 'Usuario no encontrado'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Verificar contraseña
        if (!$passwordHasher->isPasswordValid($usuario, $data['contrasenia'])) {
            return new JsonResponse(['error' => 'Credenciales incorrectas'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Generar token JWT
        $token = $jwtManager->create($usuario);

        return new JsonResponse([
            'message' => 'Login exitoso',
            'token' => $token,
            'usuario' => [
                'id' => $usuario->getId(),
                'nick' => $usuario->getNick(),
                'correo' => $usuario->getCorreo(),
                'rol' => $usuario->getRol(),
            ]
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Perfil de usuario (requiere autenticación)
     */
    #[Route('/perfil', name: 'perfil_usuario', methods: ['GET'])]
    public function perfil(): JsonResponse
    {
        $usuario = $this->getUser();

        if (!$usuario) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'id' => $usuario->getId(),
            'nick' => $usuario->getNick(),
            'correo' => $usuario->getCorreo(),
            'rol' => $usuario->getRol(),
        ], JsonResponse::HTTP_OK);
    }
}
