<?php
session_start();

require_once 'CacheItemPool.php';

$obj = new CacheItemPool();

# Проверяем работу и по необходимости очищаем сессию/пул от значений
var_dump($obj->clear());
echo '<br>';

#


