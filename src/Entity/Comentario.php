<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioRepository::class)]
#[ORM\Table(name: "comentario", schema: "mochi")]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $fav = false; //para que me lo ponga por defecto

    #[ORM\Column]
    private ?bool $dislike = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false,name: "id_usuario")]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'comentarios', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name:"id_video")]
    private ?Video $video = null;

    #[ORM\Column(length: 500)]
    private ?string $comentario = null;

    #[ORM\OneToMany(mappedBy: 'comentario', targetEntity: Respuesta::class, orphanRemoval: true)]
    private Collection $respuestas;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
    }

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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

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

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * @return Collection<int, Respuesta>
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuesta $respuesta): static
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas->add($respuesta);
            $respuesta->setComentario($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): static
    {
        if ($this->respuestas->removeElement($respuesta)) {
            // set the owning side to null (unless already changed)
            if ($respuesta->getComentario() === $this) {
                $respuesta->setComentario(null);
            }
        }

        return $this;
    }
}
