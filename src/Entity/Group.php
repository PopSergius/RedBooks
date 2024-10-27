<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "`Group`")]
class Group
{
    #[ORM\Id]
    #[ORM\Column(name:'Group_code', type: "string", length: 50)]
    private ?string $Group_code = null;

    #[ORM\Column(name:'Group_name', type: "string", length: 100)]
    private ?string $Group_name = null;

    public function getGroupCode(): ?string
    {
        return $this->Group_code;
    }

    public function setGroupCode(string $Group_code): self
    {
        $this->Group_code = $Group_code;
        return $this;
    }

    public function getGroupName(): ?string
    {
        return $this->Group_name;
    }

    public function setGroupName(string $Group_name): self
    {
        $this->Group_name = $Group_name;
        return $this;
    }
}
