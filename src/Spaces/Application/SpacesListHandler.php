<?php

namespace App\Spaces\Application;


use App\Events\Domain\Ports\EventsInterface;
use App\Spaces\Application\Command\SpacesList;
use App\Spaces\Domain\Ports\SpacesInterface;

readonly class SpacesListHandler
{
    public function __construct(
        private SpacesInterface $spaces,
        private EventsInterface $events
    ) {
    }

    public function handle(SpacesList $command): array
    {
        $spacesData = $this->spaces->listAll();
        foreach ($spacesData as $space) {
            $events = $this->events->findBySpaces($space);
            $space->setEvents($events) ?? [];
        }
        return $spacesData;
    }
}
