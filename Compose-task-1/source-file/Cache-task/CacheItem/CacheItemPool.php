<?php

namespace CacheTask;

use Traversable;
use WithPattern\CacheItemInterface;
use WithPattern\CacheItemPoolInterface;
use WithPattern\Singleton;

class CacheItemPool extends Singleton implements CacheItemPoolInterface
{
    private array $deffer = [];

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
        unset($objectKey, $value);
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
                    $searchedItemValue = $value;
                    array_push($collection, new CacheItem($searchedItem, $searchedItemValue));
                    unset($key);
                    continue 2;
                }
            }
            array_push($collection, new CacheItem($key, ''));
        }
        unset($objectKey, $value);
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
        // TODO: If there is no such key.
        foreach ($_COOKIE as $objectKey => $value) {
            if ($objectKey === $key) {
                unset($_COOKIE[$objectKey]);
                unset($objectKey, $value);
                return true;
            }
        }
        unset($objectKey, $value);
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
        }
        unset($objectKey, $value);
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        $_COOKIE[$item->getKey()] = $item->get();
        return true;

    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        array_push($this->deffer, new CacheItem($item->getKey(), $item->get()));
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