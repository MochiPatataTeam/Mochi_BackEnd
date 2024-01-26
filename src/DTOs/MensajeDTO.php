<?php

namespace App\DTOs;

class MensajeDTO
{
    private ?int $id = null;

    private ?string $mensaje = null;

    private ?\DateTimeInterface $fecha = null;

    private ?string $id_emisor = null;

    private ?string $id_receptor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(?string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getIdEmisor(): ?string
    {
        return $this->id_emisor;
    }

    public function setIdEmisor(?string $id_emisor): void
    {
        $this->id_emisor = $id_emisor;
    }

    public function getIdReceptor(): ?string
    {
        return $this->id_receptor;
    }

    public function setIdReceptor(?string $id_receptor): void
    {
        $this->id_receptor = $id_receptor;
    }
}