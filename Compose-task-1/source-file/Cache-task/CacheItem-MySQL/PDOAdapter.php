<?php

namespace CacheMYSQL;

use PDO;

class PDOAdapter
{
    private static PDO $db;
    private static string $host = '127.0.0.1';
    private static string $dbName = 'cacheDB';

    public static function db(): PDO
    {
        if (!isset(self::$db)) {
            self::$db = new PDO('mysql:host=' . self::$host . ';dbname:' . self::$dbName,
                'root', 'password', [
                PDO::ATTR_DEFAULT_FETCH_MODE => 2
            ]);;
        }
        return self::$db;
    }

    public static function insertToDB($item)
    {
        static::$db->prepare('insert into cacheDB.items (cacheKey, cacheValue)
                                values (?, ?)')->execute([$item->getKey(), $item->get()]);
    }

    public static function getFromDB(): bool|array
    {
        $queryGet = 'select cacheKey, cacheValue from cacheDB.items;';
        return static::$db->query($queryGet)->fetchAll();
    }

    public static function deleteFromDB(): string
    {
        return "delete from cacheDB.items";
    }

}
