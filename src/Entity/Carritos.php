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

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $estado = null;

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

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
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


//
//namespace App\Entity;
// HACE QUE FUNCIONE CARRITOS Y LO DE ARRIBA HACE QUE FUNCIONE CARRITOPRODUCTOS PERO CARRITOS FALLA
//use App\Repository\CarritosRepository;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
//use Doctrine\ORM\Mapping as ORM;
//
//#[ORM\Entity(repositoryClass: CarritosRepository::class)]
//#[ORM\Table(name: 'carritos', schema: 'animeMarket')]
//class Carritos
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column(name: 'id', type: 'integer')]
//    private ?int $id = null;
//
//    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'carritos')]
//    #[ORM\JoinColumn(name: 'id_usuario', referencedColumnName: 'id', nullable: false, onDelete: "CASCADE")]
//    private ?Usuarios $id_usuario = null;
//
//    /**
//     * @var Collection<int, CarritoProductos>
//     */
//    #[ORM\OneToMany(targetEntity: CarritoProductos::class, mappedBy: 'id_carrito')]
//    private Collection $carritoProductos;
//
//    public function __construct()
//    {
//        $this->carritoProductos = new ArrayCollection();
//    }
//
//    public function getId(): ?int
//    {
//        return $this->id;
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
//    /**
//     * @return Collection<int, CarritoProductos>
//     */
//    public function getCarritoProductos(): Collection
//    {
//        return $this->carritoProductos;
//    }
//
//    public function addCarritoProducto(CarritoProductos $carritoProducto): static
//    {
//        if (!$this->carritoProductos->contains($carritoProducto)) {
//            $this->carritoProductos->add($carritoProducto);
//            $carritoProducto->setIdCarrito($this);
//        }
//        return $this;
//    }
//
//    public function removeCarritoProducto(CarritoProductos $carritoProducto): static
//    {
//        if ($this->carritoProductos->removeElement($carritoProducto)) {
//            if ($carritoProducto->getIdCarrito() === $this) {
//                $carritoProducto->setIdCarrito(null);
//            }
//        }
//        return $this;
//    }
//}

//
//namespace App\Entity;
//
//use App\Repository\CarritosRepository;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
//use Doctrine\ORM\Mapping as ORM;
//
//#[ORM\Entity(repositoryClass: CarritosRepository::class)]
//#[ORM\Table(name: 'carritos', schema: 'animeMarket')]
//class Carritos
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column(name: 'id', type: 'integer')]
//    private ?int $id = null;
//
//    #[ORM\ManyToOne]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?usuarios $id_usuario = null;
//
//    #[ORM\Column(name: 'estado', type: 'integer')]
//    private ?int $estado = null;
//
//    /**
//     * @var Collection<int, CarritoProductos>
//     */
//    #[ORM\OneToMany(targetEntity: CarritoProductos::class, mappedBy: 'id_carrito')]
//    private Collection $carritoProductos;
//
//    #[ORM\OneToOne(mappedBy: 'id_carrito', cascade: ['persist', 'remove'])]
//    private ?Pedidos $pedidos = null;
//
//    public function __construct()
//    {
//        $this->carritoProductos = new ArrayCollection();
//    }
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getIdUsuario(): ?usuarios
//    {
//        return $this->id_usuario;
//    }
//
//    public function setIdUsuario(?usuarios $id_usuario): static
//    {
//        $this->id_usuario = $id_usuario;
//
//        return $this;
//    }
//
//    public function getEstado(): ?int
//    {
//        return $this->estado;
//    }
//
//    public function setEstado(int $estado): static
//    {
//        $this->estado = $estado;
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, CarritoProductos>
//     */
//    public function getCarritoProductos(): Collection
//    {
//        return $this->carritoProductos;
//    }
//
//    public function addCarritoProducto(CarritoProductos $carritoProducto): static
//    {
//        if (!$this->carritoProductos->contains($carritoProducto)) {
//            $this->carritoProductos->add($carritoProducto);
//            $carritoProducto->setIdCarrito($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCarritoProducto(CarritoProductos $carritoProducto): static
//    {
//        if ($this->carritoProductos->removeElement($carritoProducto)) {
//            // set the owning side to null (unless already changed)
//            if ($carritoProducto->getIdCarrito() === $this) {
//                $carritoProducto->setIdCarrito(null);
//            }
//        }
//
//        return $this;
//    }
//
//    public function getPedidos(): ?Pedidos
//    {
//        return $this->pedidos;
//    }
//
//    public function setPedidos(?Pedidos $pedidos): static
//    {
//        // unset the owning side of the relation if necessary
//        if ($pedidos === null && $this->pedidos !== null) {
//            $this->pedidos->setIdCarrito(null);
//        }
//
//        // set the owning side of the relation if necessary
//        if ($pedidos !== null && $pedidos->getIdCarrito() !== $this) {
//            $pedidos->setIdCarrito($this);
//        }
//
//        $this->pedidos = $pedidos;
//
//        return $this;
//    }
//}
