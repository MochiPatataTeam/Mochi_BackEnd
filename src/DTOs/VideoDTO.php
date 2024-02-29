<?php

namespace App\DTOs;

use Doctrine\Common\Collections\Collection;

class VideoDTO
{
    private ?int $id = null;
    private ?string $titulo = null;
    private ?string $descripcion = null;
    private ?string $url = null;
    private ?string $canal = null;
    private ?string $tematica = null;
    private ?array $comentarioDTO = null;
    private ?array $valoracionGlobalDTO = null;

    public function getValoracionGlobalDTO(): ?array
    {
        return $this->valoracionGlobalDTO;
    }

    public function setValoracionGlobalDTO(?array $valoracionGlobalDTO): void
    {
        $this->valoracionGlobalDTO = $valoracionGlobalDTO;
    }

    public function getComentarioDTO(): ?array
    {
        return $this->comentarioDTO;
    }

    public function setComentarioDTO(?array $comentarioDTO): void
    {
        $this->comentarioDTO = $comentarioDTO;
    }

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

    public function getTematica(): ?string
    {
        return $this->tematica;
    }

    public function setTematica(?string $tematica): void
    {
        $this->tematica = $tematica;
    }



}