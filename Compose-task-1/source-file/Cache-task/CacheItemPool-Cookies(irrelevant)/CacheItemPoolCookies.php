<?php
namespace WithPattern;

use CacheTask\CacheItem;
use Traversable;

class CacheItemPoolCookies extends Singleton implements CacheItemPoolInterface
{

    public function getItem($key): CacheItemInterface
    {
        if (array_key_exists($key, $_COOKIE)) {
            return new CacheItem($key, $_COOKIE[$key]);#array_fill_keys([$key], $_COOKIE[$key]);
        } else {
            return  new CacheItem($key, '');#"There's no such key..";
        }

    }

    public function getItems(array $keys = array()): array|Traversable
    {
        /*foreach ($keys as $key) {
            if (!array_key_exists($key, $_COOKIE)) {
                return "The $key is not in pool";
            }
        }*/
        $array = [];
        foreach ($keys as $key) {
            $array += array_fill_keys([$key], $_COOKIE[$key]);
        }
        return $array;
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