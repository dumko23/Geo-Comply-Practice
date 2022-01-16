<?php
require_once 'CacheItem.php';
require_once 'CacheItemPool.php';

function prettyPrint($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

$cache = new CacheItemPool();

prettyPrint($cache);

$cache->save(new CacheItem('key'));

prettyPrint($cache);
prettyPrint($cache->getItem('key')->set('some value'));

$cache->save(new CacheItem('key2'));

prettyPrint($cache->getItem('key2')->set('some other value'));


prettyPrint($cache->getItems(['key', 'key3']));

prettyPrint($cache->hasItem('key'));

//$cache->clear();
//$cache->deleteItem('key2');
//$cache->deleteItems(['key','key3']);
//prettyPrint($cache);

prettyPrint($cache->getItem('key')->getKey());
