<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Repository\UsuariosRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
//    #[Route('/api/registro', name: 'registrar_usuario', methods: ['POST'])]
//    public function registrarUsuario( Request $request, UserPasswordHasherInterface $passwordHasher
//    ): Response {
//        $data = json_decode($request->getContent(), true);
//        $usuario = new Usuarios();
//        $usuario->setNick($data['nick']);
//        $usuario->setCorreo($data['correo']);
//        $usuario->setContrasenia($passwordHasher->hashPassword($usuario, $data['contrasenia']));
//        $usuario->setPerfil($data['perfil']);
//        $usuario->setFoto($data['foto']);
//        $usuario->setRol($data['rol']);
//
//        $entityManager = $this->persist($usuario);
//        $entityManager->flush();
//
//        return $this->json([
//            'message' => 'Usuario registrado',
//            'id' => $usuario->getId(),
//        ]);
//
//    }



}


