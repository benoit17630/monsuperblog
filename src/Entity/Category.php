<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="4", max="50",
     *     minMessage="votre titre doit etre de 4 lettre au minimum"
     * maxMessage="votre titre ne doit pas depasser 50 lettres")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex("^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$",
     *     message="votre couleur n est pas une couleur hexadecimal")
     */
    private $color;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     */
    private $creationDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type(type="boolean")
     */
    private $isPublished;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPublicationDate(): ?DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
