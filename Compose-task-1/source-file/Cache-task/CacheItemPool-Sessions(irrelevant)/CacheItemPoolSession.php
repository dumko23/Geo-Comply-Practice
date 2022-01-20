<?php
namespace CacheSession;

use Traversable;
use WithPattern\CacheItemInterface;
use WithPattern\CacheItemPoolInterface;
use WithPattern\Singleton;

class CacheItemPoolSession extends Singleton implements CacheItemPoolInterface
{

    /*public function getItem($key): CacheItemInterface
    {
        if (array_key_exists($key, $_SESSION)) {
            return new CacheItemSession($key, $_SESSION[$key]);
        } else {
            return new CacheItemSession($key, '');
        }
    }*/
    public function getItem(string $key): CacheItemInterface
    {
        $isTrue = false;
        $searchedItem = null;
        foreach ($_SESSION as $objectKey => $value) {
            if ($objectKey === $key) {
                $isTrue = true;
                $searchedItem = $objectKey;
                $searchedItemValue = $value;
                break;
            }
        }
        unset($objectKey, $value);
        if ($isTrue) {
            return new CacheItemSession($searchedItem, $searchedItemValue);
        } else {
            return new CacheItemSession($key, '');
        }
    }

    public function getItems(array $keys = array()): array|\Traversable
    {
        $collection = [];
        foreach ($keys as $key) {
            foreach ($_SESSION as $objectKey => $value) {
                if ($objectKey === $key) {
                    $searchedItem = $objectKey;
                    $searchedItemValue = $value;
                    array_push($collection, new CacheItemSession($searchedItem, $searchedItemValue));
                    unset($key);
                    continue 2;
                }
            }
            array_push($collection, new CacheItemSession($key, ''));
        }
        unset($objectKey, $value);
        return $collection;
    }

    public function hasItem(string $key): bool
    {
        if (array_key_exists($key, $_SESSION)) {
            return true;
        } else {
            return false;
        }
    }

    public function clear(): bool
    {
        if (empty($_SESSION)) {
            return false;
        } else {
            session_unset();
            return true;
        }
    }

    public function deleteItem(string $key): bool
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
            return true;
        } else {
            return false;
        }
    }

    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $_SESSION)) {
                return false;
            }
        }
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }
        return true;
    }

    public function save($item): bool
    {
        if (!array_key_exists($item->getKey(), $_SESSION)) {
            $_SESSION[$item->getKey()] = $item->get();
            return true;
        } else {
            return false;
        }
    }

    public function saveDeferred($item): bool
    {
        if (array_key_exists('deffer-' . $item->getKey(), $_SESSION)) {
            return false;
        } else {
            $_SESSION['deffer-' . $item->getKey()] = $item->get();
            return true;
        }
    }

    public function commit(): bool
    {
        $array = [];
        foreach ($_SESSION as $key => $value) {
            if (preg_match("/^deffer-[_+[a-zA-Z]+|[a-zA-Z]+]/", $key)) {
                $array[$key] = $value;
            }
        }
        if (empty($array)) {
            return true;
        }
        foreach ($array as $key => $value) {
            if (array_key_exists(str_replace('deffer-', '', $key), $_SESSION)) {
                echo "'" . str_replace('deffer-', '', $key) . "' is already in pool..";
                return false;
            }
        }
        foreach ($array as $key => $value) {
            $_SESSION[str_replace('deffer-', '', $key)] = $value;
            unset($_SESSION[$key]);
        }

        return true;
    }

    public static function info(): array {
        return $_SESSION;
    }

    public static function getClassName():string{
        return self::class;
    }
}