<?php

session_start();

if (isset($_SESSION['SESSION_MAIL'])) {
    session_unset();
    session_destroy();
    header('location: index.php?loggedout&trylogin');
} else {
    header('location: index.php');
    die;
}

// echo $_POST['SESSION_MAIL'];
