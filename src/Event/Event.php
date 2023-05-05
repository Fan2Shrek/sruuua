<?php

namespace App\Event;

class Event
{
    public function __construct(private string $msg)
    {
    }

    public function getMsg()
    {
        return $this->msg;
    }
}
