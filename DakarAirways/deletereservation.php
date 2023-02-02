<?php
//SQL Query to Delete Data from Database
session_start();
include("./php-assets/config.php");
// On interdit l'accès aux non connectés
if (!isset($_SESSION['SESSION_MAIL'])) {
    header('location: index.php');
    die;
}
if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM reservations WHERE id='{$_GET['id']}'")) === 0) {
    header('location: index.php');
    die;
}

$sql_delete = "DELETE FROM reservations WHERE id={$_GET['id']}";
//Execute the Query
$res = mysqli_query($conn, $sql_delete);


// Check whether the data is delete from database or not
if ($res == true) {
    //SEt Success MEssage and REdirect
    //Redirect to Manage Category
    header('location: dashboard.php?deleted');
} else {
    header('location: dashboard.php?deletefailed');
}

echo "test";
