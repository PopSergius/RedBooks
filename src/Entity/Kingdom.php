<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Kingdom")]
class Kingdom
{
    #[ORM\Id]
    #[ORM\Column(name:'Kingdom_code', type: "string", length: 50)]
    private ?string $Kingdom_code = null;

    #[ORM\Column(name:'Kingdom_name',type: "string", length: 100)]
    private ?string $Kingdom_name = null;

    public function getKingdomCode(): ?string
    {
        return $this->Kingdom_code;
    }

    public function setKingdomCode(string $Kingdom_code): self
    {
        $this->Kingdom_code = $Kingdom_code;
        return $this;
    }

    public function getKingdomName(): ?string
    {
        return $this->Kingdom_name;
    }

    public function setKingdomName(string $Kingdom_name): self
    {
        $this->Kingdom_name = $Kingdom_name;
        return $this;
    }
}
