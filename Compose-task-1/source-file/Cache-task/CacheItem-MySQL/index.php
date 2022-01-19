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
$cache->save(new CacheItem('newKey',1112));

prettyPrint($cache->getItem('newKey'));


