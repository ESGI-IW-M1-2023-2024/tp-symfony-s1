<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $heure = null;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Secteur $secteur = null;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salle $salle = null;

    #[ORM\OneToMany(mappedBy: 'atelier', targetEntity: Metier::class)]
    private Collection $metiers;

    #[ORM\OneToMany(mappedBy: 'atelier', targetEntity: Ressource::class, cascade: ['persist'])]
    private Collection $ressources;

    #[ORM\ManyToMany(targetEntity: Intervenant::class, inversedBy: 'ateliers')]
    private Collection $intervenants;

    #[ORM\ManyToMany(targetEntity: Lyceen::class, mappedBy: 'ateliers')]
    private Collection $lyceens;

    public function __toString(): string
    {
        return $this->id.' - '.$this->nom.' - '.$this->heure;
    }
    public function __construct()
    {
        $this->metiers = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->intervenants = new ArrayCollection();
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

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): static
    {
        $this->heure = $heure;

        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): static
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return Collection<int, Metier>
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(Metier $metier): static
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers->add($metier);
            $metier->setAtelier($this);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): static
    {
        if ($this->metiers->removeElement($metier)) {
            // set the owning side to null (unless already changed)
            if ($metier->getAtelier() === $this) {
                $metier->setAtelier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ressource>
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources->add($ressource);
            $ressource->setAtelier($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getAtelier() === $this) {
                $ressource->setAtelier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intervenant>
     */
    public function getIntervenants(): Collection
    {
        return $this->intervenants;
    }

    public function addIntervenant(Intervenant $intervenant): static
    {
        if (!$this->intervenants->contains($intervenant)) {
            $this->intervenants->add($intervenant);
        }

        return $this;
    }

    public function removeIntervenant(Intervenant $intervenant): static
    {
        $this->intervenants->removeElement($intervenant);

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
            $lyceen->addAtelier($this);
        }

        return $this;
    }

    public function removeLyceen(Lyceen $lyceen): static
    {
        if ($this->lyceens->removeElement($lyceen)) {
            $lyceen->removeAtelier($this);
        }

        return $this;
    }

    public function countLyceens(){
        return count($this->getLyceens());
    }

}
