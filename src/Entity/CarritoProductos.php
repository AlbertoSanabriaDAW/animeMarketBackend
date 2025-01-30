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

    #[ORM\ManyToOne(inversedBy: 'carritoProductos')]
    private ?Carritos $id_carrito = null;

    #[ORM\ManyToOne(inversedBy: 'carritoProductos')]
    private ?Productos $id_producto = null;

    #[ORM\Column(name: 'cantidad', type: 'integer')]
    private ?int $cantidad = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCarrito(): ?Carritos
    {
        return $this->id_carrito;
    }

    public function setIdCarrito(?Carritos $id_carrito): static
    {
        $this->id_carrito = $id_carrito;

        return $this;
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
