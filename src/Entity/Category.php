<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Category")]
class Category
{
    #[ORM\Id]
    #[ORM\Column(name:'Category_code',type: "string", length: 50)]
    private ?string $Category_code = null;

    #[ORM\Column(name:'Category_name', type: "string", length: 100)]
    private ?string $Category_name = null;

    public function getCategoryCode(): ?string
    {
        return $this->Category_code;
    }

    public function setCategoryCode(string $Category_code): self
    {
        $this->Category_code = $Category_code;
        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->Category_name;
    }

    public function setCategoryName(string $Category_name): self
    {
        $this->Category_name = $Category_name;
        return $this;
    }
}
