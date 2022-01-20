<?php
session_start();

use CacheMYSQL\CacheItem;
use CacheMYSQL\CacheItemPool;
use CacheMYSQL\PDOAdapter;

require __DIR__ . '/../../../vendor/autoload.php';

function prettyPrint($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

$cache = CacheItemPool::getInstance();

$myDB = PDOAdapter::db();

$queryGet = 'select cacheKey, cacheValue from cacheDB.items;';
prettyPrint($myDB->query($queryGet)->fetchAll());

$cache->save(new CacheItem('someKey', [1,2,3]));

prettyPrint($cache->getItem('someKey'));

prettyPrint($cache->getItems(['key4', 'key3']));

prettyPrint($cache->getItem('k123')->get());
