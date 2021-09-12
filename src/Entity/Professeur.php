<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfesseurRepository::class)
 */
class Professeur
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
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"liste_cours"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birth_day;

    /**
     * @ORM\ManyToMany(targetEntity=Exam::class, mappedBy="surveillants")
     */
    private $exams;

    public function __construct()
    {
        $this->exams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }


    public function getFullName(): ?string
    {
        return $this->last_name.' '.$this->first_name;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birth_day;
    }

    public function setBirthDay(?\DateTimeInterface $birth_day): self
    {
        $this->birth_day = $birth_day;

        return $this;
    }

    /**
     * @return Collection|Exam[]
     */
    public function getExams(): Collection
    {
        return $this->exams;
    }

    public function addExam(Exam $exam): self
    {
        if (!$this->exams->contains($exam)) {
            $this->exams[] = $exam;
            $exam->addSurveillants($this);
        }

        return $this;
    }

    public function removeExam(Exam $exam): self
    {
        if ($this->exams->contains($exam)) {
            $this->exams->removeElement($exam);
            $exam->removeSurveillants($this);
        }

        return $this;
    }
}
