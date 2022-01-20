<?php
session_start();

use CacheMYSQL\CacheItemSQL;
use WithPattern\StaticFactory;

require __DIR__ . '/../../vendor/autoload.php';

function prettyPrint($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

$cacheMySQL = StaticFactory::createPool('mysql');

prettyPrint($cacheMySQL->getItem('newKey11111'));

prettyPrint($cacheMySQL->getItem('newKey11111')->set([1, 2, 3]));
prettyPrint($cacheMySQL->save(new CacheItemSQL('newKey1112323', [2,2,2,])));
prettyPrint($cacheMySQL->getItem('newKey1112323'));



$cacheItem = StaticFactory::createPool('items');

prettyPrint($cacheItem->getItem('newKey')->set(123));

prettyPrint($cacheItem->getItem('newKey'));

$cacheSession = StaticFactory::createPool('session');

prettyPrint($cacheSession->getItem('newKey')->set(321));

prettyPrint($cacheSession->getItem('newKey'));



