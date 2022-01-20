<?php

namespace CacheTask;

use Traversable;
use WithPattern\CacheItemInterface;
use WithPattern\CacheItemPoolInterface;
use WithPattern\Singleton;

class CacheItemPool extends Singleton implements CacheItemPoolInterface
{
    private array $deffer = [];

    public static function info(): array
    {
        return $_COOKIE;
    }

    public static function getClassName(): string
    {
        return self::class;
    }

    public function getItem(string $key): CacheItemInterface
    {
        $isTrue = false;
        $searchedItem = null;
        foreach ($_COOKIE as $objectKey => $value) {
            if ($objectKey === $key) {
                $isTrue = true;
                $searchedItem = $objectKey;
                $searchedItemValue = $value;
                break;
            }
        }
        if ($isTrue) {
            return new CacheItem($searchedItem, $searchedItemValue);
        } else {
            return new CacheItem($key, '');
        }
    }

    public function getItems(array $keys = array()): array|Traversable
    {
        $collection = [];
        foreach ($keys as $key) {
            foreach ($_COOKIE as $objectKey => $value) {
                if ($objectKey === $key) {
                    $searchedItem = $objectKey;
                    if ($value !== '') {
                        $searchedItemValue = serialize($value);
                    } else {
                        $searchedItemValue = $value;
                    }
                    $collection[] = new CacheItem($searchedItem, $searchedItemValue);
                    unset($key);
                    continue 2;
                }
            }
            array_push($collection, new CacheItem($key, ''));
        }
        return $collection;
    }

    public function hasItem(string $key): bool
    {
        foreach ($_COOKIE as $objectKey => $value) {

            if ($objectKey === $key && $objectKey) {
                unset($objectKey, $value);
                return true;
            } elseif ($objectKey === $key && $objectKey == false) {
                unset($objectKey, $value);
                echo "Cache Item with key $key exists in pool but have no value..";
                return true;
            }
        }
        return false;
    }

    public function clear(): bool
    {
        $_COOKIE = [];
        return true;
    }

    public function deleteItem(string $key): bool
    {
        foreach ($_COOKIE as $objectKey => $value) {
            if ($objectKey === $key) {
                unset($_COOKIE[$objectKey]);
                unset($objectKey, $value);
                return true;
            }
        }
        echo 'There is no such key..' . PHP_EOL;
        return false;
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            foreach ($_COOKIE as $objectKey => $value) {
                if ($objectKey === $key) {
                    unset($_COOKIE[$objectKey]);
                    unset($key);
                    break;
                }
            }
            echo 'There is no such key..' . PHP_EOL;
        }
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        if (!array_key_exists($item->getKey(), $_COOKIE)) {
            $_COOKIE[$item->getKey()] = $item->get();
            return true;
        } else {
            echo 'Item with the key ' . $item->getKey() . ' is already exists.' . PHP_EOL;
            return false;
        }
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deffer[] = new CacheItem($item->getKey(), $item->get());
        return true;
    }

    public function commit(): bool
    {
        foreach ($this->deffer as $object) {
            $_COOKIE[$object->getKey()] = $object->get();
        }
        return true;
    }
}