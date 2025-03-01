<?php

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidosRepository::class)]
#[ORM\Table(name: 'pedidos', schema: 'animemarket')]
class Pedidos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'fecha', type: 'datetime')]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(name: 'precio', type: 'decimal', precision: 10, scale: 2)]
    private ?float $precio = null;

    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'pedidos')]
    #[ORM\JoinColumn(name: 'id_usuario', referencedColumnName: 'id', nullable: false)]
    private ?Usuarios $id_usuario = null;

    #[ORM\ManyToOne(targetEntity: Carritos::class, inversedBy: 'pedidos')]
    #[ORM\JoinColumn(name: 'id_carrito', referencedColumnName: 'id', nullable: false)]
    private ?Carritos $carritos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;
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

    public function getCarritos(): ?Carritos
    {
        return $this->carritos;
    }

    public function setCarritos(?Carritos $carritos): static
    {
        $this->carritos = $carritos;
        return $this;
    }
}
