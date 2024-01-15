<?php

namespace App\Entity;

use App\Repository\PreguntasSeguridadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreguntasSeguridadRepository::class)]
#[ORM\Table(name: "preguntas_seguridad", schema: "mochi")]
class PreguntasSeguridad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pregunta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPregunta(): ?string
    {
        return $this->pregunta;
    }

    public function setPregunta(string $pregunta): static
    {
        $this->pregunta = $pregunta;

        return $this;
    }
}
