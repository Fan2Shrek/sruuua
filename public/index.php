<?php

require '../vendor/autoload.php';

use App\Kernel;
use Sruuua\HTTPBasics\Request;
use App\Error\ErrorHandler;

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

ErrorHandler::initialize();

$req = Request::getRequest();
$kernel = new Kernel();
$kernel->handle($req);
