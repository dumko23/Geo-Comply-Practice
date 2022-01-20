<?php
session_start();

use CacheMYSQL\CacheItemSQL;
use WithPattern\ChooseStrategy;

require __DIR__ . '/../../vendor/autoload.php';

$myStrategy = new ChooseStrategy('mysql');

$myStrategy->printGetItem('newKey');
$myStrategy->printGetItems(['key4', 'key3', 'key2']);
$myStrategy->printHasItem('newKey')
    ->printSave(new CacheItemSQL('AnotherKey', 'value'))
    ->printDeleteItem('newKey1112323')
    ->printDeleteItems(['newKey11111', 'newKey'])
    ->printGetPoolInfo();

/*$myStrategy->setStrategy('session')
    ->printGetItem('newKey');
    $myStrategy->printGetItems(['key4', 'key3', 'key2']);
$myStrategy->printHasItem('newKey')
    ->printSave(new CacheItemSQL('AnotherKey', 'value'))
    ->printDeleteItem('newKey1112323')
    ->printDeleteItems(['newKey11111', 'newKey'])
    ->printGetPoolInfo();
*/

/*$myStrategy->setStrategy('items')
    ->printGetItem('newKey');
    $myStrategy->printGetItems(['key4', 'key3', 'key2']);
$myStrategy->printHasItem('newKey')
    ->printSave(new CacheItemSQL('AnotherKey', 'value'))
    ->printDeleteItem('newKey1112323')
    ->printDeleteItems(['newKey11111', 'newKey'])
    ->printGetPoolInfo();*/


