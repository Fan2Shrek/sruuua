<?php

namespace App\Error;

class ErrorHandler
{
    public static function initialize()
    {
        $handler = new static();
        set_exception_handler([$handler, 'handleException']);
    }

    public function handleException(\Throwable $exception)
    {
        $this->render('views/exception.html.php', ['message' => $exception->getMessage()]);
    }

    public function render(string $fileName, array $args = [])
    {
        extract($args);

        $fileName = \is_file(\dirname(__DIR__) . '/Error/Rendering/' . $fileName) ? \dirname(__DIR__) . '/Error/Rendering/' . $fileName : $fileName;
        include $fileName;
    }
}
