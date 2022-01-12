<?php
date_default_timezone_set('Europe/Kiev');

if (!isset($_COOKIE['user']) && !isset($_COOKIE['count'])) {
    setcookie(
        'user',
        date('d/m/Y H:i:s '),
        time() + 10 * 60 * 60
    );
    setcookie(
        'count',
        $count = 1,
        time() + 10 * 60 * 60
    );
    echo "Hello there, newbie!";
} else {

    $lastVisited = $_COOKIE['user'];
    $count = $_COOKIE['count'];

    setcookie(
        'user',
        date('d/m/Y H:i:s'),
        time() + 10 * 60 * 60
    );
    setcookie(
        'count',
        $count = $_COOKIE['count'] + 1,
        time() + 10 * 60 * 60
    );
    echo 'Welcome back, master!' . '<br>';
    echo 'Last visit: ' . $lastVisited . '<br>';
    echo 'Times visited before: ' . $count;
}

