<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $module = null;

    #[ORM\Column(length: 100)]
    private ?string $professeur = null;

    #[ORM\Column(length: 50)]
    private ?Niveau $niveaux = [];

    #[ORM\Column(length: 50)]
    private ?Classe $classes = [];

    #[ORM\Column(length: 50)]
    private ?Session $sessions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function setModule(string $module): static
    {
        $this->module = $module;

        return $this;
    }

    public function getProfesseur(): ?string
    {
        return $this->professeur;
    }

    public function setProfesseur(string $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getNiveaux(): ?Niveau
    {
        return $this->niveaux;
    }

    public function setNiveaux(Niveau $niveaux): static
    {
        $this->niveaux = $niveaux;

        return $this;
    }

    public function getClasses(): ?Niveau
    {
        return $this->classes;
    }

    public function setClasses(Niveau $classes): static
    {
        $this->classes = $classes;

        return $this;
    }

    public function getSessions() {
        return $this->sessions;
    }
}
