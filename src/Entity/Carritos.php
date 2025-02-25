<?php

namespace App\Entity;

use App\Repository\CarritosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarritosRepository::class)]
#[ORM\Table(name: 'carritos', schema: 'animemarket')]
class Carritos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'carritos')]
    #[ORM\JoinColumn(name: 'id_usuario', referencedColumnName: 'id', nullable: false)]
    private ?Usuarios $usuario = null;

//    #[ORM\Column(type: 'string', length: 20)]
//    private ?string $estado = null;

    #[ORM\Column(name: 'estado', type: 'integer')]
    private ?int $estado = null;

    #[ORM\OneToMany(targetEntity: CarritoProductos::class, mappedBy: 'carrito')]
    private Collection $productos;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): static
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): static
    {
        $this->estado = $estado;
        return $this;
    }

    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(CarritoProductos $producto): static
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->setCarrito($this);
        }

        return $this;
    }

    public function removeProducto(CarritoProductos $producto): static
    {
        if ($this->productos->removeElement($producto)) {
            if ($producto->getCarrito() === $this) {
                $producto->setCarrito(null);
            }
        }

        return $this;
    }
}

