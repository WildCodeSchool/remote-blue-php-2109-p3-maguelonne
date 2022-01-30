<?php

namespace App\Entity;

use DateTime;
use App\Entity\ArticleCategory;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article implements TranslatableInterface
{
    use TranslatableTrait;

   /**
    * @var int
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $poster;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private int $duration;

    /**
     * @ORM\ManyToOne(targetEntity=ArticleCategory::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?ArticleCategory $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?ArticleCategory
    {
        return $this->category;
    }

    public function setCategory(?ArticleCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->translate()->getTitle();
    }

    public function setTitle(string $title): self
    {
        $this->translate()->setTitle($title);
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->translate()->getSlug();
    }

    public function setSlug(string $slug): self
    {
        $this->translate()->setSlug($slug);
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->translate()->getBody();
    }

    public function setBody(string $body): self
    {
        $this->translate()->setBody($body);
        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->translate()->getAlt();
    }

    public function setAlt(string $alt): self
    {
        $this->translate()->setAlt($alt);
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->translate()->getSummary();
    }

    public function setSummary(string $summary): self
    {
        $this->translate()->setSummary($summary);
        return $this;
    }
}
