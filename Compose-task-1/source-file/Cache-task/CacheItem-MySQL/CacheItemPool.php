<?php

namespace CacheMYSQL;

use InvalidArgumentException;
use Traversable;

class CacheItemPool extends Singleton implements CacheItemPoolInterface
{
    private array $deffer = [];



    public function getItem(string $key): CacheItemInterface
    {
        $isTrue = false;
        $searchedItem = null;
        if (preg_match("/^[a-zA-Z0-9_.]+$/", $key)) {
            foreach (PDOAdapter::getFromDB() as $arrayValue) {
                if ($arrayValue['cacheKey'] === $key) {
                    $isTrue = true;
                    $searchedItem = $arrayValue['cacheKey'];
                    $searchedItemValue = $arrayValue['cacheValue'];
                    break;
                }
            }
        } else {
            throw new InvalidArgumentException(
                "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
        }
        unset($arrayValue);
        if ($isTrue) {
            return new CacheItem($searchedItem, $searchedItemValue);
        } else {
            $this->save(new CacheItem($key, ''));
            return new CacheItem($key, '');
        }
    }

    public function getItems(array $keys = array()): array|Traversable
    {
        $collection = [];
        foreach ($keys as $key) {
            if (preg_match("/^[a-zA-Z0-9_.]+$/", $key)) {
                foreach (PDOAdapter::getFromDB() as $arrayValue) {
                    if ($arrayValue['cacheKey'] === $key) {
                        $searchedItem = $arrayValue['cacheKey'];
                        $searchedItemValue = $arrayValue['cacheValue'];
                        array_push($collection, new CacheItem($searchedItem, $searchedItemValue));
                        unset($key);
                        continue 2;
                    }
                }
            } else {
                throw new InvalidArgumentException(
                    "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
            }
            array_push($collection, new CacheItem($key, ''));
        }
        unset($arrayValue);
        return $collection;
    }

    public function hasItem(string $key): bool
    {
        if (preg_match("/^[a-zA-Z0-9_.]+$/", $key)) {
            foreach (PDOAdapter::getFromDB() as $arrayValue) {
                if ($arrayValue['cacheKey'] === $key && $arrayValue) {
                    unset($arrayValue);
                    return true;
                } elseif ($arrayValue['cacheKey'] === $key && $arrayValue == false) {
                    unset($arrayValue);
                    echo "Cache Item with key {$key} exists in pool but have no value..";
                    return true;
                }
            }
            return false;
        } else {
            throw new InvalidArgumentException(
                "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
        }
    }

    public function clear(): bool
    {
        PDOAdapter::db()->query(PDOAdapter::deleteFromDB());
        return true;
    }

    public function deleteItem(string $key): bool
    {
        if (preg_match("/^[a-zA-Z0-9_.]+$/", $key)) {
            foreach (PDOAdapter::getFromDB() as $arrayValue) {
                if ($arrayValue['cacheKey'] === $key) {
                    PDOAdapter::db()->prepare(PDOAdapter::deleteFromDB() . " where cacheKey = ?;")->execute([$key]);
                    unset($arrayValue);
                    return true;
                }
            }
            unset($arrayValue);
            echo 'There is no such key..';
            return false;
        } else {
            throw new InvalidArgumentException(
                "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
        }
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            if (preg_match("/^[a-zA-Z0-9_.]+$/", $key)) {
                foreach (PDOAdapter::getFromDB() as $arrayValue) {
                    if ($arrayValue['cacheKey'] === $key) {
                        PDOAdapter::db()->prepare(PDOAdapter::deleteFromDB() . " where cacheKey = ?;")->execute([$key]);
                        break;
                    }
                }
            } else {
                throw new InvalidArgumentException(
                    "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
            }
        }
        unset($arrayValue);
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        foreach (PDOAdapter::getFromDB() as $arrayValue) {
            if ($arrayValue['cacheKey'] === $item->getKey()) {
                return false;
            }
        }
        PDOAdapter::insertToDB($item);
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
            $this->save($object);
        }
        return true;
    }
}