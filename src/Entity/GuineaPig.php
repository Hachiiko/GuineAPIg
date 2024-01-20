<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Repository\GuineaPigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GuineaPigRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read'],
    denormalizationContext: ['groups' => 'write'],
    operations: [
        new Get(),
        new GetCollection(),
        new Put(security: 'object.getOwner() == user'),
        new Delete(security: 'object.getOwner() == user'),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
    'breed' => 'partial',
    'color' => 'partial',
    'age' => 'partial',
])]
class GuineaPig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?User $owner = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $breed = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $color = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'guineaPig', targetEntity: Photo::class)]
    private Collection $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
        }

        return $this;
    }
}
