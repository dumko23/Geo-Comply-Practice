<?php

namespace CacheMYSQL;

use PDO;

class CacheItem implements CacheItemInterface
{
    private string $key;
    private mixed $value;


    public function __construct(string $key, mixed $value)
    {
        $this->key = $key;
        $this->value = serialize($value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get(): mixed
    {
        if ($this->isHit()) {
            return unserialize($this->value);
        } else {
            return false;
        }
    }

    public function isHit(): bool
    {
        if ($this->value) {
            return true;
        } else {
            return false;
        }
    }

    public function set(mixed $value): static
    {
        PDOAdapter::db()->prepare("update cacheDB.items set cacheValue = ? where cacheKey = ?")
            ->execute([serialize($value), $this->key]);
        $this->value = serialize($value);
        return $this;
    }
}