<?php
session_start();

$_SESSION['answer3'] = $_POST['agreement'];

if ($_SESSION['answer1'] && $_SESSION['answer2'] && $_SESSION['answer3']){
    echo "You're a {$_SESSION['answer1']} with age {$_SESSION['answer2']} and you're totally {$_SESSION['answer3']}!";
} else {
    echo 'Something went wrong..';
}