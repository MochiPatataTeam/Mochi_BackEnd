<?php

namespace App\Entity;

use App\Repository\TematicaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TematicaRepository::class)]
#[ORM\Table(name: "tematica", schema: "mochi")]
class Tematica
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tematica = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTematica(): ?string
    {
        return $this->tematica;
    }

    public function setTematica(string $tematica): static
    {
        $this->tematica = $tematica;

        return $this;
    }
}
