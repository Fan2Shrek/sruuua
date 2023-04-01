<?php

namespace App;

use Sruuua\Cache\Cache;
use Sruuua\Cache\CachePool;
use Sruuua\Cache\CacheBuilder;
use Sruuua\DependencyInjection\Container;
use Sruuua\DependencyInjection\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;

class Kernel
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * @var string[]
     */
    private array $env;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load('../.env');

        $this->env = $_ENV;

        # Cache check
        if (!is_dir(CachePool::getDirectory())) {
            $this->container = (new ContainerBuilder($this))->getContainer();

            $cachePool = new CachePool();

            $cachePool->save(new Cache('container', $this->container));
        } else {
            $cachePool = CacheBuilder::buildFromFiles();
            $this->container = $cachePool->getItem('container')->get();
        }
        $this->container->set('App\Cache\CachePool', $cachePool);
    }

    public function handle()
    {
        $request = $_SERVER['REQUEST_URI'];
        $page = $this->container->get('router')->getRouter()->getRoute($request);

        $func = $page->getFunction()->getName();
        $page->getController()->$func();
    }

    /**
     * Return the env values
     * 
     * @return mixed[]
     */
    public function getEnv(): array
    {
        return $this->env;
    }
}
