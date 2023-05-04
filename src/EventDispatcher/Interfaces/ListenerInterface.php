<?php

namespace App\EventDispatcher\Interfaces;

interface ListenerInterface
{
    public function __invoke(object $event);

    public function listen(): string;
}