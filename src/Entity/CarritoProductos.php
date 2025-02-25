<?php

namespace App\Entity;

use App\Repository\CarritoProductosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarritoProductosRepository::class)]
#[ORM\Table(name: 'carrito_productos', schema: 'animemarket')]
class CarritoProductos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Carritos::class, inversedBy: 'carritoProductos')]
    #[ORM\JoinColumn(name: 'id_carrito', referencedColumnName: 'id', nullable: false)]
    private ?Carritos $carrito = null;

    #[ORM\ManyToOne(targetEntity: Productos::class)]
    #[ORM\JoinColumn(name: 'id_producto', referencedColumnName: 'id', nullable: false)]
    private ?Productos $producto = null;

    #[ORM\Column(name: 'cantidad', type: 'integer')]
    private ?int $cantidad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrito(): ?Carritos
    {
        return $this->carrito;
    }

    public function setCarrito(?Carritos $carrito): static
    {
        $this->carrito = $carrito;
        return $this;
    }

    public function getProducto(): ?Productos
    {
        return $this->producto;
    }

    public function setProducto(?Productos $producto): static
    {
        $this->producto = $producto;
        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;
        return $this;
    }
}
