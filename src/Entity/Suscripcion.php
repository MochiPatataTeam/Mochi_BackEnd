<?php

namespace App\Entity;

use App\Repository\SuscripcionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuscripcionRepository::class)]
#[ORM\Table(name: "suscripcion", schema: "mochi")]
class Suscripcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_suscriptor")]
    private ?Usuario $suscriptor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name:"id_canal")]
    private ?Usuario $canal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuscriptor(): ?Usuario
    {
        return $this->suscriptor;
    }

    public function setSuscriptor(?Usuario $suscriptor): static
    {
        $this->suscriptor = $suscriptor;

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
