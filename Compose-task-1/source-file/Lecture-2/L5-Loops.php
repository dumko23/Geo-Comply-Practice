<?php
#Task 1

$sum1 = 0;

for ($i = 1; $i <= 25; $i++) {
    $sum1 += $i;
}

$j = 1;
$sum2 = 0;

while ($j <= 25) {
    $sum2 += $j;
    $j++;
}

echo $sum1 . ', ' . $sum2 . '</br>';

#Task 2

$n = 81;
for ($i = 1; $i ** 2 < $n; $i++) {
    $sqr = $i ** 2;
    echo $sqr . ', ';
}

#Task 3

$btnArray = ['btn 10', 'btn 9', 'btn 8', 'btn 7', 'btn 6', 'btn 5', 'btn 4', 'btn 3', 'btn 2', 'btn 1',];

natsort($btnArray);
echo '<pre>';
print_r($btnArray);
echo '</pre>';

echo '<ul>';
foreach ($btnArray as $btn) {
    echo '<li><a href="#">' . $btn . '</a></li>';
}
echo '</ul>';

