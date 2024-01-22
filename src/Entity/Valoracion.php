<?php

namespace App\Entity;

use App\Repository\ValoracionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValoracionRepository::class)]
#[ORM\Table(name: "valoracion", schema: "mochi")]
class Valoracion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $fav = false;

    #[ORM\Column]
    private ?bool $dislike = false;

    #[ORM\ManyToOne(inversedBy: 'valoraciones')]
    #[ORM\JoinColumn(nullable: false, name:"id_video")]
    private ?Video $video = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_usuario")]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isFav(): ?bool
    {
        return $this->fav;
    }

    public function setFav(bool $fav): static
    {
        $this->fav = $fav;

        return $this;
    }

    public function isDislike(): ?bool
    {
        return $this->dislike;
    }

    public function setDislike(bool $dislike): static
    {
        $this->dislike = $dislike;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): static
    {
        $this->video = $video;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
