<?php
#Task 1

const MIN = 10;
const MAX = 50;

# 1. Function version.
function rangeCheck($x): string
{
    if ($x > MIN && $x < MAX) {
        return '+';
    } elseif ($x === MIN || $x === MAX) {
        return '+-';
    } else {
        return '-';
    }
}

echo rangeCheck(10);
echo '</br>';

# 2. Simple conditioning

$y = 11;

if ($y > MIN && $y < MAX) {
    echo '+';
} elseif ($y === MIN || $y === MAX) {
    echo '+-';
} else {
    echo '-';
}
echo '</br>';

#Task 2

$a = 5;
$b = 12;
$c = 7;

$D = $b ** 2 - 4 * $a * $c;

if ($D > 0) {
    $x1 = (-$b - sqrt($D)) / (2 * $a);
    $x2 = (-$b + sqrt($D)) / (2 * $a);
    echo 'X1 = ' . $x1 . ', X2 = ' . $x2;
} elseif ($D = 0) {
    $x = -$b / 2 * $a;
    echo 'X = ' . $x;
} else {
    echo 'Eq. got no roots.';
}

echo '</br>';

#Task 3

$first = 1;
$second = 2;
$third = 2;

# Сначала сделал этот вариант, так как создание таких условий первым пришло в голову (люблю себе усложнять жизнь)
# Да, он очень сложный и громоздкий, но так уже вышло
if (($first - $second) < 0 && ($first - $third) > 0) {
    if (($first - $second) > ($first - $third)) {
        echo 'Middle = ' . $third;
    } elseif (($first - $second) < ($first - $third)) {
        echo 'Middle = ' . $first;
    }
} elseif (($first - $second) < 0 && ($first - $third) < 0) {
    if (($first - $second) > ($first - $third)) {
        echo 'Middle = ' . $second;
    } elseif (($first - $second) < ($first - $third)) {
        echo 'Middle = ' . $third;
    } else {
        echo 'Error 1.2';
    }
} elseif (($first - $second) > 0 && ($first - $third) > 0) {
    if (($first - $second) > ($first - $third)) {
        echo 'Middle = ' . $third;
    } elseif (($first - $second) < ($first - $third)) {
        echo 'Middle = ' . $second;
    } else {
        echo 'Error 1.3';
    }
} elseif (($first - $second) > 0 && ($first - $third) < 0) {
    echo 'Middle = ' . $first;
} else {
    echo 'Error 1.4';
}
echo '</br>';

# То же самое, что и первый вариант, но переделан с более объединёнными условиями и меньшим количеством вложенности
if (
    (($first - $second) > 0 && ($first - $third) < 0)
    || (($first - $second) < 0 && ($first - $third) > 0
        && ($first - $second) < ($first - $third))
) {
    echo 'Middle = ' . $first;
} elseif (
    (($first - $second) < 0 && ($first - $third) < 0)
    && ($first - $second) > ($first - $third)
    || (($first - $second) > 0 && ($first - $third) > 0)
    && ($first - $second) < ($first - $third)
) {
    echo 'Middle = ' . $second;
} elseif (
    (($first - $second) < 0 && ($first - $third) > 0)
    && ($first - $second) > ($first - $third)
    || (($first - $second) < 0 && ($first - $third) < 0)
    && ($first - $second) < ($first - $third)
    || (($first - $second) > 0 && ($first - $third) > 0)
    && ($first - $second) > ($first - $third)
) {
    echo 'Middle = ' . $third;
} else {
    echo 'Error 2';
}
echo '</br>';

/* Осознавая, что решение какое-то уж слишком громоздкое и сложное,
    решил всё же подсмотреть в интернете похожую задачу и посмотреть,
    есть ли вариант с более простыми условиями для проверки.
    И такой есть.
*/
if ($first < $second && $first < $third) {
    if ($second < $third) {
        echo 'Middle = ' . $second;
    } elseif ($second > $third) {
        echo 'Middle = ' . $third;
    } else {
        echo 'Error 3.1';
    }
}elseif ($second < $first && $second < $third){
    if ($first < $third) {
        echo 'Middle = ' . $first;
    } elseif ($first > $third) {
        echo 'Middle = ' . $third;
    } else {
        echo 'Error 3.2';
    }
}elseif ($third < $first && $third < $second){
    if ($first < $second) {
        echo 'Middle = ' . $first;
    } elseif ($first > $second) {
        echo 'Middle = ' . $second;
    } else {
        echo 'Error 3.3';
    }
} else {
    echo 'Error 3.4';
}
# Этот вариант тоже можно сделать более компактным с комплексным условием, но нужно-ли это? Теперь уже сомневаюсь.
# Добавил пометки "Х.Х" в сообщения error для отслеживания веток (ну и для удобства проверки)