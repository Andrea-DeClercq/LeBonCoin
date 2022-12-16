<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Annonce::class)]
    private Collection $CategorieAnnonce;

    public function __construct()
    {
        $this->CategorieAnnonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getCategorieAnnonce(): Collection
    {
        return $this->CategorieAnnonce;
    }

    public function addCategorieAnnonce(Annonce $categorieAnnonce): self
    {
        if (!$this->CategorieAnnonce->contains($categorieAnnonce)) {
            $this->CategorieAnnonce->add($categorieAnnonce);
            $categorieAnnonce->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorieAnnonce(Annonce $categorieAnnonce): self
    {
        if ($this->CategorieAnnonce->removeElement($categorieAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($categorieAnnonce->getCategorie() === $this) {
                $categorieAnnonce->setCategorie(null);
            }
        }

        return $this;
    }
}
