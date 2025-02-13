<?php

namespace App\Entity;

use App\Repository\ReseniasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReseniasRepository::class)]
#[ORM\Table(name: 'resenias', schema: 'animemarket')]
class Resenias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Productos::class, inversedBy: 'resenias')]
    #[ORM\JoinColumn(name: 'id_producto', referencedColumnName: 'id', nullable: false, onDelete: "CASCADE")]
    private ?Productos $id_producto = null;

    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'resenias')]
    #[ORM\JoinColumn(name: 'id_usuario', referencedColumnName: 'id', nullable: false, onDelete: "CASCADE")]
    private ?Usuarios $id_usuario = null;

    #[ORM\Column(name: 'comentario', type: 'text', nullable: true)]
    private ?string $comentario = null;

    #[ORM\Column(name: 'calificacion', type: 'integer')]
    private ?int $calificacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProducto(): ?Productos
    {
        return $this->id_producto;
    }

    public function setIdProducto(?Productos $id_producto): static
    {
        $this->id_producto = $id_producto;
        return $this;
    }

    public function getIdUsuario(): ?Usuarios
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuarios $id_usuario): static
    {
        $this->id_usuario = $id_usuario;
        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): static
    {
        $this->comentario = $comentario;
        return $this;
    }

    public function getCalificacion(): ?int
    {
        return $this->calificacion;
    }

    public function setCalificacion(int $calificacion): static
    {
        $this->calificacion = $calificacion;
        return $this;
    }
}

//
//
//namespace App\Entity;
//
//use App\Repository\ReseniasRepository;
//use Doctrine\ORM\Mapping as ORM;
//
//#[ORM\Entity(repositoryClass: ReseniasRepository::class)]
//#[ORM\Table(name: 'resenias', schema: 'animeMarket')]
//class Resenias
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column(name: 'id', type: 'integer')]
//    private ?int $id = null;
//
//    #[ORM\ManyToOne(targetEntity: Productos::class, inversedBy: 'resenias')]
//    #[ORM\JoinColumn(name: 'id_producto', referencedColumnName: 'id', nullable: false)]
//    private ?Productos $id_producto = null;
//
//    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'resenias')]
//    #[ORM\JoinColumn(name: 'id_usuario', referencedColumnName: 'id', nullable: false)]
//    private ?Usuarios $id_usuario = null;
//
//    #[ORM\Column(name: 'comentario', type: 'text', nullable: true)]
//    private ?string $comentario = null;
//
//    #[ORM\Column(name: 'calificacion', type: 'integer')]
//    private ?int $calificacion = null;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getIdProducto(): ?Productos
//    {
//        return $this->id_producto;
//    }
//
//    public function setIdProducto(?Productos $id_producto): static
//    {
//        $this->id_producto = $id_producto;
//        return $this;
//    }
//
//    public function getIdUsuario(): ?Usuarios
//    {
//        return $this->id_usuario;
//    }
//
//    public function setIdUsuario(?Usuarios $id_usuario): static
//    {
//        $this->id_usuario = $id_usuario;
//        return $this;
//    }
//
//    public function getComentario(): ?string
//    {
//        return $this->comentario;
//    }
//
//    public function setComentario(?string $comentario): static
//    {
//        $this->comentario = $comentario;
//        return $this;
//    }
//
//    public function getCalificacion(): ?int
//    {
//        return $this->calificacion;
//    }
//
//    public function setCalificacion(int $calificacion): static
//    {
//        $this->calificacion = $calificacion;
//        return $this;
//    }
//}

//
//namespace App\Entity;
//
//use App\Repository\ReseniasRepository;
//use Doctrine\ORM\Mapping as ORM;
//
//#[ORM\Entity(repositoryClass: ReseniasRepository::class)]
//#[ORM\Table(name: 'resenias', schema: 'animeMarket')]
//class Resenias
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column(name: 'id', type: 'integer')]
//    private ?int $id = null;
//
//    #[ORM\ManyToOne(inversedBy: 'resenias')]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?Productos $id_producto = null;
//
//    #[ORM\ManyToOne(inversedBy: 'resenias')]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?Usuarios $id_usuario = null;
//
//    #[ORM\Column(name: 'calificacion', type: 'integer')]
//    private ?int $calificacion = null;
//
//    #[ORM\Column(name: 'comentario', length: 510, nullable: true)]
//    private ?string $comentario = null;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getIdProducto(): ?Productos
//    {
//        return $this->id_producto;
//    }
//
//    public function setIdProducto(?Productos $id_producto): static
//    {
//        $this->id_producto = $id_producto;
//
//        return $this;
//    }
//
//    public function getIdUsuario(): ?Usuarios
//    {
//        return $this->id_usuario;
//    }
//
//    public function setIdUsuario(?Usuarios $id_usuario): static
//    {
//        $this->id_usuario = $id_usuario;
//
//        return $this;
//    }
//
//    public function getCalificacion(): ?int
//    {
//        return $this->calificacion;
//    }
//
//    public function setCalificacion(int $calificacion): static
//    {
//        $this->calificacion = $calificacion;
//
//        return $this;
//    }
//
//    public function getComentario(): ?string
//    {
//        return $this->comentario;
//    }
//
//    public function setComentario(?string $comentario): static
//    {
//        $this->comentario = $comentario;
//
//        return $this;
//    }
//}
