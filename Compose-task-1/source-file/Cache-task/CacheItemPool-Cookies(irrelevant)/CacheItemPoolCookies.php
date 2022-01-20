<?php
namespace WithPattern;

use CacheTask\CacheItem;
use Traversable;

class CacheItemPoolCookies extends Singleton implements CacheItemPoolInterface
{

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

    public function getItems(array $keys = array()): array|\Traversable
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
        if (array_key_exists($key, $_COOKIE)) {
            return true;
        } else {
            return false;
        }
    }

    public function clear(): bool
    {
        if (empty($_COOKIE)) {
            return false;
        } else {
            foreach ($_COOKIE as $key => $value) {
                unset($_COOKIE[$key]);
            }
            return true;
        }
    }

    public function deleteItem(string $key): bool
    {
        if (array_key_exists($key, $_COOKIE)) {
            unset($_COOKIE[$key]);
            return true;
        } else {
            return false;
        }
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $_COOKIE)) {
                return false;
            }
        }
        foreach ($keys as $key) {
            unset($_COOKIE[$key]);
        }
        return true;
    }

    public function save($item): bool
    {
        if (!array_key_exists($item->getKey(), $_COOKIE)) {
            $_COOKIE[$item->getKey()] = $item->get();
            return true;
        } else {
            return false;
        }
    }

    public function saveDeferred($item): bool
    {
        if (array_key_exists('deffer-' . $item->getKey(), $_COOKIE)) {
            return false;
        } else {
            $_COOKIE['deffer-' . $item->getKey()] = $item->get();
            return true;
        }
    }

    public function commit(): bool
    {
        $array = [];
        foreach ($_COOKIE as $key => $value) {
            if (preg_match("/^deffer-[_+[a-zA-Z]+|[a-zA-Z]+]/", $key)) {
                $array[$key] = $value;
            }
        }
        if (empty($array)) {
            return true;
        }
        foreach ($array as $key => $value) {
            if (array_key_exists(str_replace('deffer-', '', $key), $_COOKIE)) {
                echo "'" . str_replace('deffer-', '', $key) . "' is already in pool..";
                return false;
            }
        }
        foreach ($array as $key => $value) {
            $_COOKIE[str_replace('deffer-', '', $key)] = $value;
            unset($_COOKIE[$key]);
        }

        return true;
    }

    public static function info(): array {
        return $_COOKIE;
    }

    public static function getClassName():string{
        return self::class;
    }
}