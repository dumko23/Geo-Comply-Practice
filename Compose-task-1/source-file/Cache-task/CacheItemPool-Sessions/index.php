<?php
session_start();

function prettyPrint($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

require_once 'CacheItemPoolSession.php';

$obj = new CacheItemPoolSession();

# Clear: Проверяем работу и по необходимости очищаем сессию/пул от значений
var_dump($obj->clear());
echo '<br>';

# Save: Сохраняем в кеш и проверяем пул, пробуем добавить тот же ключ и получаем false
var_dump($obj->save('key', 1));
echo '<br>';
var_dump($obj->save('key2', 3));
echo '<br>';
var_dump($obj->save('key3', 3));
prettyPrint($_SESSION);
var_dump($obj->save('key', 2));
prettyPrint($_SESSION);

# GetItem: Проверяем и получаем значение или ошибку/сообщение
prettyPrint($obj->getItem('key'));
prettyPrint($obj->getItem('key4'));

#GetItems: # GetItem: Проверяем и получаем значения или ошибку/сообщение
prettyPrint($obj->getItems(['key', 'key3']));
prettyPrint($obj->getItems(['key', 'key4']));

#HasItem: Проверяем и получаем true либо false
var_dump($obj->hasItem('key'));
echo '<br>';
var_dump($obj->hasItem('key4'));
echo '<br>';

#DeleteItem: Проверяем и получаем true/false и выводим пул
var_dump($obj->deleteItem('key'));
echo '<br>';
prettyPrint($_SESSION);
var_dump($obj->deleteItem('key4'));
prettyPrint($_SESSION);

#DeleteItems: Для проверки добавляем несколько новых ключей, затем удаляем их и получаем true/false
$obj->save('key5', 1);
$obj->save('key6', 1);
$obj->save('key7', 1);
$obj->save('key8', 1);
$obj->save('key9', 1);
prettyPrint($_SESSION);

var_dump($obj->deleteItems(['key5', 'key7', 'key9']));
prettyPrint($_SESSION);

# Пробуем заново удалить уже удаленные ключи
var_dump($obj->deleteItems(['key5', 'key7', 'key9']));
prettyPrint($_SESSION);

#SaveDeffer: Сохраняем ключ с префиксом, получаем true/false
var_dump($obj->saveDeferred('key2', 2));
echo '<br>';
var_dump($obj->saveDeferred('key2', 2));
echo '<br>';
var_dump($obj->saveDeferred('key10', 2));
prettyPrint($_SESSION);

#Commit: Проверяем, получаем true или false и сообщение;
var_dump($obj->commit());
echo '<br>';
#Удаляем конфликтный деффер, делаем коммит, дефферы сохраняются как обычные ключи
var_dump($obj->deleteItem('deffer-key2'));
echo '<br>';
var_dump($obj->commit());
prettyPrint($_SESSION);

# Некий функционал для очистки деффера при завершении сессии, скорей всего TODO
if(session_status()===0 || session_status()===1) {
    foreach ($_SESSION as $key => $value) {
        if ($key = "/^deffer-[a-zA-Z]+/") {
            unset($_SESSION[$key]);
        }
    }
}
