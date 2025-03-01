<?php

namespace App\Events\Domain\Model;

use App\Spaces\Domain\Model\Spaces;
use App\User\Domain\Model\User;
use Symfony\Component\Uid\Uuid;

class Events
{
    private string $id;
    private string $name;
    private User $organizer;
    private bool $state;

    private Spaces $space;

    private \DateTime $start;
    private \DateTime $end;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOrganizer(): User
    {
        return $this->organizer;
    }

    public function setOrganizer(User $organizer): void
    {
        $this->organizer = $organizer;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(bool $state): void
    {
        $this->state = $state;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getSpace(): Spaces
    {
        return $this->space;
    }

    public function setSpace(Spaces $space): void
    {
        $this->space = $space;
    }

    public function getStart(): \DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end): void
    {
        $this->end = $end;
    }


    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

}
