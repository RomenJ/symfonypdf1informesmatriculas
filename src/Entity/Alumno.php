<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
class Alumno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datereg = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Colegio $colegio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDatereg(): ?\DateTimeInterface
    {
        return $this->datereg;
    }

    public function setDatereg(?\DateTimeInterface $datereg): self
    {
        $this->datereg = $datereg;

        return $this;
    }

    public function getColegio(): ?Colegio
    {
        return $this->colegio;
    }

    public function setColegio(?Colegio $colegio): self
    {
        $this->colegio = $colegio;

        return $this;
    }
    function __toString(){
        return $this->name .' '. $this->surname  ;
    }
}
