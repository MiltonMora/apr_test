<?php

namespace App\Events\Application;


use App\Commons\Helpers\ValidateConstraints;
use App\Events\Application\Command\EventCancel;
use App\Events\Application\Command\EventCreate;
use App\Events\Application\Command\EventEdit;
use App\Events\Domain\Model\Events;
use App\Events\Domain\Ports\EventsInterface;
use App\Spaces\Domain\Model\Spaces;
use App\Spaces\Domain\Ports\SpacesInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class EventCancelHandler
{
    public function __construct(
        private EventsInterface $events,
        private ValidateConstraints $validateConstraints,
        private Security $security
    ) {
    }

    public function handle(EventCancel $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $event = $this->events->findById($command->getEventId());

        if ($this->security->getUser() !== $event->getOrganizer()) {
            throw new BadRequestHttpException(json_encode(['No tienes permisos para editar este Evento']));
        }
        $event->setState(false);
        $this->events->save($event);
    }
}
