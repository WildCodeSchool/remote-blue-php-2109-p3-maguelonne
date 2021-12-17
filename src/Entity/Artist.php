<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $repository;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $video;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $audio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $nationalty;

    /**
     * @ORM\Column(type="text")
     */
    private string $body;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $instruments = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $alt;

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="artist")
     */
    private Collection $company;

    /**
     * @ORM\OneToMany(targetEntity=Reward::class, mappedBy="artist")
     */
    private Collection $reward;

    /**
     * @ORM\OneToMany(targetEntity=Study::class, mappedBy="artist")
     */
    private Collection $study;

    public function __construct()
    {
        $this->company = new ArrayCollection();
        $this->reward = new ArrayCollection();
        $this->study = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function setRepository(?string $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getNationalty(): ?string
    {
        return $this->nationalty;
    }

    public function setNationalty(string $nationalty): self
    {
        $this->nationalty = $nationalty;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getInstruments(): ?array
    {
        return $this->instruments;
    }

    public function setInstruments(?array $instruments): self
    {
        $this->instruments = $instruments;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company[] = $company;
            $company->setArtist($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->company->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getArtist() === $this) {
                $company->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reward[]
     */
    public function getReward(): Collection
    {
        return $this->reward;
    }

    public function addReward(Reward $reward): self
    {
        if (!$this->reward->contains($reward)) {
            $this->reward[] = $reward;
            $reward->setArtist($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        if ($this->reward->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getArtist() === $this) {
                $reward->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Study[]
     */
    public function getStudy(): Collection
    {
        return $this->study;
    }

    public function addStudy(Study $study): self
    {
        if (!$this->study->contains($study)) {
            $this->study[] = $study;
            $study->setArtist($this);
        }

        return $this;
    }

    public function removeStudy(Study $study): self
    {
        if ($this->study->removeElement($study)) {
            // set the owning side to null (unless already changed)
            if ($study->getArtist() === $this) {
                $study->setArtist(null);
            }
        }

        return $this;
    }
}
