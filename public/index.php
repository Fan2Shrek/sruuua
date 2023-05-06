<?php

$classLoader = require '../vendor/autoload.php';

use App\Kernel;
use Sruuua\HTTPBasics\Request;

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function dc($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

$req = Request::getRequest();
$kernel = new Kernel($classLoader);
$kernel->handle($req);
