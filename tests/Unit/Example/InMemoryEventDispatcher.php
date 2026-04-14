<?php

namespace EasyHTTP\Contracts\Tests\Unit\Example;

use Psr\EventDispatcher\EventDispatcherInterface;

class InMemoryEventDispatcher implements EventDispatcherInterface
{
    protected array $events = [];

    public function dispatch(object $event): object
    {
        $this->events[] = $event;

        return $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }
}
