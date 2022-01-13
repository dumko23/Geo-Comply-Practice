<?php

require_once 'Car.php';

$firstCar = new Car(12000, 'blue', 1);
$secondCar = new Car(10000, 'red', 2);
$thirdCar = new Car(13000, 'black',3);
$fourthCar = new Car(12200, 'yellow',5);


$firstCar->price = 10000;
$thirdCar->price = 11000;

$fourthCar->fuelConsumption(22);
var_dump($fourthCar->fuelConsumption);
var_dump($firstCar::ONE);