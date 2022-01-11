<?php

$name = $_POST['name'];
$gender = $_POST['gender'];

if ($gender === 'male') {
    echo 'Hello, mister ' . $name;
} else {
    echo 'Hello, miss ' . $name;
}