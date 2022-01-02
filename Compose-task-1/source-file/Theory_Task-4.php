<?php

$a = 1;
$b = 2;

echo $a . ', ' . $b;
echo '</br>';

$c = $a;
$d = &$b;

echo $c . ', ' . $d;
echo '</br>';

$a = 3;
$b = 4;

echo $a . ', ' . $b . ', ' . $c . ', ' . $d;
