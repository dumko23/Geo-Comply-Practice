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
        $this->value = $value;
    }

    public function newDB(string $host, string $dbName): PDO
    {
        return new PDO('mysql:host=' . $host . ';dbname:' . $dbName, 'root', 'password', [
            PDO::ATTR_DEFAULT_FETCH_MODE => 2
        ]);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function get(): mixed
    {
        if ($this->value) {
            return $this->value;
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
        $this->newDB('127.0.0.1', 'cacheDB')->prepare("update cacheDB.items set cacheValue = ? where cacheKey = ?")->execute([$value, $this->key]);
        $this->value = $value;
        return $this;
    }
}