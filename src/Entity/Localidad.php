<?php

namespace App\Entity;

use App\Repository\LocalidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalidadRepository::class)]
class Localidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $localidad = null;

    #[ORM\OneToMany(mappedBy: 'localidad', targetEntity: Oficina::class)]
    private Collection $oficinas;

    public function __construct()
    {
        $this->oficinas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * @return Collection<int, Oficina>
     */
    public function getOficinas(): Collection
    {
        return $this->oficinas;
    }

    public function addOficina(Oficina $oficina): self
    {
        if (!$this->oficinas->contains($oficina)) {
            $this->oficinas->add($oficina);
            $oficina->setLocalidad($this);
        }

        return $this;
    }

    public function removeOficina(Oficina $oficina): self
    {
        if ($this->oficinas->removeElement($oficina)) {
            // set the owning side to null (unless already changed)
            if ($oficina->getLocalidad() === $this) {
                $oficina->setLocalidad(null);
            }
        }

        return $this;
    }

     public function __toString()
    {
        return $this->getLocalidad();
    } 
}
