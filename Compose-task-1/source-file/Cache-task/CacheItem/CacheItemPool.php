<?php
require_once 'CacheItemPoolInterface.php';
require_once 'CacheItem.php';

class CacheItemPool implements CacheItemPoolInterface
{
    private array $itemPool = [];

    public function getItem(string $key): CacheItemInterface
    {
        $isTrue = false;
        $searchedItem = null;
        foreach ($this->itemPool as $object) {
            $objectKey = $object->getKey();
            if ($objectKey === $key) {
                $isTrue = true;
                $searchedItem = $object;
                unset($object);
                break;
            }
        }
        if ($isTrue) {
            return $searchedItem;
        } else {
            return new CacheItem($key);
        }
    }

    public function getItems(array $keys = array()): array|\Traversable
    {
        $collection = [];
        foreach ($keys as $key) {
            foreach ($this->itemPool as $object) {
                $objectKey = $object->getKey();
                if ($objectKey === $key) {
                    array_push($collection, $object);
                    unset($key);
                    continue 2;
                }
            }
            array_push($collection, new CacheItem($key));
        }
        unset($object);
        return $collection;
    }

    public function hasItem(string $key): bool
    {
        foreach ($this->itemPool as $object) {
            $objectKey = $object->getKey();
            $objectValue = $object->isHit();
            if ($objectKey === $key && $objectValue) {
                unset($object);
                return true;
            } elseif ($objectKey === $key && $objectValue === false) {
                unset($object);
                echo "Cache Item with key {$key} exists in pool but have no value..";
                return true;
            }
        }
        return false;
    }

    public function clear(): bool
    {
        if (empty($this->itemPool)) {
            return false;
        } else {
            $this->itemPool = [];
            return true;
        }
    }

    public function deleteItem(string $key): bool
    {
        // TODO: If there is no such key.
        foreach ($this->itemPool as $index => $object) {
            $objectKey = $object->getKey();
            if ($objectKey === $key) {
                unset($this->itemPool[$index]);
                unset($object, $index);
                return true;
            }
        }
        return false;
    }

    public function deleteItems(array $keys): bool
    {
        // TODO: If there is no such keys.
        foreach ($keys as $key) {
            foreach ($this->itemPool as $index => $object) {
                $objectKey = $object->getKey();
                if ($objectKey === $key) {
                    unset($this->itemPool[$index]);
                    unset($key);
                    break;
                }
            }
        }
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        // TODO: regex
        array_push($this->itemPool, $item);
        return true;
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        // TODO: Implement saveDeferred() method.
        return true;
    }

    public function commit(): bool
    {
        // TODO: Implement commit() method.
        return true;
    }
}