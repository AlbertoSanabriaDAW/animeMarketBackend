<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
#[ORM\Table(name: 'usuarios', schema: 'animeMarket')]
class Usuarios implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'nick', length: 255)]
    private ?string $nick = null;

    #[ORM\Column(name:'correo', length: 255)]
    private ?string $correo = null;

    #[ORM\Column(name:'perfil', length: 510, nullable: true)]
    private ?string $perfil = null;

    #[ORM\Column(name: 'foto', length: 2083, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(name:'rol', length: 1)]
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

    #[ORM\Column(name:'contrasenia', length: 600)]
    private ?string $contrasenia = null;

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

    public function getContrasenia(): ?string
    {
        return $this->contrasenia;
    }

    public function setContrasenia(string $contrasenia): static
    {
        $this->contrasenia = $contrasenia;

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


    public function getPassword(): ?string
    {
      return $this->contrasenia;
    }

    public function getRoles(): array
    {
        $roles = [];
        //rolles.add(this.getRol());
        $roles[] = $this->getRol();
        return $roles;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getNick();
    }
}
