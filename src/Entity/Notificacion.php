<?php

namespace App\Entity;

use App\Repository\NotificacionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificacionRepository::class)]
#[ORM\Table(name: "notificacion", schema: "mochi")]
class Notificacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_usuario")]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_tipo")]
    private ?TipoNotificacion $tipo = null;

    #[ORM\Column]
    private ?bool $visible = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false,name: "id_creador")]
    private ?Usuario $idCreador = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTipo(): ?TipoNotificacion
    {
        return $this->tipo;
    }

    public function setTipo(?TipoNotificacion $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getIdCreador(): ?Usuario
    {
        return $this->idCreador;
    }

    public function setIdCreador(?Usuario $idCreador): static
    {
        $this->idCreador = $idCreador;

        return $this;
    }
}
