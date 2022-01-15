<?php

require_once 'CacheItemPoolInterfaceSession.php';

class CacheItemPoolSession implements CacheItemPoolInterfaceSession
{

    public function getItem($key): array|string
    {
        if (array_key_exists($key, $_SESSION)) {
            return array_fill_keys([$key], $_SESSION[$key]);
        } else {
            return "There's no such key..";
        }

    }

    public function getItems(array $keys = array()): array|string
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $_SESSION)) {
                return "The $key is not in pool";
            }
        }
        $array = [];
        foreach ($keys as $key) {
            $array += array_fill_keys([$key], $_SESSION[$key]);
        }
        return $array;
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

    public function save($key, $value): bool
    {
        if (!array_key_exists($key, $_SESSION)) {
            $_SESSION[$key] = $value;
            return true;
        } else {
            return false;
        }
    }

    public function saveDeferred($key, $value): bool
    {
        if (array_key_exists('deffer-' . $key, $_SESSION)) {
            return false;
        } else {
            $_SESSION['deffer-' . $key] = $value;
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
}