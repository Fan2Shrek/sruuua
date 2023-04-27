<?php

namespace App\Repository;

use Sruuua\Database\Connection;
use Sruuua\Database\Hydrator\Hydrator;
use Sruuua\Database\Provider\AbstractProvider;
use App\Entity\User;
use Sruuua\Cache\CachePool;
use Sruuua\Cache\Repository\AbstractCachableRepository;

class UserRepository extends AbstractProvider
{
    public function __construct(Connection $connection, CachePool $cachePool, Hydrator $hydrator)
    {
        parent::__construct(User::class, $cachePool, $connection, $hydrator);
    }
}
