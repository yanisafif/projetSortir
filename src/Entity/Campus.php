<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampusRepository::class)
 */
class Campus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCampus;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCampus(): ?int
    {
        return $this->idCampus;
    }

    public function setIdCampus(int $idCampus): self
    {
        $this->idCampus = $idCampus;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
