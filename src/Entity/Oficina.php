<?php

namespace App\Entity;

use App\Repository\OficinaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OficinaRepository::class)]
class Oficina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $oficina = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOficina(): ?string
    {
        return $this->oficina;
    }

    public function setOficina(string $oficina): self
    {
        $this->oficina = $oficina;

        return $this;
    }
}
