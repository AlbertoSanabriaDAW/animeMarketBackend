<?php


namespace App\Entity;

use App\Repository\ProductosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductosRepository::class)]
#[ORM\Table(name: 'productos', schema: 'animeMarket')]
class Productos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'nombre', length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(name: 'imagen', length: 2083, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(name: 'descripcion', length: 510, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(name: 'precio', type: 'float')]
    private ?float $precio = null;

    #[ORM\Column(name: 'id_tematica', type: 'integer')]
    private ?int $id_tematica = null;

    /**
     * @var Collection<int, CarritoProductos>
     */
    #[ORM\OneToMany(targetEntity: CarritoProductos::class, mappedBy: 'id_producto')]
    private Collection $carritoProductos;

    /**
     * @var Collection<int, Resenias>
     */
    #[ORM\OneToMany(targetEntity: Resenias::class, mappedBy: 'id_producto')]
    private Collection $resenias;

    public function __construct()
    {
        $this->carritoProductos = new ArrayCollection();
        $this->resenias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;
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

    public function getIdTematica(): ?int
    {
        return $this->id_tematica;
    }

    public function setIdTematica(?int $id_tematica): static
    {
        $this->id_tematica = $id_tematica;
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
            $carritoProducto->setIdProducto($this);
        }
        return $this;
    }

    public function removeCarritoProducto(CarritoProductos $carritoProducto): static
    {
        if ($this->carritoProductos->removeElement($carritoProducto)) {
            if ($carritoProducto->getIdProducto() === $this) {
                $carritoProducto->setIdProducto(null);
            }
        }
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
            $resenia->setIdProducto($this);
        }
        return $this;
    }

    public function removeResenia(Resenias $resenia): static
    {
        if ($this->resenias->removeElement($resenia)) {
            if ($resenia->getIdProducto() === $this) {
                $resenia->setIdProducto(null);
            }
        }
        return $this;
    }
}

//
//namespace App\Entity;
//
//use App\Repository\ProductosRepository;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
//use Doctrine\ORM\Mapping as ORM;
//
//#[ORM\Entity(repositoryClass: ProductosRepository::class)]
//#[ORM\Table(name: 'productos', schema: 'animeMarket')]
//class Productos
//{
//    #[ORM\Id]
//    #[ORM\GeneratedValue]
//    #[ORM\Column(name: 'id', type: 'integer')]
//    private ?int $id = null;
//
//    #[ORM\Column(name:'nombre', length: 255)]
//    private ?string $nombre = null;
//
//    #[ORM\Column(name: 'imagen', length: 2083, nullable: true)]
//    private ?string $imagen = null;
//
//    #[ORM\Column(name: 'descripcion', length: 510, nullable: true)]
//    private ?string $descripcion = null;
//
//    #[ORM\Column(name: 'precio', type: 'float')]
//    private ?float $precio = null;
//
//    #[ORM\Column(name: "id_tematica", type: "integer")]
//    private ?int $id_tematica = null;
//
////    #[ORM\ManyToOne]
////    private ?Tematicas $id_tematica = null;
//
//    /**
//     * @var Collection<int, CarritoProductos>
//     */
//    #[ORM\OneToMany(targetEntity: CarritoProductos::class, mappedBy: 'id_producto')]
//    private Collection $carritoProductos;
//
//    /**
//     * @var Collection<int, Resenias>
//     */
//    #[ORM\OneToMany(targetEntity: Resenias::class, mappedBy: 'id_producto')]
//    private Collection $resenias;
//
//    public function __construct()
//    {
//        $this->carritoProductos = new ArrayCollection();
//        $this->resenias = new ArrayCollection();
//    }
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getNombre(): ?string
//    {
//        return $this->nombre;
//    }
//
//    public function setNombre(string $nombre): static
//    {
//        $this->nombre = $nombre;
//
//        return $this;
//    }
//
//    public function getImagen(): ?string
//    {
//        return $this->imagen;
//    }
//
//    public function setImagen(?string $imagen): static
//    {
//        $this->imagen = $imagen;
//
//        return $this;
//    }
//
//    public function getDescripcion(): ?string
//    {
//        return $this->descripcion;
//    }
//
//    public function setDescripcion(?string $descripcion): static
//    {
//        $this->descripcion = $descripcion;
//
//        return $this;
//    }
//
//    public function getPrecio(): ?float
//    {
//        return $this->precio;
//    }
//
//    public function setPrecio(float $precio): static
//    {
//        $this->precio = $precio;
//
//        return $this;
//    }
//
//    public function getIdTematica(): ?Tematicas
//    {
//        return $this->id_tematica;
//    }
//
//    public function setIdTematica(?Tematicas $id_tematica): static
//    {
//        $this->id_tematica = $id_tematica;
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
//            $carritoProducto->setIdProducto($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCarritoProducto(CarritoProductos $carritoProducto): static
//    {
//        if ($this->carritoProductos->removeElement($carritoProducto)) {
//            // set the owning side to null (unless already changed)
//            if ($carritoProducto->getIdProducto() === $this) {
//                $carritoProducto->setIdProducto(null);
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, Resenias>
//     */
//    public function getResenias(): Collection
//    {
//        return $this->resenias;
//    }
//
//    public function addResenia(Resenias $resenia): static
//    {
//        if (!$this->resenias->contains($resenia)) {
//            $this->resenias->add($resenia);
//            $resenia->setIdProducto($this);
//        }
//
//        return $this;
//    }
//
//    public function removeResenia(Resenias $resenia): static
//    {
//        if ($this->resenias->removeElement($resenia)) {
//            // set the owning side to null (unless already changed)
//            if ($resenia->getIdProducto() === $this) {
//                $resenia->setIdProducto(null);
//            }
//        }
//
//        return $this;
//    }
//}
