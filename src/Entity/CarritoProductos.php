<?php

namespace App\Entity;

use App\Repository\CarritoProductosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarritoProductosRepository::class)]
#[ORM\Table(name: 'carrito_productos', schema: 'animeMarket')]
class CarritoProductos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Carritos::class, inversedBy: 'carritoProductos')]
    #[ORM\JoinColumn(name: 'id_carrito', referencedColumnName: 'id', nullable: false)]
    private ?Carritos $carrito = null;

    #[ORM\ManyToOne(targetEntity: Productos::class, inversedBy: 'carritoProductos')]
    #[ORM\JoinColumn(name: 'id_producto', referencedColumnName: 'id', nullable: false)]
    private ?Productos $producto = null;

    #[ORM\Column(name: 'cantidad', type: 'integer')]
    private int $cantidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrito(): ?Carritos
    {
        return $this->carrito;
    }

    public function setCarrito(?Carritos $carrito): self
    {
        $this->carrito = $carrito;
        return $this;
    }

    public function getProducto(): ?Productos
    {
        return $this->producto;
    }

    public function setProducto(?Productos $producto): self
    {
        $this->producto = $producto;
        return $this;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;
        return $this;
    }
}

//
//namespace App\Entity;
//
//use App\Repository\CarritoProductosRepository;
//use Doctrine\ORM\Mapping as ORM;
//
//#[ORM\Entity(repositoryClass: CarritoProductosRepository::class)]
//#[ORM\Table(name: 'carrito_productos', schema: 'animeMarket')]
//class CarritoProductos
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column(name: 'id', type: 'integer')]
//    private ?int $id = null;
//
//    #[ORM\ManyToOne(inversedBy: 'carritoProductos')]
//    private ?Carritos $id_carrito = null;
//
//    #[ORM\ManyToOne(inversedBy: 'carritoProductos')]
//    private ?Productos $id_producto = null;
//
//    #[ORM\Column(name: 'cantidad', type: 'integer')]
//    private ?int $cantidad = null;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getIdCarrito(): ?Carritos
//    {
//        return $this->id_carrito;
//    }
//
//    public function setIdCarrito(?Carritos $id_carrito): static
//    {
//        $this->id_carrito = $id_carrito;
//
//        return $this;
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
//    public function getCantidad(): ?int
//    {
//        return $this->cantidad;
//    }
//
//    public function setCantidad(int $cantidad): static
//    {
//        $this->cantidad = $cantidad;
//
//        return $this;
//    }
//}
