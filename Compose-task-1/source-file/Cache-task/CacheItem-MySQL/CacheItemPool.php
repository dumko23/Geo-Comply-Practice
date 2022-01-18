<?php

namespace CacheMYSQL;

use PDO;

class CacheItemPool implements CacheItemPoolInterface
{
    private $db;
    private array $deffer = [];

    public function newDB(string $host, string $dbName): PDO
    {
        return $this->db = new PDO('mysql:host=' . $host . ';dbname:' . $dbName, 'root', 'password', [
            PDO::ATTR_DEFAULT_FETCH_MODE => 2
        ]);
    }

    private function insertToDB($item)
    {
        $this->db->prepare('insert into cacheDB.items (cacheKey, cacheValue)
                            values (?, ?)')->execute([$item->getKey(), $item->get()]);
    }

    private function getFromDB()
    {
        $queryGet = 'select cacheKey, cacheValue from cacheDB.items;';
        return $this->db->query($queryGet)->fetchAll();
    }

    private function deleteFromDB()
    {
        return "delete from cacheDB.items";
    }

    public function getItem(string $key): CacheItemInterface
    {
        $isTrue = false;
        $searchedItem = null;
        foreach ($this->getFromDB() as $arrayValue) {
            if ($arrayValue['cacheKey'] === $key) {
                $isTrue = true;
                $searchedItem = $arrayValue['cacheKey'];
                $searchedItemValue = $arrayValue['cacheValue'];
                break;
            }
        }
        unset($arrayValue);
        if ($isTrue) {
            return new CacheItem($searchedItem, $searchedItemValue);
        } else {
            $this->save(new CacheItem($key, ''));
            return new CacheItem($key, '');
        }
    }

    public function getItems(array $keys = array()): array|\Traversable
    {
        $collection = [];
        foreach ($keys as $key) {
            foreach ($this->getFromDB() as $arrayValue) {
                if ($arrayValue['cacheKey'] === $key) {
                    $searchedItem = $arrayValue['cacheKey'];
                    $searchedItemValue = $arrayValue['cacheValue'];
                    array_push($collection, new CacheItem($searchedItem, $searchedItemValue));
                    unset($key);
                    continue 2;
                }
            }
            array_push($collection, new CacheItem($key, ''));
        }
        unset($arrayValue);
        return $collection;
    }

    public function hasItem(string $key): bool
    {
        foreach ($this->getFromDB() as $arrayValue) {

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
    }

    public function clear(): bool
    {
        $this->db->query($this->deleteFromDB());
        return true;
    }

    public function deleteItem(string $key): bool
    {
        // TODO: If there is no such key.
        foreach ($this->getFromDB() as $arrayValue) {
            if ($arrayValue['cacheKey'] === $key) {
                $this->db->prepare($this->deleteFromDB() . " where cacheKey = ?;")->execute([$key]);
                unset($arrayValue);
                return true;
            }
        }
        unset($arrayValue);
        return false;
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            foreach ($this->getFromDB() as $arrayValue) {
                if ($arrayValue['cacheKey'] === $key) {
                    $this->db->prepare($this->deleteFromDB() . " where cacheKey = ?;")->execute([$key]);
                    break;
                }
            }
        }
        unset($arrayValue);
        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        foreach ($this->getFromDB() as $arrayValue) {
            if ($arrayValue['cacheKey'] === $item->getKey()) {
                return false;
            }
        }
        $this->insertToDB($item);
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