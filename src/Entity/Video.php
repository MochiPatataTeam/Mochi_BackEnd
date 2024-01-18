<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\Table(name: "video", schema: "mochi")]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 500)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'videos', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name: "id_canal")]
    private ?Usuario $canal = null;


    //#[ORM\ManyToOne]
    //#[ORM\JoinColumn(nullable: false, name: "id_canal")]
    //private ?Usuario $canal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCanal(): ?Usuario
    {
        return $this->canal;
    }

    public function setCanal(?Usuario $canal): static
    {
        $this->canal = $canal;

        return $this;
    }

}
