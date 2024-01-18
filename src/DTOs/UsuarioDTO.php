<?php

namespace App\DTOs;

class UsuarioDTO
{
private ?int $id =null;
private ?string $nombre =null;
private ?string $apellidos =null;
private ?string $username = null;
private ?string $password = null;
private ?string $email = null;
private ?int $telefono = null;
private ?string $nombre_canal = null;
private ?string $descripcion = null;
private ?int $suscriptores = null;
private ?string $imagen = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getNombreCanal(): ?string
    {
        return $this->nombre_canal;
    }

    public function setNombreCanal(?string $nombre_canal): void
    {
        $this->nombre_canal = $nombre_canal;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getSuscriptores(): ?int
    {
        return $this->suscriptores;
    }

    public function setSuscriptores(?int $suscriptores): void
    {
        $this->suscriptores = $suscriptores;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): void
    {
        $this->imagen = $imagen;
    }


}
