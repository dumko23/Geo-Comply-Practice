<?php

require_once 'Figure.php';

require_once 'Rectangle.php';
require_once 'Triangle.php';


$r1 = new Rectangle(2,4);
$t1 = new Triangle(5,3,5);

echo $r1->infoAbout();
echo $r1->getArea();

echo $t1->infoAbout();
echo $t1->getArea();