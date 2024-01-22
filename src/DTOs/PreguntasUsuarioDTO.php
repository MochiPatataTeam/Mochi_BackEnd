<?php

namespace App\DTOs;

class PreguntasUsuarioDTO

{
    private ?int $id = null;
    private ?string $usuario = null;
    private ?string $pregunta = null;
    private ?string $respuesta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(?string $usuario): void
    {
        $this->usuario = $usuario;
    }

    public function getPregunta(): ?string
    {
        return $this->pregunta;
    }

    public function setPregunta(?string $pregunta): void
    {
        $this->pregunta = $pregunta;
    }

    public function getRespuesta(): ?string
    {
        return $this->respuesta;
    }

    public function setRespuesta(?string $respuesta): void
    {
        $this->respuesta = $respuesta;
    }



}