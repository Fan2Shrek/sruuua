<?php

namespace App;

use Sruuua\Cache\Cache;
use Sruuua\Cache\CachePool;
use Sruuua\Cache\CacheBuilder;
use Sruuua\DependencyInjection\Container;
use Sruuua\DependencyInjection\ContainerBuilder;
use Sruuua\HTTPBasics\Request;
use Sruuua\HTTPBasics\Response\Response;
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
        $cachePool = CacheBuilder::buildFromFiles();

        if ($cachePool->hasItem('container')) {
            $this->container = $cachePool->getItem('container')->get();
        } else {
            $this->container = (new ContainerBuilder($this))->getContainer();
            $cachePool->save(new Cache('container', $this->container));
        }
        $this->container->set('cachePool', $cachePool);
    }

    public function handle(Request $request)
    {
        $this->container->set('request', $request);
        $page = $this->container->get('router')->getRouter()->getRoute($request->getRequestedPage());

        if (null !== $page) {
            $func = $page->getFunction()->getName();
            $page->getController()->$func(...array_map(
                fn ($opt) => $this->container->get($opt->getName()),
                $page->getOptions()
            ));
        } else {
            $resp = new Response(404, 'Page was not found :(');
            $resp->response();
        }
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
