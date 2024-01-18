<?php

namespace App\DTOs;

class VideoDTO
{
    private ?int $id = null;
    private ?string $titulo = null;
    private ?string $descripcion = null;
    private ?string $url = null;
    private ?string $canal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getCanal(): ?string
    {
        return $this->canal;
    }

    public function setCanal(?string $canal): void
    {
        $this->canal = $canal;
    }



}