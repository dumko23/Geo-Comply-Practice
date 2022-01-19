<?php
session_start();

use CacheMYSQL\CacheItem;
use CacheMYSQL\CacheItemPool;
use CacheMYSQL\TransformToCSV;

require __DIR__ . '/../../../vendor/autoload.php';

function prettyPrint($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

$cache = CacheItemPool::getInstance();

$myDB = $cache->newDB('127.0.0.1', 'cacheDB');

$queryGet = 'select cacheKey, cacheValue from cacheDB.items;';
prettyPrint($myDB->query($queryGet)->fetchAll());
$cache->save(new CacheItem('newKey',1112));

prettyPrint($cache->getItem('newKey'));
