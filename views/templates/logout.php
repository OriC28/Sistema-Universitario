<?php
define('BASE_URL', '/Sistema-Universitario/');
session_start();

session_unset();

session_destroy();

header('Location: '.BASE_URL.'views/home.php');

if(isset($_COOKIE['PHPSESSID'])) {
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', null, -1, '/');
    exit();
    return true;
} else {
    return false;
}

