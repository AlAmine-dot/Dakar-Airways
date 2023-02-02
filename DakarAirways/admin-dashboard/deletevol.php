
<?php

//SQL Query to Delete Data from Database
session_start();
include("./php-assets/config.php");

// On interdit l'accès aux non connectés
if (!isset($_SESSION['SESSION_ID'])) {
    header('location: connexion.php?loginfirst');
    die;
}

if (!isset($_GET['id']) || empty($_GET['id']) || mysqli_num_rows(mysqli_query($conn, "SELECT * FROM vol WHERE idvol='{$_GET['id']}'")) === 0) {
    header('location: listevols.php?wrongid');
    die;
} else {

    $sql_delete = "DELETE FROM vol WHERE idvol={$_GET['id']}";
    $sql_delete2 = "DELETE FROM reservations WHERE id_vol={$_GET['id']}";

    //Execute the Query
    $res = mysqli_query($conn, $sql_delete);

    // Check whether the data is delete from database or not
    if ($res == true) {
        //SEt Success MEssage and REdirect
        //Redirect to Manage Category
        mysqli_query($conn, $sql_delete2);
        header('location: listevols.php?deleted');
    } else {
        header('location: listevols.php?deletefailed');
    }
}
echo "test";
