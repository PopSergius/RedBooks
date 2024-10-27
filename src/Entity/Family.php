<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Family")]
class Family
{
    #[ORM\Id]
    #[ORM\Column(name:'Family_code', type: "string", length: 50)]
    private ?string $Family_code = null;

    #[ORM\Column(name:'Family_name', type: "string", length: 100)]
    private ?string $Family_name = null;

    public function getFamilyCode(): ?string
    {
        return $this->Family_code;
    }

    public function setFamilyCode(string $Family_code): self
    {
        $this->Family_code = $Family_code;
        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->Family_name;
    }

    public function setFamilyName(string $Family_name): self
    {
        $this->Family_name = $Family_name;
        return $this;
    }
}
