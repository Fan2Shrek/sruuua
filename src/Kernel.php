<?php

namespace App;

use Sruuua\DependencyInjection\ContainerBuilder;

class Kernel{

    public function handle(){
        $container = new ContainerBuilder();
        $container->build();

        
    }
}