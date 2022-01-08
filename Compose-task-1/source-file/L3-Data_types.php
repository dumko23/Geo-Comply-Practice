<?php
#Task 1
$a = 152;
$b = '152';
$c = 'London';
$d = array(152);
$e = 15.2;
$f = false;
$g = true;

var_dump($a);
echo '</br>';
var_dump($b);
echo '</br>';
var_dump($c);
echo '</br>';
var_dump($d);
echo '</br>';
var_dump($e);
echo '</br>';
var_dump($f);
echo '</br>';
var_dump($g);
echo '</br>';

#Task 2

$studentsVisited = 5;
$studentsTotal = 10;

echo "{$studentsVisited} of {$studentsTotal} students has visited the lecture." . '</br>';
echo $studentsVisited . ' of ' . $studentsTotal . ' students has visited the lecture.' . '</br>';

#Task 3

$first = 'Good morning';
$second = 'ladies';
$third = 'and gentlemen';

echo $first . '</br>' . $second . '</br>' . $third . '</br>';
echo $first . ', ' . $second . ' ' . $third . '!';
echo '</br>';

#Task 4

$array1 = [1, 2, 3, 'four', 5];
$array2 = ['one', 'two', 'three', 4, 'five'];
$array1['element'] = 6;
unset($array2[0]);
echo '</br>';
print_r($array1[2]);
echo '</br>';
print_r($array2[2]);
echo '</br>';
echo $array1[2];
echo '</br>';
echo $array2[2];
echo '</br>';
echo '<pre>';
print_r($array1);
print_r($array2);
echo '</pre>';
echo 'First array: ' . count($array1) . '. Second array: ' . count($array2);
