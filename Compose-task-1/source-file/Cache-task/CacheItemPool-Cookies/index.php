<?php
session_start();

/*
Основная сложность куки в том,
что они должны быть заданы до первой отправки заголовков.
В таком случае либо делать проверку не используя эхо,
либо не использовать функцию сэткуки.
Но в таком случае не получится реализовать expire at,
что могло бы очень помочь и сделать более красивым функционал деффер
(временные файлы удалялись бы после окончания сессии самостоятельно)
*/

function prettyPrint($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

require_once 'CacheItemPoolCookies.php';

$obj1 = new CacheItemPoolCookies();

# Clear: Проверяем работу и по необходимости очищаем сессию/пул от значений
var_dump($obj1->clear());
echo '<br>';

# Save: Сохраняем в кеш и проверяем пул, пробуем добавить тот же ключ и получаем false
var_dump($obj1->save('key', 1));
echo '<br>';
var_dump($obj1->save('key2', 3));
echo '<br>';
var_dump($obj1->save('key3', 3));
prettyPrint($_COOKIE);
var_dump($obj1->save('key', 2));
prettyPrint($_COOKIE);

# GetItem: Проверяем и получаем значение или ошибку/сообщение
prettyPrint($obj1->getItem('key'));
prettyPrint($obj1->getItem('key4'));

#GetItems: # GetItem: Проверяем и получаем значения или ошибку/сообщение
prettyPrint($obj1->getItems(['key', 'key3']));
prettyPrint($obj1->getItems(['key', 'key4']));

#HasItem: Проверяем и получаем true либо false
var_dump($obj1->hasItem('key'));
echo '<br>';
var_dump($obj1->hasItem('key4'));
echo '<br>';

#DeleteItem: Проверяем и получаем true/false и выводим пул
var_dump($obj1->deleteItem('key'));
echo '<br>';
prettyPrint($_COOKIE);
var_dump($obj1->deleteItem('key4'));
prettyPrint($_COOKIE);

#DeleteItems: Для проверки добавляем несколько новых ключей, затем удаляем их и получаем true/false
$obj1->save('key5', 1);
$obj1->save('key6', 1);
$obj1->save('key7', 1);
$obj1->save('key8', 1);
$obj1->save('key9', 1);
prettyPrint($_COOKIE);

var_dump($obj1->deleteItems(['key5', 'key7', 'key9']));
prettyPrint($_COOKIE);

# Пробуем заново удалить уже удаленные ключи
var_dump($obj1->deleteItems(['key5', 'key7', 'key9']));
prettyPrint($_COOKIE);

#SaveDeffer: Сохраняем ключ с префиксом, получаем true/false
var_dump($obj1->saveDeferred('key2', 2));
echo '<br>';
var_dump($obj1->saveDeferred('key2', 2));
echo '<br>';
var_dump($obj1->saveDeferred('key10', 2));
prettyPrint($_COOKIE);

#Commit: Проверяем, получаем true или false и сообщение;
var_dump($obj1->commit());
echo '<br>';
#Удаляем конфликтный деффер, делаем коммит, дефферы сохраняются как обычные ключи
var_dump($obj1->deleteItem('deffer-key2'));
echo '<br>';
var_dump($obj1->commit());
prettyPrint($_COOKIE);

# Некий функционал для очистки деффера при завершении сессии, скорей всего TODO
if(session_status()===0 || session_status()===1) {
    foreach ($_COOKIE as $key => $value) {
        if ($key = "/^deffer-[a-zA-Z]+/") {
            unset($_COOKIE[$key]);
        }
    }
}
