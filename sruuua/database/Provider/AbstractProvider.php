<?php

namespace Sruuua\Database\Provider;

use Sruuua\Database\Hydrator\Hydrator;
use Sruuua\Database\Provider\Interface\CachableProviderInterface;
use Sruuua\Cache\Interface\CachePoolInterface;

abstract class AbstractProvider implements CachableProviderInterface
{
    private CachePoolInterface $cachePool;

    protected string $tableName;

    protected string $class;

    protected Hydrator $hydrator;

    protected $connection;

    public function __construct(string $class, CachePoolInterface $cachePool, $connection, Hydrator $hydrator)
    {
        $this->cachePool = $cachePool;
        $this->class = $class;
        $this->connection = $connection;
        $this->hydrator = $hydrator;
        $this->tableName = strtolower((new \ReflectionClass($this->class))->getShortName());
    }

    public function getAll()
    {
        $cache = $this->cachePool->getItem($this->getCacheName(null));
        if (null !== $content = $cache->get()) return $content;

        $req = $this->connection->prepare("SELECT * from {$this->tableName}");
        $data = $req->execute();

        if (empty($data)) return [];

        $data = $this->hydrator->hydrateResult($data, $this->class);
        $cache->set($data);
        $this->cachePool->save($cache);

        return $data;
    }

    public function getOne($id)
    {
        $cache = $this->cachePool->getItem($this->getCacheName($id));
        if (null !== $content = $cache->get()) return $content;

        $req = $this->connection->prepare("SELECT * from {$this->tableName} WHERE id=?");
        $data = $req->execute(array($id));

        if (empty($data)) return [];

        $data = $this->hydrator->hydrateResult($data, $this->class);
        $cache->set($data);
        $this->cachePool->save($cache);

        return $data;
    }

    public function checkCache(string $name)
    {
    }

    /**
     * Generated the cache name
     * 
     * @param ?int $id = null, the id of asked ressource
     * 
     * @return string
     */
    public function getCacheName(?int $id = null)
    {
        $name = strtolower((new \ReflectionClass($this->class))->getShortName()) . 's';
        if (null !== $id) {
            $name .= '|' . $id;
        }

        return $name;
    }

    /**
     * Delete the cache from the pool
     * 
     * @param string $key the key to remove
     * 
     * @return bool
     */
    public function removeCache(string $key)
    {
        return $this->cachePool->deleteItem($key);
    }

    public function handleCache(?int $id = null)
    {
        if (null !== $id) {
            $this->removeCache($this->getCacheName(null));
        }
        $this->removeCache($this->getCacheName($id));
    }
}
