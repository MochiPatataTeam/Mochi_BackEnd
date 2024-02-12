<?php

namespace App\DTOs;

class ValoracionGlobalDTO
{

    private ?int $fav ;
    private ?int $dislike;
    private ?int $visualizacion = 0;


    public function getFav(): ?int
    {
        return $this->fav;
    }

    public function setFav(?int $fav): void
    {
        $this->fav = $fav;
    }

    public function getDislike(): ?int
    {
        return $this->dislike;
    }

    public function setDislike(?int $dislike): void
    {
        $this->dislike = $dislike;
    }

    public function getVisualizacion(): ?int
    {
        return $this->visualizacion;
    }

    public function setVisualizacion(?int $visualizacion): void
    {
        $this->visualizacion = $visualizacion;
    }





}