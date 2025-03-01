<?php

namespace App\Events\Application\Command;

use Symfony\Component\Validator\Constraints as Assert;
readonly class EventCancel
{
    #[Assert\NotBlank]
    private string $eventId;

    public function __construct(string $eventId)
    {
        $this->eventId = $eventId;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

}
