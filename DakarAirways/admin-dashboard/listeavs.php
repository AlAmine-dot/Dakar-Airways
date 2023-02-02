<?php
include('./front-components/navbar.php');
$message = "";

if (!isset($_SESSION['SESSION_ID'])) {
    header('location: connexion.php?loginfirst');
}

if (isset($_GET['loggedout'])) {
    $message = "<div class='alert alert-success'>Vous avez été deconnecté avec succès ! </div>";
}

if (isset($_GET['updated'])) {
    $message = "<div class='alert alert-success'>L'avion a été modifié avec succès !</div>";
}

if (isset($_GET['added'])) {
    $message = "<div class='alert alert-success'>L'avion a été ajouté avec succès !</div>";
}

if (isset($_GET['wrongid'])) {
    $message = "<div class='alert alert-info'>L'avion que vous essayez de supprimer n'est pas valide !</div>";
}

if (isset($_GET['deleted'])) {
    $message = "<div class='alert alert-success'>L'avion a été supprimé avec succès</div>";
}

if (isset($_GET['deletefailed'])) {
    $message = "<div class='alert alert-danger'>Oops ! Quelque chose a mal tourné :/ Veuillez réessayer !</div>";
}


?>

<section class="dashboard-home" id="dashboard-home">
    <div class="wrapper">
        <div class="profile-edit admin-dest destinations">
            <?= $message ?>
            <h1 class='admin-heading'>Liste des avions :</h1>
            <p class='admin-description'>
                Tous les avions de la base de données sont répertoriés ci-dessous :
            </p>

            <div class="box-container">
                <?php
                $query_avions = mysqli_query($conn, "SELECT * FROM avion");
                $avions = mysqli_fetch_all($query_avions, MYSQLI_ASSOC);
                foreach ($avions as $avion) {
                    echo "
                        <div class='box'>
                        <h3>" . $avion['typeav'] . " </h3>
                        <div class='stars'>
                        <p></p>
                        <p>Id avion : " . $avion['idav'] . "</p> 
                        <p>Cap : " . $avion['cap'] . "</p>
                        <p>Localisation : " . $avion['loc'] . "</p>
                        <p>Etat : " . $avion['remarq'] . "</p>
                        </div>";
                    // Avec le bouton, on retourne l'id du vol à la page reservation.php
                    echo "<a href='deleteav.php?id=" . $avion['idav'] . "' class='btn delete'>Supprimer</a>
                        ";
                    echo "<a href='editav.php?id=" . $avion['idav'] . "' class='btn edit'>Modifier</a>
                        </div>
                        ";
                }

                ?>
            </div>
            <a href='addav.php' class='btn'>Ajouter des avions</a>
        </div>
    </div>
    </div>

</section>

<?php include('./front-components/footer.php') ?>