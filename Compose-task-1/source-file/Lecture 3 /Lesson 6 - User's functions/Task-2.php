<?php

function sqrExpress($a, $b, $c): string
{
    $D = $b ** 2 - 4 * $a * $c;

    if ($D > 0) {
        $x1 = (-$b - sqrt($D)) / (2 * $a);
        $x2 = (-$b + sqrt($D)) / (2 * $a);
        return 'X1 = ' . $x1 . ', X2 = ' . $x2;
    } elseif ($D = 0) {
        $x = -$b / 2 * $a;
        return 'X = ' . $x;
    } else {
        return 'Eq. got no roots.';
    }
}

echo sqrExpress(a: 5, b: 12, c: 7);