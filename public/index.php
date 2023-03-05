<?php

require '../vendor/autoload.php';

use App\Kernel;

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

$kernel = new Kernel();
$kernel->handle();
