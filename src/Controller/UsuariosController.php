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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

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
                'perfil' => $usuario->getPerfil(),
                'foto' => $usuario->getFoto(),
                'rol' => $usuario->getRol(),
            ];
        }, $usuariosRepository->findAll());

        return $this->json($listaUsuarios);
    }

    #[Route('/login', name: 'login_usuario', methods: ['POST'])]
    public function login(Request $request, UsuariosRepository $usuariosRepository, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $usuario = $usuariosRepository->findOneBy(['correo' => $data['correo']]);

        if (!$usuario || !password_verify($data['password'], $usuario->getContrasenia())) {
            return $this->json(['error' => 'Credenciales incorrectas'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $JWTManager->create($usuario);

        return $this->json(['token' => $token]);
    }

    #[Route('/logout', name: 'logout_usuario', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        return $this->json(['message' => 'Logout exitoso'], Response::HTTP_OK);
    }

    #[Route('/register', name: 'register_usuario', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuarios();
        $usuario->setNick($data['nick']);
        $usuario->setCorreo($data['correo']);
        $usuario->setPerfil($data['perfil']);
        $usuario->setFoto($data['foto']);
        $usuario->setRol($data['rol']);
        $usuario->setContrasenia($passwordHasher->hashPassword($usuario, $data['password']));

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario registrado correctamente'], Response::HTTP_CREATED);
    }

    #[Route('/editar/{id}', name: 'editar_usuario', methods: ['PUT'])]
    public function editarUsuario(int $id, UsuariosRepository $usuariosRepository, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $usuario = $usuariosRepository->find($id);

        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['correo'])) {
            $usuario->setCorreo($data['correo']);
        }
        if (isset($data['perfil'])) {
            $usuario->setPerfil($data['perfil']);
        }
        if (isset($data['foto'])) {
            $usuario->setFoto($data['foto']);
        }

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario actualizado correctamente'], Response::HTTP_OK);
    }

    #[Route('/eliminar/{id}', name: 'eliminar_usuario', methods: ['DELETE'])]
    public function eliminarUsuario(int $id, UsuariosRepository $usuariosRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $usuario = $usuariosRepository->find($id);

        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($usuario);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario eliminado correctamente'], Response::HTTP_OK);
    }
}

// Aqui tiene el metodo editar y arriba añado el de eliminar --------------------------------------------------------------
//namespace App\Controller;
//
//use App\DTO\CreateUserDTO;
//use App\DTO\LoginUserDTO;
//use App\Entity\Usuarios;
//use App\Repository\UsuariosRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
//
//#[Route('/usuarios')]
//final class UsuariosController extends AbstractController
//{
//    #[Route('/all', name: 'app_usuarios', methods: ['GET'])]
//    public function getAllUsuarios(UsuariosRepository $usuariosRepository): Response
//    {
//        $listaUsuarios = array_map(function ($usuario) {
//            return [
//                'id' => $usuario->getId(),
//                'nick' => $usuario->getNick(),
//                'correo' => $usuario->getCorreo(),
//                'perfil' => $usuario->getPerfil(),
//                'foto' => $usuario->getFoto(),
//                'rol' => $usuario->getRol(),
//            ];
//        }, $usuariosRepository->findAll());
//
//        return $this->json($listaUsuarios);
//    }
//
//    #[Route('/login', name: 'login_usuario', methods: ['POST'])]
//    public function login(Request $request, UsuariosRepository $usuariosRepository, JWTTokenManagerInterface $JWTManager): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//        $usuario = $usuariosRepository->findOneBy(['correo' => $data['correo']]);
//
//        if (!$usuario || !password_verify($data['password'], $usuario->getContrasenia())) {
//            return $this->json(['error' => 'Credenciales incorrectas'], Response::HTTP_UNAUTHORIZED);
//        }
//
//        $token = $JWTManager->create($usuario);
//
//        return $this->json(['token' => $token]);
//    }
//
//    #[Route('/logout', name: 'logout_usuario', methods: ['POST'])]
//    public function logout(): JsonResponse
//    {
//        return $this->json(['message' => 'Logout exitoso'], Response::HTTP_OK);
//    }
//
//    #[Route('/register', name: 'register_usuario', methods: ['POST'])]
//    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
//    {
//        $data = json_decode($request->getContent(), true);
//
//        $usuario = new Usuarios();
//        $usuario->setNick($data['nick']);
//        $usuario->setCorreo($data['correo']);
//        $usuario->setPerfil($data['perfil']);
//        $usuario->setFoto($data['foto']);
//        $usuario->setRol($data['rol']);
//        $usuario->setContrasenia($passwordHasher->hashPassword($usuario, $data['password']));
//
//        $entityManager->persist($usuario);
//        $entityManager->flush();
//
//        return $this->json(['message' => 'Usuario registrado correctamente'], Response::HTTP_CREATED);
//    }
//
//    #[Route('/editar/{id}', name: 'editar_usuario', methods: ['PUT'])]
//    public function editarUsuario(int $id, UsuariosRepository $usuariosRepository, EntityManagerInterface $entityManager, Request $request): JsonResponse
//    {
//        $usuario = $usuariosRepository->find($id);
//
//        if (!$usuario) {
//            return $this->json(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
//        }
//
//        $data = json_decode($request->getContent(), true);
//
//        if (isset($data['correo'])) {
//            $usuario->setCorreo($data['correo']);
//        }
//        if (isset($data['perfil'])) {
//            $usuario->setPerfil($data['perfil']);
//        }
//        if (isset($data['foto'])) {
//            $usuario->setFoto($data['foto']);
//        }
//
//        $entityManager->persist($usuario);
//        $entityManager->flush();
//
//        return $this->json(['message' => 'Usuario actualizado correctamente'], Response::HTTP_OK);
//    }
//}

// HASTA AQUI VA PERO QUIERO AÑADIR EDITAR --------------------------------------------------------------
//namespace App\Controller;
//
//use App\DTO\CreateUserDTO;
//use App\DTO\LoginUserDTO;
//use App\Entity\Usuarios;
//use App\Repository\UsuariosRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use Symfony\Component\Routing\Attribute\Route;
//
//#[Route('/usuarios')]
//final class UsuariosController extends AbstractController
//{
//    #[Route('/all', name: 'app_usuarios', methods: ['GET'])]
//    public function getAllUsuarios(UsuariosRepository $usuariosRepository): Response
//    {
//        $listaUsuarios = array_map(function ($usuario) {
//            return [
//                'id' => $usuario->getId(),
//                'nick' => $usuario->getNick(),
//                'correo' => $usuario->getCorreo(),
//                'contrasenia' => $usuario->getContrasenia(),
//                'perfil' => $usuario->getPerfil(),
//                'foto' => $usuario->getFoto(),
//                'rol' => $usuario->getRol(),
//            ];
//        }, $usuariosRepository->findAll());
//        return $this->json($listaUsuarios);
//    }
//
//    #[Route('/registro', name: 'registrar_usuario', methods: ['POST'])]
//    public function registrarUsuario(
//        UserPasswordHasherInterface $passwordHasher,
//        EntityManagerInterface $entityManager,
//        #[MapRequestPayload] CreateUserDTO $request
//    ): JsonResponse
//    {
//        $user = new Usuarios();
//        $user->setNick($request->getNick());
//        $user->setCorreo($request->getCorreo());
//        $user->setContrasenia($passwordHasher->hashPassword($user, $request->getContrasenia()));
//        $user->setPerfil($request->getPerfil());
//        $user->setFoto($request->getFoto());
//        $user->setRol(0);
//
//        $entityManager->persist($user);
//        $entityManager->flush();
//
//        return $this->json([
//            'message' => 'Usuario registrado correctamente'
//        ]);
//    }
//
//    #[Route('/login', name: 'login_usuario', methods: ['POST'])]
//    public function loginUsuario(
//        UserPasswordHasherInterface $passwordHasher,
//        EntityManagerInterface $entityManager,
//        JWTTokenManagerInterface $JWTManager,
//        #[MapRequestPayload] LoginUserDTO $request
//    ): JsonResponse {
//        try {
//            $user = $entityManager->getRepository(Usuarios::class)->findOneBy([
//                'nick' => $request->getNick()
//            ]);
//
//            if (!$user || !$passwordHasher->isPasswordValid($user, $request->getContrasenia())) {
//                return $this->json([
//                    'message' => 'Usuario o contraseña incorrectos'
//                ], Response::HTTP_UNAUTHORIZED);
//            }
//
//            // Generar token JWT
//            $token = $JWTManager->create($user);
//
//            return $this->json([
//                'message' => 'Usuario logueado correctamente',
//                'token' => $token
//            ], Response::HTTP_OK);
//        } catch (\Exception $e) {
//            return $this->json([
//                'message' => 'Ocurrió un error en el servidor',
//                'error' => $e->getMessage()
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
//
//    #[Route('/logout', name: 'logout_usuario', methods: ['POST'])]
//    public function logoutUsuario(): JsonResponse
//    {
//        // No se puede invalidar un JWT en el servidor, pero se puede manejar en el frontend
//        return $this->json([
//            'message' => 'Sesión cerrada correctamente. El token debe ser eliminado del cliente.'
//        ], Response::HTTP_OK);
//    }
//}

// HASTA AQUI FUNCIONA PERO VOY A INTEGRAR COSAS NUEVAS ARRIBA
//namespace App\Controller;
//
//use App\DTO\CreateUserDTO;
//use App\DTO\LoginUserDTO;
//use App\Entity\Usuarios;
//use App\Repository\UsuariosRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
//use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use Symfony\Component\Routing\Attribute\Route;
//
//#[Route('/usuarios')]
//final class UsuariosController extends AbstractController
//{
//    #[Route('/all', name: 'app_usuarios', methods: ['GET'])]
//    public function getAllUsuarios(UsuariosRepository $usuariosRepository): Response
//    {
//        $listaUsuarios = array_map(function ($usuario) {
//            return [
//                'id' => $usuario->getId(),
//                'nick' => $usuario->getNick(),
//                'correo' => $usuario->getCorreo(),
//                'contrasenia' => $usuario->getContrasenia(),
//                'perfil' => $usuario->getPerfil(),
//                'foto' => $usuario->getFoto(),
//                'rol' => $usuario->getRol(),
//            ];
//        }, $usuariosRepository->findAll());
//        return $this->json($listaUsuarios);
//    }
//
//    #[Route('/registro', name: 'registrar_usuario', methods: ['POST'])]
//    public function registrarUsuario(
//        UserPasswordHasherInterface $passwordHasher,
//        EntityManagerInterface $entityManager,
//        #[MapRequestPayload] CreateUserDTO $request
//    ): JsonResponse
//    {
//
//        $user = new Usuarios();
//
//        $user->setNick($request->getNick());
//        $user->setCorreo($request->getCorreo());
//        $user->setContrasenia($passwordHasher->hashPassword($user, $request->getContrasenia()));
//        $user->setPerfil($request->getPerfil());
//        $user->setFoto($request->getFoto());
//        $user->setRol(0);
//
//        $entityManager->persist($user);
//        $entityManager->flush();
//
//        return $this->json([
//            'message' => 'Usuario registrado correctamente'
//        ]);
//    }
//
//    #[Route('/login', name: 'login_usuario', methods: ['POST'])]
//    public function loginUsuario(
//        UserPasswordHasherInterface $passwordHasher,
//        EntityManagerInterface $entityManager,
//        JWTTokenManagerInterface $JWTManager,
//        #[MapRequestPayload] LoginUserDTO $request
//    ): JsonResponse {
//        try {
//            $user = $entityManager->getRepository(Usuarios::class)->findOneBy([
//                'nick' => $request->getNick()
//            ]);
//
//            if (!$user || !$passwordHasher->isPasswordValid($user, $request->getContrasenia())) {
//                return $this->json([
//                    'message' => 'Usuario o contraseña incorrectos'
//                ], Response::HTTP_UNAUTHORIZED);
//            }
//
//            // Generar token JWT
//            $token = $JWTManager->create($user);
//
//            return $this->json([
//                'message' => 'Usuario logueado correctamente',
//                'token' => $token
//            ], Response::HTTP_OK);
//        } catch (\Exception $e) {
//            return $this->json([
//                'message' => 'Ocurrió un error en el servidor',
//                'error' => $e->getMessage()
//            ], Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
//
//
//
//
//}


