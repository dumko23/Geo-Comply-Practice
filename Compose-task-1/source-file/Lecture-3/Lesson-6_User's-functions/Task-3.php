<?php

function deleteNegatives(array $array): array
{
    for ($i = 0, $length = count($array); $i < $length; $i++) {
        if ($array[$i] < 0) {
            unset($array[$i]);
        }
    }

    return array_values($array);
}

echo '<pre>';
print_r(deleteNegatives([1, 2, -5, 3, -4, -1.1, -0.1, 2, 3, 5]));
echo '</pre>';