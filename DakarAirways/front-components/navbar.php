<!-- Cette composante est le menu principal du site, il comprend aussi les pop-up de recherche et de connexion.  -->

<!-- Cette variable permet de changer l'état du bouton de connexion. Si state = 0 alors le bouton afffiche " Connexion " -->

<?php
session_start();
include("./php-assets/config.php");
$msg = '';

// Test des conditions pour décider de l'affichage du message grâce à une variable d'URL :

if (isset($_GET['trylogin']) && $_GET['trylogin'] == 1) {
    $msg = "<div class='alert alert-info'>Cet email et/ou ce mot de passe n'existe(nt) pas</div>";
} else if (isset($_GET['trylogin']) && $_GET['trylogin'] == 2) {
    $msg = "<div class='alert alert-danger'>Veuillez vérifier votre compte par e-mail d'abord !</div>";
}

if (isset($_SESSION['SESSION_MAIL']) && isset($_GET['trylogin'])) {
    header('location: index.php?loggedin');
    die;
}


if (isset($_GET['loggedout'])) {
    $msg = "<div class='alert alert-success'>Vous avez été deconnecté avec succès !</div>";
}

// if (isset($_GET['resetunmatched'])) {
//     $msg = "<div class='alert alert-info'>Oops ! The reset password link unmatched :/</div>";
// }

// if (isset($_GET['resetmatched'])) {
//     $msg = "<div class='alert alert-success'>Your password has been successfully reset !<br>You can login now :</div>";
// }



if (isset($_POST['submit'])) {
    // echo "submitted !";
    // On créee les variables email et mot de passe dès que le bouton " connexion " est triggered

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Cette variable trylogin permet de vérifier si l'utilisateur est actuellement entrain d'essayer de se connecter 
    // afin d'afficher le pop-up

    // echo $email;
    // On vérifie si les identifiants entrés dans le formulaire correspondent à un compte dans la base de données :

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'")) === 1) {
        $query = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (empty($row['code'])) {
            $_SESSION['SESSION_MAIL'] = $email;
            header('location: index.php');
        } else {
            header('location: index.php?trylogin=2');
        }
    } else {
        header('location: index.php?trylogin=1');
        // $msg = "<div class='alert alert-info'>Cet email et/ou ce mot de passe n'existent pas</div>";
    }
}

if (isset($_GET['verification'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'"))) {
        $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");

        if ($query) {
            $msg = "<div class='alert alert-success'>Votre compte a été vérifié avec succès, vous pouvez vous connecter : </div>";
        }
    } else {
        header('location:index.php');
    }

    if ($_GET['verification'] === '') {
        header('location:index.php');
    }
}

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

    ?>
    <!-- Header -->
    <header>
        <a href="index.php" class="logo">
            <i class="fas fa-solid fa-plane-arrival"></i>
            Dakar Airways
        </a>
        <nav class="navbar">
            <a class="<?php active('index.php'); ?>" href="index.php">Accueil</a>
            <a class="<?php active('vols.php'); ?>" href="vols.php">Voyager</a>
            <a class="" href="index.php#about">À propos</a>
            <a href="index.php#newsletter">Contacts</a>
        </nav>

        <div class="icons">
            <i class="fas fa-bars" id="menu-bars"></i>
            <i class="fas fa-search" id="search-icon"></i>
        </div>
        <?php

        if (isset($_SESSION['SESSION_MAIL'])) {
            echo "
            <div>
                <a href='dashboard.php' class='highlight-btn profile-button'>
                    Mon profil
                    <i class='fas fa-duotone fa-user'></i>
                </a>
            </div>
            ";
        } else {
            echo "
        </div>
            <div class='login'>
                <a class='highlight-btn modal-open-btn'>
                    Connexion
                    <i class='fas fa-duotone fa-user'></i>
                </a>
            </div>
            ";
        }

        ?>
    </header>

    <!-- Login form -->

    <div class="modal" id="login-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-content-left">
                <img src="images/login_svg.svg" alt="Spaceship image" id="modal-img" />
            </div>
            <div class="modal-content-right">
                <h1>Connectez vous en remplissant les informations ci-dessous !</h1>
                <?= $msg ?>
                <form action="" method="POST" id="form" class="modal-form">
                    <div class="form-validation">
                        <input type="email" class="modal-input" id="email" name="email" placeholder="Entrez votre email" required />
                    </div>
                    <div class="form-validation">
                        <input type="password" class="modal-input" id="password" name="password" placeholder="Entrez votre mot de passe" />
                    </div>
                    <input type="submit" name="submit" value="Connexion" class="modal-input-btn highlight-btn" />
                    <br />
                </form>
                <span>
                    Vous n'avez pas encore de compte ? <br />
                    Inscrivez-vous
                    <a href="inscription.php">en appuyant ici</a> !
                </span>
            </div>
        </div>
    </div>

    <!-- Search form -->

    <form action="" id="search-form">
        <input type="search" placeholder="Recherchez ici..." name="" id="search-box" />
        <label for="search-box" class="fas fa-search"></label>
        <i class="fas fa-times" id="close"></i>
    </form>

    <!-- Navbar search and login modal end here -->