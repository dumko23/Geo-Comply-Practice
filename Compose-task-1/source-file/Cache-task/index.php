<?php
session_start();

use WithPattern\StaticFactory;

require __DIR__ . '/../../vendor/autoload.php';

function prettyPrint($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

$cacheMySQL = StaticFactory::createPool('mysql');

prettyPrint($cacheMySQL->getItem('newKey11111'));

$cacheItem = StaticFactory::createPool('items');

prettyPrint($cacheItem->getItem('newKey')->set(123));

prettyPrint($cacheItem->getItem('newKey'));

$cacheSession = StaticFactory::createPool('session');

prettyPrint($cacheSession->getItem('newKey')->set(321));

prettyPrint($cacheSession->getItem('newKey'));



