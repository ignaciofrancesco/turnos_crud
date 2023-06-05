<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'persona', targetEntity: Turno::class)]
    private Collection $turnos;

    #[ORM\Column]
    private ?int $dni = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido = null;

    public function __construct()
    {
        $this->turnos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Turno>
     */
    public function getTurnos(): Collection
    {
        return $this->turnos;
    }

    public function addTurno(Turno $turno): self
    {
        if (!$this->turnos->contains($turno)) {
            $this->turnos->add($turno);
            $turno->setPersona($this);
        }

        return $this;
    }

    public function removeTurno(Turno $turno): self
    {
        if ($this->turnos->removeElement($turno)) {
            // set the owning side to null (unless already changed)
            if ($turno->getPersona() === $this) {
                $turno->setPersona(null);
            }
        }

        return $this;
    }
    
     public function __toString()
    {
        return this->getNombre();
    }

     public function getDni(): ?int
     {
         return $this->dni;
     }

     public function setDni(int $dni): self
     {
         $this->dni = $dni;

         return $this;
     }

     public function getApellido(): ?string
     {
         return $this->apellido;
     }

     public function setApellido(string $apellido): self
     {
         $this->apellido = $apellido;

         return $this;
     } 
}
