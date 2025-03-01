<?php

namespace App\Tests\Events;

use App\Commons\Helpers\ValidateConstraints;
use App\Events\Application\Command\EventCreate;
use App\Events\Application\EventCreateHandler;
use App\Events\Domain\Model\Events;
use App\Events\Domain\Ports\EventsInterface;
use App\Spaces\Domain\Model\Spaces;
use App\Spaces\Domain\Ports\SpacesInterface;
use App\User\Domain\Model\User;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EventCreateHandlerTest extends TestCase
{
    private EventsInterface $events;
    private ValidateConstraints $validateConstraints;
    private Security $security;
    private SpacesInterface $spaces;
    private EventCreateHandler $handler;
    protected function setUp(): void
    {
        $this->events = $this->createMock(EventsInterface::class);
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);
        $this->security = $this->createMock(Security::class);
        $this->spaces = $this->createMock(SpacesInterface::class);
        $this->handler = new EventCreateHandler(
            $this->events,
            $this->validateConstraints,
            $this->security,
            $this->spaces
        );
    }

    public function testHandleFailsWhenEventAlreadyExists(): void
    {
        $start = new \DateTime('2024-03-01 10:00:00');
        $end = new \DateTime('2024-03-01 12:00:00');

        $space = new Spaces();
        $space->setId('space-id');

        $user = new User();

        $existingEvent = new Events();
        $existingEvent->setStart($start);
        $existingEvent->setEnd($end);
        $existingEvent->setSpace($space);
        $existingEvent->setOrganizer($user);

        $command = new EventCreate(
            'Test Event',
            'space-id',
            $start,
            $end
        );

        $this->validateConstraints->method('validate')->willReturn([]);

        $this->spaces->method('findById')->willReturn($space);

        $this->security->method('getUser')->willReturn($user);

        $this->events->method('findByEventIdBetweenData')
            ->willReturn([$existingEvent]);

        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage(json_encode(['Existe una reserva que entra en conflicto por favor verifca las fechas y el espacio']));

        $this->handler->handle($command);
    }

}
