<?php

namespace App\Entity;

use App\Repository\RecipeVoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=RecipeVoteRepository::class)
 */
class RecipeVote
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
     * @ORM\Column(type="string", length=255)
     */
    private $voterEmail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $voterOptIn;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class, inversedBy="recipeVotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipe;

    public function __construct() {
        $this->uuid = Uuid::uuid4();
        $this->createdDateTime = new \DateTime();
        $this->voterOptIn = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoterEmail(): ?string
    {
        return $this->voterEmail;
    }

    public function setVoterEmail(string $voterEmail): self
    {
        $this->voterEmail = $voterEmail;

        return $this;
    }

    public function getVoterOptIn(): ?bool
    {
        return $this->voterOptIn;
    }

    public function setVoterOptIn(bool $voterOptIn): self
    {
        $this->voterOptIn = $voterOptIn;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
