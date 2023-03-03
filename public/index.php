<?php

require 'vendor/autoload.php';

use Sruuua\DependencyInjection\Injector;

function dd($var)
{
    var_dump($var);
    die();
}

$injector = new Injector();

echo $injector->instance('App\Controller\MainController');
