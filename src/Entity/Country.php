<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Country")]
class Country
{
    #[ORM\Id]
    #[ORM\Column(name:'Country_code', type: "string", length: 50)]
    private ?string $Country_code = null;

    #[ORM\Column(name:'Country_name', type: "string", length: 100)]
    private ?string $Country_name = null;

    #[ORM\ManyToMany(targetEntity: EntityObject::class, mappedBy: "Countries")]
    private Collection $objects;

    public function __construct()
    {
        $this->objects = new ArrayCollection();
    }

    public function getCountryCode(): ?string
    {
        return $this->Country_code;
    }

    public function setCountryCode(string $Country_code): self
    {
        $this->Country_code = $Country_code;
        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->Country_name;
    }

    public function setCountryName(string $Country_name): self
    {
        $this->Country_name = $Country_name;
        return $this;
    }

    /**
     * @return Collection<int, EntityObject>
     */
    public function getObjects(): Collection
    {
        return $this->objects;
    }

    public function addObject(EntityObject $object): self
    {
        if (!$this->objects->contains($object)) {
            $this->objects->add($object);
            $object->addCountry($this);
        }

        return $this;
    }

    public function removeObject(EntityObject $object): self
    {
        if ($this->objects->removeElement($object)) {
            $object->removeCountry($this);
        }

        return $this;
    }
}
