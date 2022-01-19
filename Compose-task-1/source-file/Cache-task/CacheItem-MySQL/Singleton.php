<?php

namespace CacheMYSQL;

use Exception;

class Singleton
{
    private static $instance;

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

    public static function getInstance(): static
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

}