<?php

namespace WithPattern;

use Exception;
use PDO;

class PDOAdapter
{
    private static PDO $db;
    private const HOST = 'mysql';
    private const DB_NAME = 'cacheDB';

    private function __construct()
    {
    }

    protected function __clone(): void
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function db(): PDO
    {
        if (!isset(self::$db)) {
            self::$db = new PDO('mysql:host=' . self::HOST . ';dbname:' . self::DB_NAME,
                'root', 'password', [
                    PDO::ATTR_DEFAULT_FETCH_MODE => 2
                ]);
        }
        return self::$db;
    }

    public static function insertToDB($item)
    {
        static::db()->prepare('insert into cacheDB.items (cacheKey, cacheValue)
                                values (?, ?)')->execute([$item->getKey(), serialize($item->get())]);
    }

    public static function getFromDB(): bool|array
    {
        $queryGet = 'select cacheKey, cacheValue from cacheDB.items;';
        return static::db()->query($queryGet)->fetchAll();
    }

    public static function deleteFromDB(): string
    {
        return "delete from cacheDB.items";
    }

}
