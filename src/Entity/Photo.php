<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Link;
use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\CreatePhotoAction;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
)]
#[ApiResource(
    uriTemplate: '/guinea-pigs/{guineaPigId}/photos',
    uriVariables: [
        'guineaPigId' => new Link(fromProperty: 'photos', fromClass: GuineaPig::class),
    ],
    operations: [
        new Get(
            uriTemplate: '/guinea-pigs/{guineaPigId}/photos/{id}',
            uriVariables: [
                'guineaPigId' => new Link(fromProperty: 'photos', fromClass: GuineaPig::class),
                'id' => new Link(fromProperty: 'id', fromClass: Photo::class),
            ],
        ),
        new GetCollection(),
        new Post(
            controller: CreatePhotoAction::class,
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ],
                                ],
                            ],
                        ],
                    ]),
                ),
            ),
            validationContext: ['groups' => ['Default', 'photo_create']],
            deserialize: false,
        ),
        new Delete(security: 'object.getGuineaPig().getOwner() == user'),
    ],
)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?GuineaPig $guineaPig = null;

    #[ApiProperty]
    #[Groups(['media_object:read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: 'photo', fileNameProperty: 'filePath')]
    #[Assert\NotNull(groups: ['photo_create'])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuineaPig(): ?GuineaPig
    {
        return $this->guineaPig;
    }

    public function setGuineaPig(?GuineaPig $guineaPig): static
    {
        $this->guineaPig = $guineaPig;

        return $this;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): static
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }
}
