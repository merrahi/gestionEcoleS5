<?php

namespace App\Entity;


use App\Entity\Etudiant;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"myread"})
     * @Groups({"liste_cours"})
     * @Groups({"filiere_groupes"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"myread"})
     * @Groups({"liste_cours"})
     * @Groups({"filiere_groupes"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="groupe")
     * @Groups({"myread","filiere_groupes"})
     *
     */
    private $etudiants;

    /**
     * @ORM\OneToMany(targetEntity=Exam::class, mappedBy="groupe_e")
     */
    private $exams;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="groupes")
     */
    private $filiere;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $annee_debut;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee_fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class, mappedBy="groupes")
     * @Groups({"groupe_modules"})
     */
    private $modules;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
        $this->exams = new ArrayCollection();
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setGroupe($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getGroupe() === $this) {
                $etudiant->setGroupe(null);
            }
        }

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
            $exam->setGroupeE($this);
        }

        return $this;
    }

    public function removeExam(Exam $exam): self
    {
        if ($this->exams->contains($exam)) {
            $this->exams->removeElement($exam);
            // set the owning side to null (unless already changed)
            if ($exam->getGroupeE() === $this) {
                $exam->setGroupeE(null);
            }
        }

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getAnneeDebut(): ?int
    {
        return $this->annee_debut;
    }

    public function setAnneeDebut(?int $annee_debut): self
    {
        $this->annee_debut = $annee_debut;

        return $this;
    }

    public function getAnneeFin(): ?int
    {
        return $this->annee_fin;
    }

    public function setAnneeFin(int $annee_fin): self
    {
        $this->annee_fin = $annee_fin;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->addGroupe($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
            $module->removeGroupe($this);
        }

        return $this;
    }
}
