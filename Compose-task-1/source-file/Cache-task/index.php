<?php
session_start();

use CacheMYSQL\CacheItemSQL;
use WithPattern\ChooseStrategy;

require __DIR__ . '/../../vendor/autoload.php';

$myStrategy = new ChooseStrategy('mysql');

/*$myStrategy->printGetItem('newKey')
    ->printHasItem('newKey')
    ->printGetItems(['key4', 'key3', 'key2'])
    ->printSave(new CacheItemSQL('AnotherKey', 'value'))
    ->printDeleteItem('newKey1112323')
    ->printDeleteItems(['newKey11111', 'newKey']);

$myStrategy->setStrategy('session')
    ->printGetItem('newKey')
    ->printHasItem('newKey')
    ->printGetItems(['key4', 'key3', 'key2'])
    ->printSave(new CacheItemSQL('AnotherKey', 'value'))
    ->printDeleteItem('newKey1112323')
    ->printDeleteItems(['newKey11111', 'newKey']);*/

$myStrategy->setStrategy('items')
    ->printGetItem('newKey')
    ->printHasItem('newKey')
    ->printGetItems(['key4', 'key3', 'key2'])
    ->printSave(new CacheItemSQL('AnotherKey', 'value'))
    ->printDeleteItem('newKey1112323')
    ->printDeleteItems(['newKey11111', 'newKey']);


