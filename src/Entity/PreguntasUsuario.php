<?php

namespace App\Entity;

use App\Repository\PreguntasUsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreguntasUsuarioRepository::class)]
#[ORM\Table(name: "preguntas_usuario", schema: "mochi")]
class PreguntasUsuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_usuario")]
    private ?Usuario $usuario = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_pregunta")]
    private ?PreguntasSeguridad $pregunta = null;

    #[ORM\Column(length: 255)]
    private ?string $respuesta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPregunta(): ?PreguntasSeguridad
    {
        return $this->pregunta;
    }

    public function setPregunta(PreguntasSeguridad $pregunta): static
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getRespuesta(): ?string
    {
        return $this->respuesta;
    }

    public function setRespuesta(string $respuesta): static
    {
        $this->respuesta = $respuesta;

        return $this;
    }
}
