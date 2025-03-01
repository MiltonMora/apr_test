<?php

namespace App\Events\Application;


use App\Events\Application\Command\EventList;
use App\Events\Domain\Ports\EventsInterface;

readonly class EventListHandler
{
    public function __construct(private EventsInterface $events) {
    }

    public function handle(EventList $command): array
    {
        return $this->events->listAll();
    }
}
