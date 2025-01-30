<?php

namespace App\Entity;

use App\Repository\CarritosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarritosRepository::class)]
class Carritos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?usuarios $id_usuario = null;

    #[ORM\Column]
    private ?int $estado = null;

    /**
     * @var Collection<int, CarritoProductos>
     */
    #[ORM\OneToMany(targetEntity: CarritoProductos::class, mappedBy: 'id_carrito')]
    private Collection $carritoProductos;

    #[ORM\OneToOne(mappedBy: 'id_carrito', cascade: ['persist', 'remove'])]
    private ?Pedidos $pedidos = null;

    public function __construct()
    {
        $this->carritoProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUsuario(): ?usuarios
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?usuarios $id_usuario): static
    {
        $this->id_usuario = $id_usuario;

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

    /**
     * @return Collection<int, CarritoProductos>
     */
    public function getCarritoProductos(): Collection
    {
        return $this->carritoProductos;
    }

    public function addCarritoProducto(CarritoProductos $carritoProducto): static
    {
        if (!$this->carritoProductos->contains($carritoProducto)) {
            $this->carritoProductos->add($carritoProducto);
            $carritoProducto->setIdCarrito($this);
        }

        return $this;
    }

    public function removeCarritoProducto(CarritoProductos $carritoProducto): static
    {
        if ($this->carritoProductos->removeElement($carritoProducto)) {
            // set the owning side to null (unless already changed)
            if ($carritoProducto->getIdCarrito() === $this) {
                $carritoProducto->setIdCarrito(null);
            }
        }

        return $this;
    }

    public function getPedidos(): ?Pedidos
    {
        return $this->pedidos;
    }

    public function setPedidos(?Pedidos $pedidos): static
    {
        // unset the owning side of the relation if necessary
        if ($pedidos === null && $this->pedidos !== null) {
            $this->pedidos->setIdCarrito(null);
        }

        // set the owning side of the relation if necessary
        if ($pedidos !== null && $pedidos->getIdCarrito() !== $this) {
            $pedidos->setIdCarrito($this);
        }

        $this->pedidos = $pedidos;

        return $this;
    }
}
