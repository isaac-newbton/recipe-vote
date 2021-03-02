<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait CreatedDateTimeTrait {
    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    protected $createdDateTime;

    public function getCreatedDateTime(): ?\DateTimeInterface {
        return $this->createdDateTime;
    }
}