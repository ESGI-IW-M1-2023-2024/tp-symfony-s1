<?php

namespace App\Entity;

use App\Repository\LyceeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LyceeRepository::class)]
class Lycee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'lycee', targetEntity: Lyceen::class)]
    private Collection $lyceens;

    public function __construct()
    {
        $this->lyceens = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Lyceen>
     */
    public function getLyceens(): Collection
    {
        return $this->lyceens;
    }

    public function addLyceen(Lyceen $lyceen): static
    {
        if (!$this->lyceens->contains($lyceen)) {
            $this->lyceens->add($lyceen);
            $lyceen->setLycee($this);
        }

        return $this;
    }

    public function removeLyceen(Lyceen $lyceen): static
    {
        if ($this->lyceens->removeElement($lyceen)) {
            // set the owning side to null (unless already changed)
            if ($lyceen->getLycee() === $this) {
                $lyceen->setLycee(null);
            }
        }

        return $this;
    }
}
