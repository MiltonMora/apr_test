<?php

namespace App\User\Domain\Ports;

use App\User\Domain\Model\User;

interface UserInterface
{
    public function save(User $user): void;

    public function listAll(): array;

    public function findById(string $id): ?User;
}
