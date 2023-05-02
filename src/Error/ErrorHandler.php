<?php

namespace App\Error;

class ErrorHandler
{
    public static function initialize()
    {
        $handler = new static();
        ini_set('display_errors', 1);
        set_exception_handler([$handler, 'handleException']);
        set_error_handler([$handler, 'handleError'], E_ALL);
    }

    public function handleException(\Throwable $exception)
    {
        $this->render('views/exception.html.php', ['message' => $exception->getMessage(), 'trace' => $exception->getTrace()]);
    }

    public function handleError(int $errno, string $errstr, string $errfile = null, int $errline = null)
    {
        $this->render('views/error.html.php', ['message' => $errstr]);
    }

    public function render(string $fileName, array $args = [])
    {
        extract($args);

        $fileName = \is_file(\dirname(__DIR__) . '/Error/Rendering/' . $fileName) ? \dirname(__DIR__) . '/Error/Rendering/' . $fileName : $fileName;
        include $fileName;
    }
}
