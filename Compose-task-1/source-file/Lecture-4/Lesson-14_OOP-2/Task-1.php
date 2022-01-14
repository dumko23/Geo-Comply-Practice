<?php

require_once 'Figure.php';

require_once 'Rectangle.php';
require_once 'Triangle.php';
require_once 'Square.php';


$r1 = new Rectangle(2, 4);
$r2 = new Rectangle(4, 3);
$t1 = new Triangle(5, 3, 5);
$t2 = new Triangle(4, 4, 5);
$s1 = new Square(3);
$s2 = new Square(5);


echo $r1->getArea() . '<br>';
echo $r2->getArea() . '<br>';


echo $t1->getArea() . '<br>';
echo $t2->getArea() . '<br>';

echo $s1->getArea() . '<br>';
echo $s2->getArea() . '<br>';