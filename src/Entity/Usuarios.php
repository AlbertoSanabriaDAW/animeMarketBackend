<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
class Usuarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nick = null;

    #[ORM\Column(length: 255)]
    private ?string $correo = null;

    #[ORM\Column(length: 510, nullable: true)]
    private ?string $perfil = null;

    #[ORM\Column(length: 2083, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(length: 1)]
    private ?string $rol = null;

    /**
     * @var Collection<int, Resenias>
     */
    #[ORM\OneToMany(targetEntity: Resenias::class, mappedBy: 'id_usuario')]
    private Collection $resenias;

    /**
     * @var Collection<int, Pedidos>
     */
    #[ORM\OneToMany(targetEntity: Pedidos::class, mappedBy: 'id_usuario')]
    private Collection $pedidos;

    public function __construct()
    {
        $this->resenias = new ArrayCollection();
        $this->pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): static
    {
        $this->nick = $nick;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): static
    {
        $this->correo = $correo;

        return $this;
    }

    public function getPerfil(): ?string
    {
        return $this->perfil;
    }

    public function setPerfil(?string $perfil): static
    {
        $this->perfil = $perfil;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): static
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * @return Collection<int, Resenias>
     */
    public function getResenias(): Collection
    {
        return $this->resenias;
    }

    public function addResenia(Resenias $resenia): static
    {
        if (!$this->resenias->contains($resenia)) {
            $this->resenias->add($resenia);
            $resenia->setIdUsuario($this);
        }

        return $this;
    }

    public function removeResenia(Resenias $resenia): static
    {
        if ($this->resenias->removeElement($resenia)) {
            // set the owning side to null (unless already changed)
            if ($resenia->getIdUsuario() === $this) {
                $resenia->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pedidos>
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedidos $pedido): static
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos->add($pedido);
            $pedido->setIdUsuario($this);
        }

        return $this;
    }

    public function removePedido(Pedidos $pedido): static
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getIdUsuario() === $this) {
                $pedido->setIdUsuario(null);
            }
        }

        return $this;
    }
}
