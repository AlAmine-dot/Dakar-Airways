<?php

//SQL Query to Delete Data from Database
session_start();
include("./php-assets/config.php");

// On interdit l'accès aux non connectés
if (!isset($_SESSION['SESSION_ID'])) {
    header('location: connexion.php?loginfirst');
    die;
}

if (!isset($_GET['id']) || empty($_GET['id']) || mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pilote WHERE idpil='{$_GET['id']}'")) === 0) {
    header('location: listepils.php?wrongid');
    die;
} else {

    $sql_delete = "DELETE FROM pilote WHERE idpil={$_GET['id']}";
    //Execute the Query
    $res = mysqli_query($conn, $sql_delete);

    // Check whether the data is delete from database or not
    if ($res == true) {
        //SEt Success MEssage and REdirect
        //Redirect to Manage Category
        header('location: listepils.php?deleted');
    } else {
        header('location: listepils.php?deletefailed');
    }
}
