<?php

$a = intval($_POST['a']);
$b = intval($_POST['b']);
$c = intval($_POST['c']);
$d = intval($_POST['d']);
$e = intval($_POST['e']);
$f = intval($_POST['f']);
$g = intval($_POST['g']);

$array = array(
    $a,
    $b,
    $c,
    $d,
    $e,
    $f,
    $g,
);

echo '<pre>';
print_r($array);
echo '</pre>';

echo 'min = ' . min($array) . '<br>';
echo 'max = ' . max($array) . '<br>';
echo 'average = ' . array_sum($array) / count($array);
