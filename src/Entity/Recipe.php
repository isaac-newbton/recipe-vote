<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
{
    use UuidTrait;
    use CreatedDateTimeTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=MediaFile::class)
     */
    private $mainImage;

    /**
     * @ORM\ManyToMany(targetEntity=MediaFile::class)
     */
    private $galleryImages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entryEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $entryOptIn;

    /**
     * @ORM\OneToMany(targetEntity=RecipeVote::class, mappedBy="recipe", orphanRemoval=true)
     */
    private $recipeVotes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $published;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entryName;

    public function __construct()
    {
        $this->galleryImages = new ArrayCollection();
        $this->recipeVotes = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
        $this->createdDateTime = new \DateTime();
        $this->entryOptIn = false;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMainImage(): ?MediaFile
    {
        return $this->mainImage;
    }

    public function setMainImage(?MediaFile $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * @return Collection|MediaFile[]
     */
    public function getGalleryImages(): Collection
    {
        return $this->galleryImages;
    }

    public function addGalleryImage(MediaFile $galleryImage): self
    {
        if (!$this->galleryImages->contains($galleryImage)) {
            $this->galleryImages[] = $galleryImage;
        }

        return $this;
    }

    public function removeGalleryImage(MediaFile $galleryImage): self
    {
        $this->galleryImages->removeElement($galleryImage);

        return $this;
    }

    public function getEntryEmail(): ?string
    {
        return $this->entryEmail;
    }

    public function setEntryEmail(string $entryEmail): self
    {
        $this->entryEmail = $entryEmail;

        return $this;
    }

    public function getEntryOptIn(): ?bool
    {
        return $this->entryOptIn;
    }

    public function setEntryOptIn(bool $entryOptIn): self
    {
        $this->entryOptIn = $entryOptIn;

        return $this;
    }

    /**
     * @return Collection|RecipeVote[]
     */
    public function getRecipeVotes(): Collection
    {
        return $this->recipeVotes;
    }

    public function addRecipeVote(RecipeVote $recipeVote): self
    {
        if (!$this->recipeVotes->contains($recipeVote)) {
            $this->recipeVotes[] = $recipeVote;
            $recipeVote->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeVote(RecipeVote $recipeVote): self
    {
        if ($this->recipeVotes->removeElement($recipeVote)) {
            // set the owning side to null (unless already changed)
            if ($recipeVote->getRecipe() === $this) {
                $recipeVote->setRecipe(null);
            }
        }

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getEntryName(): ?string
    {
        return $this->entryName;
    }

    public function setEntryName(string $entryName): self
    {
        $this->entryName = $entryName;

        return $this;
    }
}
