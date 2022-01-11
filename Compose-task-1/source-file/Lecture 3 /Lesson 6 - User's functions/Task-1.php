<?php

$products = array(
    array('name' => 'Телевизор', 'price' => '400', 'quantity' => 1),
    array('name' => 'Телефон', 'price' => '300', 'quantity' => 3),
    array('name' => 'Кроссовки', 'price' => '150', 'quantity' => 2),
);

function total(array $array): array
{
    $totalArray = [
        'totalPrice' => 0,
        'totalQuantity' => 0,
    ];
    for ($i = 0, $length = count($array); $i < $length; $i++) {
        $totalArray['totalPrice'] += (int)$array[$i]['price'];
        $totalArray['totalQuantity'] += (int)$array[$i]['quantity'];
    }
    return $totalArray;
}

echo '<pre>';
print_r(total($products));
echo '</pre>';