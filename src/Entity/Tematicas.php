<?php

namespace App\Entity;

use App\Repository\TematicasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TematicasRepository::class)]
#[ORM\Table(name: 'tematicas', schema: 'animemarket')]
class Tematicas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'nombre', length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Productos>
     */
    #[ORM\OneToMany(targetEntity: Productos::class, mappedBy: 'id_tematica')]
    private Collection $productos;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
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

    /**
     * @return Collection<int, Productos>
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Productos $producto): static
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->setIdTematica($this);
        }
        return $this;
    }

    public function removeProducto(Productos $producto): static
    {
        if ($this->productos->removeElement($producto)) {
            if ($producto->getIdTematica() === $this) {
                $producto->setIdTematica(null);
            }
        }
        return $this;
    }
}
