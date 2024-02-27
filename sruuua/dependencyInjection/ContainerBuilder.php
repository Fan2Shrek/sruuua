<?php

namespace Sruuua\DependencyInjection;

use Composer\Autoload\ClassLoader;
use Symfony\Component\Yaml\Yaml;

class ContainerBuilder
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * @var string[]
     */
    private array $excludes;

    private ?ClassLoader $classLoader = null;

    public function __construct($ctx, ?ClassLoader $classLoader = null)
    {
        $this->container = new Container();
        $this->container->set($ctx::class, $ctx);
        $this->classLoader = $classLoader;
        $this->initializeContainer();
    }

    /**
     * Initialiaze the container with dependency
     *
     */
    public function initializeContainer()
    {
        $this->buildWithYaml();
        $this->buildAppServices();
        if ($this->classLoader !== null) $this->loadVendors();
    }

    /**
     * Register all class in src folder except excluded files
     *
     */
    public function buildAppServices()
    {
        $this->registerFolder('../src');
    }

    /**
     * Register all class in the folder
     *
     * @var string $folder the folder to register
     *
     * @return void
     */
    public function registerFolder(string $path): void
    {
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $fileName) {
            $file = $path . '/' . $fileName;
            if (!$this->isExclude($file)) {
                if (!is_dir($file)) {
                    $this->register($file);
                } else {
                    $this->registerFolder($file);
                }
            }
        }
    }

    /**
     * Inject dependency needed in class
     *
     * @param string $class Class Namespace
     *
     * @return void
     */
    public function registerInContainer(string $class): void
    {
        $this->container->register($class, $class);
    }

    /**
     * Adapt and register a namespace from filename
     *
     * @var string $fileName the file to register
     */
    public function register(string $fileName)
    {
        $namespace = str_replace('.php', '', $fileName);
        $namespace = str_replace('../src', 'App', $namespace);
        $namespace = str_replace('/', '\\', $namespace);

        if (class_exists($namespace)) $this->registerInContainer($namespace);
    }

    /**
     * Parse and build yaml file
     *
     * @return Container
     */
    public function buildWithYaml()
    {
        $yaml = Yaml::parseFile('../config/services.yml');
        $this->excludes = $yaml['excludes'];

        if (isset($yaml['services'])) $this->buildInitialServices($yaml['services']);
    }

    /**
     * Build the container with all dependency
     *
     * @var array[] $yaml the yaml's services
     *
     * @return void
     */
    public function buildInitialServices(array $yaml): void
    {
        foreach ($yaml as $name => $build) {

            if (isset($build['arg'])) {
                $this->container->register($name, $build['class'], $build['arg']);
            } else {
                $this->container->register($name, $build['class']);
            }
        }
    }

    /**
     * Check if the file should be load or not
     *
     * @param string $fileName
     *
     * @return bool
     */
    public function isExclude(string $fileName): bool
    {
        if (in_array($fileName, $this->excludes)) {
            return true;
        }

        foreach ($this->excludes as $file) {
            if (str_starts_with($fileName, $file)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Load classes from vendors
     */
    public function loadVendors()
    {
        foreach ($this->classLoader->getPrefixesPsr4() as $vendorName => $value) {
            if (str_starts_with($vendorName, 'Sruuua\\')) {
                $this->registerVendorFolder($value[0], $vendorName);
            }
        }

        return;
    }

    public function registerVendorFolder(string $path, string $baseNamespace)
    {
        # exclude useless things
        if (str_contains($path, 'Exception') || str_contains($path, 'Interface') || str_contains($path, 'Rendering')) return;

        # exclude useless dependencies
        if (str_contains($path, 'application')) return;

        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $fileName) {
            $file = $path . '/' . $fileName;
            $namespace = $baseNamespace . pathinfo($file, PATHINFO_FILENAME);
            if (in_array($namespace, get_declared_classes())) continue;
            if (!is_dir($file)) {

                if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;
                $r = new \ReflectionClass($namespace);

                if (!$r->isAbstract() && empty($r->getAttributes())) {
                    $this->registerInContainer($namespace);
                }
            } else {
                $namespace .= '\\';
                $this->registerVendorFolder($file, $namespace);
            }
        }
    }

    /**
     * Get the container
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
