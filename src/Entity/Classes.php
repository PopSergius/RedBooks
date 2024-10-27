<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Classes")]
class Classes
{
    #[ORM\Id]
    #[ORM\Column(name:'Classes_code', type: "string", length: 50)]
    private ?string $Classes_code = null;

    #[ORM\Column(name:'Classes_name', type: "string", length: 100)]
    private ?string $Classes_name = null;

    public function getClassesCode(): ?string
    {
        return $this->Classes_code;
    }

    public function setClassesCode(string $Classes_code): self
    {
        $this->Classes_code = $Classes_code;
        return $this;
    }

    public function getClassesName(): ?string
    {
        return $this->Classes_name;
    }

    public function setClassesName(string $Classes_name): self
    {
        $this->Classes_name = $Classes_name;
        return $this;
    }
}
