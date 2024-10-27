<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "EntityObject")]
class EntityObject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $Name = null;

    #[ORM\ManyToOne(targetEntity: Kingdom::class)]
    #[ORM\JoinColumn(name: "Kingdom_code", referencedColumnName: "Kingdom_code")]
    private ?Kingdom $Kingdom = null;

    #[ORM\ManyToOne(targetEntity: Classes::class)]
    #[ORM\JoinColumn(name: "Classes_code", referencedColumnName: "Classes_code")]
    private ?Classes $Classes = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: "Category_code", referencedColumnName: "Category_code")]
    private ?Category $Category = null;

    #[ORM\ManyToOne(targetEntity: Family::class)]
    #[ORM\JoinColumn(name: "Family_code", referencedColumnName: "Family_code")]
    private ?Family $Family = null;

    #[ORM\Column(name: '`range`', type: 'text', nullable: true)]
    private ?string $Range = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $Population = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $Habitats = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $Threats = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $ImageSrc = null;

    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: "objects")]
    #[ORM\JoinTable(name: "ObjectCountry",
        joinColumns: [new ORM\JoinColumn(name: "id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "Country_code", referencedColumnName: "Country_code")])]
    private Collection $Countries;

    public function __construct()
    {
        $this->Countries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;
        return $this;
    }

    public function getKingdom(): ?Kingdom
    {
        return $this->Kingdom;
    }

    public function setKingdom(?Kingdom $Kingdom): self
    {
        $this->Kingdom = $Kingdom;
        return $this;
    }

    public function getClasses(): ?Classes
    {
        return $this->Classes;
    }

    public function setClasses(?Classes $Classes): self
    {
        $this->Classes = $Classes;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;
        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->Family;
    }

    public function setFamily(?Family $Family): self
    {
        $this->Family = $Family;
        return $this;
    }

    public function getRange(): ?string
    {
        return $this->Range;
    }

    public function setRange(?string $Range): self
    {
        $this->Range = $Range;
        return $this;
    }

    public function getPopulation(): ?string
    {
        return $this->Population;
    }

    public function setPopulation(?string $Population): self
    {
        $this->Population = $Population;
        return $this;
    }

    public function getHabitats(): ?string
    {
        return $this->Habitats;
    }

    public function setHabitats(?string $Habitats): self
    {
        $this->Habitats = $Habitats;
        return $this;
    }

    public function getThreats(): ?string
    {
        return $this->Threats;
    }

    public function setThreats(?string $Threats): self
    {
        $this->Threats = $Threats;
        return $this;
    }

    public function getImageSrc(): ?string
    {
        return $this->ImageSrc;
    }

    public function setImageSrc(?string $ImageSrc): self
    {
        $this->ImageSrc = $ImageSrc;
        return $this;
    }

    /**
     * @return Collection<int, Country>
     */

    public function getCountries(): Collection
    {
        return $this->Countries;
    }

    public function setCountries(Collection $countries): self
    {
        $this->Countries = $countries;
        return $this;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->Countries->contains($country)) {
            $this->Countries->add($country);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        $this->Countries->removeElement($country);

        return $this;
    }
}