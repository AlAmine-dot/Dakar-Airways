<?php
include('./front-components/navbar.php');
$message = "";

if (isset($_GET['loggedout'])) {
    $message = "<div class='alert alert-success'>Vous avez été deconnecté avec succès ! </div>";
}


?>

<section class="dashboard-home home-admin" id="dashboard-home">
    <div class="wrapper">
        <div class="profile-edit">
            <?= $message ?>
            <?php
            if (isset($_SESSION['SESSION_ID'])) {
                echo "
                <h1 class='admin-heading'>Bienvenue, " . $admin['nom'] . " !</h1>
                <p class='admin-description'>
                    Vous pouvez accéder à la base de données en cliquant sur les différentes sections du menu !
                </p>
                ";
            } else {
                echo "
                <h1 class='admin-heading'>Bienvenue, Admin !</h1>
                <p class='admin-description'>
                    Veuillez vous connecter pour accéder à la base de données !
                </p>
                ";
            }
            ?>
        </div>
    </div>

</section>

<?php include('./front-components/footer.php') ?>