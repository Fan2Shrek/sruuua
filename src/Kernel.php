<?php

namespace App;

use Sruuua\DependencyInjection\ContainerBuilder;

class Kernel
{

    public function handle()
    {
        $container = (new ContainerBuilder())->buildInitialServices();

        $request = $_SERVER['REQUEST_URI'];
        $page = $container->get('router')->getRouter()->getRoute($request);

        $func = $page->getFunction()->getName();
        $page->getController()->$func();
    }
}
