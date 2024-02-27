<?php

namespace App\Entity;

use App\Repository\PrivacidadUsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrivacidadUsuarioRepository::class)]
#[ORM\Table(name: "privacidad_usuario", schema: "mochi")]
class PrivacidadUsuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isPublico = true;

    #[ORM\Column]
    private ?bool $permitirSuscripciones = true;

    #[ORM\Column]
    private ?bool $permitirDescargar = false;

    #[ORM\OneToOne(inversedBy: 'privacidadUsuario', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name: "id_usuario")]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPublico(): ?bool
    {
        return $this->isPublico;
    }

    public function setIsPublico(bool $isPublico): static
    {
        $this->isPublico = $isPublico;

        return $this;
    }

    public function isPermitirSuscripciones(): ?bool
    {
        return $this->permitirSuscripciones;
    }

    public function setPermitirSuscripciones(bool $permitirSuscripciones): static
    {
        $this->permitirSuscripciones = $permitirSuscripciones;

        return $this;
    }

    public function isPermitirDescargar(): ?bool
    {
        return $this->permitirDescargar;
    }

    public function setPermitirDescargar(bool $permitirDescargar): static
    {
        $this->permitirDescargar = $permitirDescargar;

        return $this;
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
}
