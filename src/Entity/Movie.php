<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['movie:read']],
)]
#[ApiFilter(RangeFilter::class, properties: ['duration' => 'partial'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'category:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'Le titre du film est obligatoire !')]
    #[Assert\Length(max: 255, maxMessage: 'Le titre doit faire au maximum {{ limit }} caractères')]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read'])]
    #[Assert\NotBlank(message: 'La description est obligatoire !')]
    #[Assert\Length(min: 10, max: 255, minMessage: 'La description doit être d\'au moins {{ limit }} caractères', maxMessage: 'La description doit faire au maximum {{ limit }} caractères')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['movie:read'])]
    #[Assert\NotBlank(message: 'La date de sortie est obligatoire !')]
    #[Assert\Date(message: 'Le date de sortie doit être dans le format (Y-m-d)')]
    private ?\DateTime $releaseDate = null;

    #[ORM\Column]
    #[Groups(['movie:read'])]
    #[Assert\NotBlank(message: 'La durée est obligatoire !')]
    #[Assert\GreaterThan(0, message: 'La durée doit être supérieure à {{ compared_value }}')]
    #[ApiFilter(RangeFilter::class)]
    private ?int $duration = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private Collection $actor;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): ?\DateTime
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actor->removeElement($actor);

        return $this;
    }
}
