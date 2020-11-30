<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min="4", max="255",
     *     minMessage="ton titre est trop court",
     *     maxMessage="ton titre est trop long")
     * @Assert\NotBlank(message="le formulaire est vide")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length (min="4", max="255",
     *     minMessage="trop peu de lettres",
     *      maxMessage="ta description est trop longue")
     *
     */
    private $content;

/*
 *  * @Assert\Regex("([^\s]+(\.(?i)(jpg|png|gif|bmp))$)",
     *     message="se n est pas une image")
 */
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * a rajouter les lignes du haut
     * la je les ait commenter car dans mes fixture faker sa ma generer des lien d image sans extension
     *
     */
    private $image;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     *
     * grâce à la ligne de commande bin/console make:entity Article ou symfony make:entity Article
     * j'ai ajouté une propriété à mon entité (donc une colonne à ma table article)
     * Cette propriété représente une relation vers la table article
     * (donc elle cible l'entité Category)
     * C'est un ManyToOne car je veux avoir une seule catégorie par article,
     * mais (éventuellement) plusieurs articles par catégorie
     * Le inversedBy permet de savoir dans l'entité reliée (donc Category) la propriété
     * qui re-pointe vers l'entité Article (ici c'est la propriété articles)
     */
    private $category;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate( $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function setPublicationDate( $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
