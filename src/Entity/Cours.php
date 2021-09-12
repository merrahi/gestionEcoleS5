<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"liste_cours"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste_cours"})
     */
    private $intro;

    /**
     * @Groups({"liste_cours"})
     * @ORM\Column(type="date")
     */
    private $fait_le;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"liste_cours"})
     */
    private $start_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"liste_cours"})
     */
    private $end_at;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, cascade={"persist", "remove"})
     * @Groups({"liste_cours"})
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity=Professeur::class, cascade={"persist", "remove"})
     * @Groups({"liste_cours"})
     */
    private $professeur;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, cascade={"persist", "remove"})
     * @Groups({"liste_cours"})
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, cascade={"persist", "remove"})
     * @Groups({"liste_cours"})
     */
    private $groupe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $periodic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getFaitLe(): ?\DateTimeInterface
    {
        return $this->fait_le;
    }

    public function setFaitLe(\DateTimeInterface $fait_le): self
    {
        $this->fait_le = $fait_le;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(\DateTimeInterface $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getPeriodic(): ?string
    {
        return $this->periodic;
    }

    public function setPeriodic(string $periodic): self
    {
        $this->periodic = $periodic;

        return $this;
    }
}
