<?php

namespace App\DTOs;

class PrivacidadUsuarioDTO
{
    private ?int $id = null;
    private ?bool $isPublico = null;
    private ?bool $permitirSuscripciones = null;
    private ?bool $permitirDescargar = null;
    private ?string $usuario = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getIsPublico(): ?bool
    {
        return $this->isPublico;
    }

    public function setIsPublico(?bool $isPublico): void
    {
        $this->isPublico = $isPublico;
    }

    public function getPermitirSuscripciones(): ?bool
    {
        return $this->permitirSuscripciones;
    }

    public function setPermitirSuscripciones(?bool $permitirSuscripciones): void
    {
        $this->permitirSuscripciones = $permitirSuscripciones;
    }

    public function getPermitirDescargar(): ?bool
    {
        return $this->permitirDescargar;
    }

    public function setPermitirDescargar(?bool $permitirDescargas): void
    {
        $this->permitirDescargar = $permitirDescargas;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(?string $usuario): void
    {
        $this->usuario = $usuario;
    }





}