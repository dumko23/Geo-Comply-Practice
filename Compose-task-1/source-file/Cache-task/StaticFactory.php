<?php

namespace WithPattern;

use CacheMYSQL\CacheItemPoolSQL;
use CacheSession\CacheItemPoolSession;
use CacheTask\CacheItemPool;
use InvalidArgumentException;

class StaticFactory
{

    /**
     * @param string $pool
     * @return CacheItemPoolInterface
     */
    public static function createPool(string $pool): CacheItemPoolInterface
    {
        $poolType = strtolower($pool);
        return match ($poolType) {
            'session' => CacheItemPoolSession::getInstance(),
            'items' => CacheItemPool::getInstance(),
            'mysql' => CacheItemPoolSQL::getInstance(),
            default => throw new InvalidArgumentException('There is no such pool type in stock. Try: sessions, cookies, items or mysql'),
        };
    }
}