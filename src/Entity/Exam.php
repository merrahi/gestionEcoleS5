<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExamRepository::class)
 */
class Exam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"exams"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)     *
     * @Groups({"exams"})
     */
    private $name_e;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"exams"})
     */
    private $type_e;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"exams"})
     */
    private $fait_le;


    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="exams")
     * @Groups({"exams"})
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="exams")
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="exams")
     */
    private $module;

    /**
     * @ORM\ManyToMany(targetEntity=Professeur::class, inversedBy="exams", cascade={"persist"})
     */
    private $surveillants;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="exam")
     * @Groups({"exams"})
     */
    private $notes;

    public function __construct()
    {
        $this->surveillants = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameE(): ?string
    {
        return $this->name_e;
    }

    public function setNameE(string $name_e): self
    {
        $this->name_e = $name_e;

        return $this;
    }

    public function getTypeE(): ?string
    {
        return $this->type_e;
    }

    public function setTypeE(string $type_e): self
    {
        $this->type_e = $type_e;

        return $this;
    }

    public function getFaitLe(): ?\DateTimeInterface
    {
        return $this->fait_le;
    }

    public function setFaitLe(?\DateTimeInterface $fait_le): self
    {
        $this->fait_le = $fait_le ;

        return $this;
    }

    public function getGroupe(): ?groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getSalle(): ?salle
    {
        return $this->salle;
    }

    public function setSalle(?salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getModule(): ?module
    {
        return $this->module;
    }

    public function setModule(?module $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return Collection|professeur[]
     */
    public function getSurveillants(): Collection
    {
        return $this->surveillants;
    }

    public function addSurveillants(professeur $surveillants): self
    {
        if (!$this->surveillants->contains($surveillants)) {
            $this->surveillants[] = $surveillants;
        }

        return $this;
    }

    public function removeSurveillants(professeur $surveillants): self
    {
        if ($this->surveillants->contains($surveillants)) {
            $this->surveillants->removeElement($surveillants);
        }

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setExam($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getExam() === $this) {
                $note->setExam(null);
            }
        }

        return $this;
    }
}
