<?php

namespace App\Spaces\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;
readonly class SpacesCreate
{
    #[Assert\NotBlank]
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }


}
