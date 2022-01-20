<?php

namespace CacheMYSQL;

use InvalidArgumentException;
use Traversable;
use WithPattern\CacheItemInterface;
use WithPattern\CacheItemPoolInterface;
use WithPattern\PDOAdapter;
use WithPattern\Singleton;

class CacheItemPoolSQL extends Singleton implements CacheItemPoolInterface
{
    private array $deffer = [];

    public static function info(): array
    {
        return PDOAdapter::getFromDB();
    }

    public static function getClassName(): string
    {
        return self::class;
    }

    public function getItem(string $key): CacheItemInterface
    {
        $isTrue = false;
        $searchedItem = null;
        if (preg_match("/^[a-zA-Z0-9_.]+$/", $key)) {
            foreach (PDOAdapter::getFromDB() as $arrayValue) {
                if ($arrayValue['cacheKey'] === $key) {
                    $isTrue = true;
                    $searchedItem = $arrayValue['cacheKey'];
                    if ($arrayValue['cacheValue'] !== '') {
                        $searchedItemValue = serialize($arrayValue['cacheValue']);
                        break;
                    } else {
                        $searchedItemValue = $arrayValue['cacheValue'];
                    }
                }
            }
        } else {
            throw new InvalidArgumentException(
                "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
        }
        if ($isTrue) {
            return new CacheItemSQL($searchedItem, $searchedItemValue);
        } else {
            $this->save(new CacheItemSQL($key, ''));
            return new CacheItemSQL($key, '');
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
                        if ($arrayValue['cacheValue'] !== '') {
                            $searchedItemValue = serialize($arrayValue['cacheValue']);
                            break;
                        } else {
                            $searchedItemValue = $arrayValue['cacheValue'];
                        }
                        $collection[] = new CacheItemSQL($searchedItem, $searchedItemValue);
                        unset($key);
                        continue 2;
                    }
                }
            } else {
                throw new InvalidArgumentException(
                    "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
            }
            array_push($collection, new CacheItemSQL($key, ''));
        }
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
                    echo "Cache Item with key $key exists in pool but have no value..";
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
            echo 'There is no such key..' . PHP_EOL;
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
                echo 'There is no key ' . $key . ' in the pool.' . PHP_EOL;
            } else {
                throw new InvalidArgumentException(
                    "Parameter key should only consist of 'A-Z', 'a-z', '0-9', '_', and '.'. Input was: " . $key);
            }
        }
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        foreach (PDOAdapter::getFromDB() as $arrayValue) {
            if ($arrayValue['cacheKey'] === $item->getKey()) {
                echo 'Item with the key ' . $item->getKey() . ' is already exists.' . PHP_EOL;
                return false;
            }
        }
        PDOAdapter::insertToDB($item);
        return true;
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deffer[] = new CacheItemSQL($item->getKey(), $item->get());
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