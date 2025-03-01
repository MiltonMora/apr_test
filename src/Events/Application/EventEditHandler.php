<?php

namespace App\Events\Application;


use App\Commons\Helpers\ValidateConstraints;
use App\Events\Application\Command\EventEdit;
use App\Events\Domain\Ports\EventsInterface;
use App\Spaces\Domain\Model\Spaces;
use App\Spaces\Domain\Ports\SpacesInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class EventEditHandler
{
    public function __construct(
        private EventsInterface $events,
        private ValidateConstraints $validateConstraints,
        private Security $security,
        private SpacesInterface $spaces,
    ) {
    }

    public function handle(EventEdit $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $space = $this->spaces->findById($command->getSpaceId());
        if(!$space) {
            throw new BadRequestHttpException(json_encode(['Espacio no encontrado']));
        }

        $event = $this->events->findById($command->getEventId());

        if ($this->security->getUser() !== $event->getOrganizer()) {
            throw new BadRequestHttpException(json_encode(['No tienes permisos para editar este Evento']));
        }

        if (!$this->checkAvailability($command, $space)) {
            throw new BadRequestHttpException(json_encode(['Existe una reserva que entra en conflicto por favor verifca las fechas y el espacio']));
        }

        $event->setName($command->getName());
        $event->setOrganizer($this->security->getUser());
        $event->setState(true);
        $event->setStart($command->getStart());
        $event->setEnd($command->getEnd());
        $event->setSpace($space);
        $this->events->save($event);
    }

    private function checkAvailability(EventEdit $command, Spaces $space): bool
    {
        $data = $this->events->findByEventIdBetweenData($command->getStart(), $command->getEnd());
        if(empty($data)) {
            return true;
        }
        foreach ($data as $key => $event) {
            if ($event->getOrganizer() === $this->security->getUser() && $event->getSpace() === $space) {
                unset($data[$key]);
            }
        };
        return empty($data);
    }
}
