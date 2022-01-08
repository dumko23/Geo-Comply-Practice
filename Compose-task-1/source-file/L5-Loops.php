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

$btnArray = ['brt 10', 'brt 9', 'brt 8', 'brt 7', 'brt 6', 'brt 5', 'brt 4', 'brt 3', 'brt 2', 'brt 1',];

natsort($btnArray);
echo '<pre>';
print_r($btnArray);
echo '</pre>';

echo '<ul>';
foreach ($btnArray as $btn) {
    echo '<li><a href="#">' . $btn . '</a></li>';
}
echo '</ul>';

