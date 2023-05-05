<?php

namespace App\Event;

use Sruuua\EventDispatcher\Interfaces\ListenerInterface;

class Listener implements ListenerInterface
{
    public function listen(): string
    {
        return Event::class;
    }

    public function __invoke(object $event)
    {
        dd($event->getMsg());
    }
}
