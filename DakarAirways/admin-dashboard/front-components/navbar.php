<!-- Cette composante est le menu principal du site, il comprend aussi les pop-up de recherche et de connexion.  -->

<!-- Cette variable permet de changer l'état du bouton de connexion. Si state = 0 alors le bouton afffiche " Connexion " -->

<?php
session_start();
include("./php-assets/config.php");
$msg = '';

// Test des conditions pour décider de l'affichage du message grâce à une variable d'URL :

// if (isset($_GET['trylogin']) && $_GET['trylogin'] == 1) {
//     $msg = "<div class='alert alert-info'>Cet email et/ou ce mot de passe n'existe(nt) pas</div>";
// } else if (isset($_GET['trylogin']) && $_GET['trylogin'] == 2) {
//     $msg = "<div class='alert alert-danger'>Veuillez vérifier votre compte par e-mail d'abord !</div>";
// }

// if (isset($_SESSION['SESSION_MAIL']) && isset($_GET['trylogin'])) {
//     header('location: index.php?loggedin');
//     die;
// }


if (isset($_GET['loggedout'])) {
    $msg = "<div class='alert alert-success'>Vous avez été deconnecté avec succès !</div>";
}

if (isset($_SESSION['SESSION_ID'])) {
    $query = "SELECT * FROM admin WHERE identifiant='{$_SESSION['SESSION_ID']}'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);
}

// if (isset($_GET['resetunmatched'])) {
//     $msg = "<div class='alert alert-info'>Oops ! The reset password link unmatched :/</div>";
// }

// if (isset($_GET['resetmatched'])) {
//     $msg = "<div class='alert alert-success'>Your password has been successfully reset !<br>You can login now :</div>";
// }

?>

<?php $state = 0 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/style.css" />
    <script src="./javascript/index.js" type="module"></script>
    <!-- <script src='./javascript/keepsmodalopened.js' type='module'></script> -->
    <?php
    if (isset($_GET['trylogin'])) {
        echo " <script src='./javascript/keepsmodalopened.js' type='module'></script> ";
    } ?>
    <!-- swiper link from greeper/google -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- font awesome link from cdn.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <title>Document</title>
</head>

<body>
    <!-- Header -->

    <?php
    // Ce script permet de traquer en temps réel la page qui est active afin de retourner une classe dans l'html permettant de surligner la section active du menu

    function active($currect_page)
    {
        $url_array =  explode('/', $_SERVER['REQUEST_URI']);
        $url = end($url_array);
        if ($currect_page == $url) {
            echo 'active'; //class name in css 
        }
    }
    ?>

    <header>
        <a href="index.php" class="logo">
            <i class="fas fa-solid fa-plane-arrival"></i>
            Admin Dashboard
        </a>
        <nav class="navbar">
            <a class="<?php active('index.php'); ?>" href="index.php">Accueil</a>
            <a class="<?php active('listevols.php'); ?>" href="listevols.php">Vols</a>
            <a class="<?php active('listepils.php'); ?>" href="listepils.php">Pilotes</a>
            <a class="<?php active('listeavs.php'); ?>" href="listeavs.php">Avions</a>
        </nav>

        <div class="icons">
            <i class="fas fa-bars" id="menu-bars"></i>
            <i class="fas fa-search" id="search-icon"></i>
        </div>
        <?php

        if (isset($_SESSION['SESSION_ID'])) {
            echo "
            <div>
                <a href='deconnexion.php' class='highlight-btn profile-button'>
                    Déconnexion
                    <i class='fas fa-duotone fa-user'></i>
                </a>
            </div>
            ";
        } else {
            echo "
        </div>
            <div class='login'>
                <a class='highlight-btn' href='connexion.php'>
                    Connexion
                    <i class='fas fa-duotone fa-user'></i>
                </a>
            </div>
            ";
        }

        ?>
    </header>

    <!-- Search form -->

    <form action="" id="search-form">
        <input type="search" placeholder="Recherchez ici..." name="" id="search-box" />
        <label for="search-box" class="fas fa-search"></label>
        <i class="fas fa-times" id="close"></i>
    </form>

    <main>
        <!-- Navbar search and login modal end here -->