<?php

$a = 1;
$b = 2;

echo $a . ', ' . $b . '</br>';

$c = $a;
$d = &$b;

echo $c . ', ' . $d . '</br>';

$a = 3;
$b = 4;

echo $a . ', ' . $b . ', ' . $c . ', ' . $d;
