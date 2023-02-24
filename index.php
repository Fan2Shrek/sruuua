<?php

require 'vendor/autoload.php';

use App\Kernel;

function dd($var){
    var_dump($var);
    die();
}

$kernel = new Kernel();
$kernel->handle();
