<?php

namespace App\EventDispatcher;

use App\EventDispatcher\Interfaces\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{

    private array $listeners;

    public function __construct()
    {
        $this->listeners = array();
    }

    public function addListener(string $eventType, Listener $listener)
    {
        $this->listeners[$eventType][] = $listener;
    }

    public function getListenersForEvent(object $event): iterable
    {
        return $this->listeners[$event::class];
    }
}
