<?php

namespace App;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractGeneralController extends AbstractController
{
    protected CommandBus $commandBus;
    protected array $content;

    public function __construct(
        CommandBus $commandBus,
    ) {
        $this->commandBus = $commandBus;
        $this->content = [];
    }

    protected function getContentValue(string $key): string|array
    {
        if (empty($this->content)) {
            $this->content = json_decode(
                $this->container->get('request_stack')->getCurrentRequest()->getContent(),
                true
            );
        }

        return array_key_exists($key, $this->content) ? $this->content[$key] : '';
    }

    protected function getLocale(): string
    {
        return $this->container->get('request_stack')->getCurrentRequest()->getLocale();
    }
}
