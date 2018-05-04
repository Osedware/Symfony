<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoticiaRepository")
 */
class Noticia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $seccion;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $equipo;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $textoNoticia;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $textoTitular;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $imagen;

    /*Getters&Setters*/
    public function getId()
    {
        return $this->id;
    }

    public function getSeccion(): ?string
    {
        return $this->seccion;
    }

    public function setSeccion(string $seccion): self
    {
        $this->seccion = $seccion;

        return $this;
    }

    public function getEquipo(): ?string
    {
        return $this->equipo;
    }

    public function setEquipo(string $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextoTitular()
    {
        return $this->textoTitular;
    }

    /**
     * @param mixed $textoTitular
     */
    public function setTextoTitular($textoTitular): void
    {
        $this->textoTitular = $textoTitular;
    }

    /**
     * @return mixed
     */
    public function getTextoNoticia()
    {
        return $this->textoNoticia;
    }

    /**
     * @param mixed $textoNoticia
     */
    public function setTextoNoticia($textoNoticia): void
    {
        $this->textoNoticia = $textoNoticia;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
    }
}
