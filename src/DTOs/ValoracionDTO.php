<?php

namespace App\DTOs;

class ValoracionDTO
{
    private ?int $id = null;
    private ?bool $fav = false;
    private ?bool $dislike = false;
    private ?string $video = null;
    private ?string $usuario = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getFav(): ?bool
    {
        return $this->fav;
    }

    public function setFav(?bool $fav): void
    {
        $this->fav = $fav;
    }

    public function getDislike(): ?bool
    {
        return $this->dislike;
    }

    public function setDislike(?bool $dislike): void
    {
        $this->dislike = $dislike;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): void
    {
        $this->video = $video;
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