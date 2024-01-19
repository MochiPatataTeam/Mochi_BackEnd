<?php

namespace App\DTOs;

class RespuestaDTO
{
    private ?int $id = null;
    private ?string $comentario = null;
    private ?string $mensaje = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): void
    {
        $this->comentario = $comentario;
    }



    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(?string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }


}