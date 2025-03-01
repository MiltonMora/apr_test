<?php

namespace App\Events\Domain\Ports;

use App\Events\Domain\Model\Events;
use App\Spaces\Domain\Model\Spaces;

interface EventsInterface
{
    public function save(Events $events): void;

    public function listAll(): array;

    public function findById(string $id): ?Events;

    public function findBySpaces(Spaces $space): array;

    public function findByEventIdBetweenData(\DateTime $start, \DateTime $end): array;
}
