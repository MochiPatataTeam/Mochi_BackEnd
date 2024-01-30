<?php

namespace App\Entity;

use App\Repository\MensajeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MensajeRepository::class)]
#[ORM\Table(name: "mensaje", schema: "mochi")]
class Mensaje
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mensaje = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false,name: "id_emisor")]
    private ?Usuario $id_emisor = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false,name: "id_receptor")]
    private ?Usuario $id_receptor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(string $mensaje): static
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha->format('d/m/Y');
    }

    public function setFecha(String $fecha): static
    {
        $this->fecha = \DateTime::createFromFormat('d/m/Y', $fecha);

        return $this;
    }

    public function getIdEmisor(): ?Usuario
    {
        return $this->id_emisor;
    }

    public function setIdEmisor(?Usuario $id_emisor): static
    {
        $this->id_emisor = $id_emisor;

        return $this;
    }

    public function getIdReceptor(): ?Usuario
    {
        return $this->id_receptor;
    }

    public function setIdReceptor(?Usuario $id_receptor): static
    {
        $this->id_receptor = $id_receptor;

        return $this;
    }
}
