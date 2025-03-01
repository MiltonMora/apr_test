<?php

namespace App\Events\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;
readonly class EventEdit
{
    #[Assert\NotBlank]
    private string $eventId;

    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    private string $spaceId;

    #[Assert\NotBlank]
    private \DateTime $start;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(
        propertyPath: "start",
        message: "La fecha de finalización no puede ser anterior a la fecha de inicio."
    )]
    private \DateTime $end;

    public function __construct(string $eventId, string $name, string $spaceId, \DateTime $start, \DateTime $end)
    {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->spaceId = $spaceId;
        $this->start = $start;
        $this->end = $end;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getSpaceId(): string
    {
        return $this->spaceId;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }


}
