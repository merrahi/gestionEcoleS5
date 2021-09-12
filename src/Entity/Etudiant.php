<?php

namespace App\Entity;

use App\Entity\Groupe;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 * @ORM\Table(name="etudiant")
 * @ORM\HasLifecycleCallbacks()
 */

class Etudiant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"myread","notes"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"myread","notes"})
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"myread","notes"})
     */
    private $first_name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Groups({"myread"})
     *
     */
    private $birth_day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="etudiants")
     */
    private $groupe;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="etudiant")
     */
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
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

    public function getBirthDay(): ?\DateTime
    {
        return $this->birth_day;
    }

    public function setBirthDay(\DateTime $birth_day): self
    {
        $this->birth_day = $birth_day;

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
            $note->setEtudiant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getEtudiant() === $this) {
                $note->setEtudiant(null);
            }
        }

        return $this;
    }
}
