<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"notes"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"notes"})
     */
    private $moyenne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"notes"})
     */
    private $appreciation;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"notes"})
     */
    private $bareme;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="notes")
     * @Groups({"notes"})
     */
    private $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="notes")
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity=Exam::class, inversedBy="notes")
     */
    private $exam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(?float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getAppreciation(): ?string
    {
        return $this->appreciation;
    }

    public function setAppreciation(string $appreciation): self
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    public function getBareme(): ?float
    {
        return $this->bareme;
    }

    public function setBareme(?float $bareme): self
    {
        $this->bareme = $bareme;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

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

    public function getExam(): ?Exam
    {
        return $this->exam;
    }

    public function setExam(?Exam $exam): self
    {
        $this->exam = $exam;

        return $this;
    }
}
