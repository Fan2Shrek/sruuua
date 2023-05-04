<?php

namespace App\EventDispatcher;

use App\EventDispatcher\Interfaces\EventDispatcherInterface;
use App\EventDispatcher\Interfaces\ListenerInterface;
use App\EventDispatcher\Interfaces\ListenerProviderInterface;

class EventDispatcher implements EventDispatcherInterface
{

    private ListenerProviderInterface $listenerProvider;

    private Container $container;

    public function __construct(ListenerProviderInterface $listenerProvider, Container $container)
    {
        $this->listenerProvider = $listenerProvider;
        $this->container = $container;

        $this->registerListeners();
    }

    public function registerListeners()
    {
        foreach ($this->container->getAllByType() as $listener){
            $this->addListener($listener);
        }
    }

    public function addListener(ListenerInterface $listener){
        $this->listenerProvider->addListener($listener->listen(), $listener);
    }

    public function dispatch(object $event)
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener($event);
        }
    }
}
