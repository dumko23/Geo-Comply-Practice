<?php
session_start();

use CacheMYSQL\CacheItem;
use CacheMYSQL\CacheItemPool;
use CacheMYSQL\TransformToCSV;

require __DIR__ . '/../../../vendor/autoload.php';

function prettyPrint($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

$cache = new CacheItemPool();

//prettyPrint($cache);
//

$myDB = $cache->newDB('127.0.0.1', 'cacheDB');


//$cache->save(new CacheItem('key5', 2));

$queryGet = 'select cacheKey, cacheValue from cacheDB.items;';

prettyPrint($cache->getItem('key1111')->set('some other value'));

var_dump($cache->deleteItem('key1111'));
prettyPrint($myDB->query($queryGet)->fetchAll());
$cache->getItem('key1111')->set('some other value');
$cache->getItem('key1121')->set('some other value');
$cache->getItem('key1131')->set('some other value');
$cache->getItem('key1141')->set('some other value');
$cache->getItem('key1151')->set('some other value');

prettyPrint($myDB->query($queryGet)->fetchAll());

var_dump($cache->deleteItems(['key1111', 'key1141']));

prettyPrint($myDB->query($queryGet)->fetchAll());

$cache->saveDeferred(new CacheItem('k123', 11));
$cache->commit();
prettyPrint($myDB->query($queryGet)->fetchAll());

