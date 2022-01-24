<?php
session_start();

use CacheMYSQL\CacheItemSQL;
use WithPattern\ChooseStrategy;
use WithPattern\TransformToCSV;

require __DIR__ . '/../../vendor/autoload.php';

$csvDir = __DIR__ . '/Source.csv';
$transferToCSV = new TransformToCSV();
$transferToCSV->openCSV($csvDir);

$myStrategy = new ChooseStrategy('mysql');

$myStrategy->GetItem('newKey');
$myStrategy->GetItems(['key4', 'key3', 'key2']);
$myStrategy->HasItem('newKey')
    ->Save(new CacheItemSQL('AnotherKey', 'value'))
    ->DeleteItem('newKey1112323')
    ->DeleteItems(['newKey11111', 'newKey'])
    ->GetPoolInfo();

/*$myStrategy->setStrategy('session')
    ->GetItem('newKey');
    $myStrategy->GetItems(['key4', 'key3', 'key2']);
$myStrategy->HasItem('newKey')
    ->Save(new CacheItemSQL('AnotherKey', 'value'))
    ->DeleteItem('newKey1112323')
    ->DeleteItems(['newKey11111', 'newKey'])
    ->GetPoolInfo();
*/

/*$myStrategy->setStrategy('items')
    ->GetItem('newKey');
    $myStrategy->GetItems(['key4', 'key3', 'key2']);
$myStrategy->HasItem('newKey')
    ->Save(new CacheItemSQL('AnotherKey', 'value'))
    ->DeleteItem('newKey1112323')
    ->DeleteItems(['newKey11111', 'newKey'])
    ->GetPoolInfo();*/


