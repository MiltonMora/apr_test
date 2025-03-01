<?php

namespace App\Spaces\Domain\Ports;

use App\Spaces\Domain\Model\Spaces;

interface SpacesInterface
{
    public function save(Spaces $spaces): void;

    public function listAll(): array;

    public function findById(string $id): ?Spaces;

}
