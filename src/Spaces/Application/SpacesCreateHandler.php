<?php

namespace App\Spaces\Application;


use App\Commons\Helpers\ValidateConstraints;
use App\Events\Domain\Model\Events;
use App\Spaces\Application\Command\SpacesCreate;
use App\Spaces\Domain\Model\Spaces;
use App\Spaces\Domain\Ports\SpacesInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class SpacesCreateHandler
{
    public function __construct(
        private SpacesInterface $spaces,
        private ValidateConstraints $validateConstraints
    ) {
    }

    public function handle(SpacesCreate $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $space = New Spaces();
        $space->setName($command->getName());
        $space->setState(true);
        $this->spaces->save($space);
    }
}
