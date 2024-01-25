<?php

namespace App\Entity;

use App\Repository\NotificaciónRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificaciónRepository::class)]
#[ORM\Table(name: "notificacion", schema: "mochi")]
class Notificación
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
}
