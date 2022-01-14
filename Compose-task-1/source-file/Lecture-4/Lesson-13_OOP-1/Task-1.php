<?php

require_once 'Car.php';

$firstCar = new Car(12000, 'blue', 1);
$secondCar = new Car(10000, 'red', 2);
$thirdCar = new Car(13000, 'black', 3);
$fourthCar = new Car(12200, 'yellow', 5);


$firstCar->price = 10000;
$secondCar->price = 11000;

echo '<pre>';
print_r($firstCar);
echo '</pre><br>';

echo 'Fuel consumption: ' . $fourthCar->fuelConsumption(34) . '<br>';
echo 'First const:' . $firstCar::ONE . '<br>';
echo 'Second const:' . $firstCar::TWO . '<br>';
echo 'Third const:' . $firstCar::THREE . '<br>';
echo 'Max-value const: ' . Car::getMaxConstant();