<?php

namespace Sruuua\Logger;

class Logger extends BaseLogger
{
    private static string $folder = '../logs/';

    private static string $fileName = 'logs.log';

    private ?string $filePath = null;

    private $file = null;

    private function getFile()
    {
        if (!isset($this->file)) {
            $this->file = fopen($this->filePath, 'a+');
        }

        return $this->file;
    }

    public function __construct()
    {
        if (!is_dir($this::$folder)) mkdir($this::$folder);
        if (!is_file($this->getFilePath())) touch($this->getFilePath());
    }

    /**
     * Interpolates context values into the message placeholders.
     * 
     * @see https://www.php-fig.org/psr/psr-3/ 1.2
     */
    public function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }


    public function getFilePath(): string
    {
        if (!isset($this->filePath)) {
            $this->filePath = $this::$folder . $this::$fileName;
        }

        return $this->filePath;
    }

    public function log($level, $message, array $context = array())
    {
        $file = $this->getFile();

        $content = "\n|{$level}| " . $this->interpolate($message, $context);
        fwrite($file, $content);
    }
}
