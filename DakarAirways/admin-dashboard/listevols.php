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
    $message = "<div class='alert alert-success'>Le vol a été modifié avec succès !</div>";
}

if (isset($_GET['added'])) {
    $message = "<div class='alert alert-success'>Le vol a été ajouté avec succès !</div>";
}

if (isset($_GET['wrongid'])) {
    $message = "<div class='alert alert-info'>Le vol que vous essayez de supprimer n'est pas valide !</div>";
}

if (isset($_GET['deleted'])) {
    $message = "<div class='alert alert-success'>Le vol a été supprimé avec succès</div>";
}

if (isset($_GET['deletefailed'])) {
    $message = "<div class='alert alert-danger'>Oops ! Quelque chose a mal tourné :/ Veuillez réessayer !</div>";
}


?>

<section class="dashboard-home" id="dashboard-home">
    <div class="wrapper">
        <div class="profile-edit admin-dest destinations">
            <?= $message ?>
            <h1 class='admin-heading'>Liste des vols :</h1>
            <p class='admin-description'>
                Tous les vols de la base de données sont répertoriés ci-dessous :
            </p>

            <div class="box-container">
                <?php
                $query_vols = mysqli_query($conn, "SELECT * FROM vol");
                $vols = mysqli_fetch_all($query_vols, MYSQLI_ASSOC);
                foreach ($vols as $vol) {
                    echo "
                        <div class='box'>
                        <img src='../images/" . $vol['image'] . "' alt='' />
                        <h3>" . $vol['villedep'] . " - " . $vol['villearr'] . " </h3>
                        <div class='stars'>
                        <p></p>
                        <p>Id vol : " . $vol['idvol'] . "</p> 
                        <p>Id pilote : " . $vol['idpil'] . "</p>
                        <p>Id avion : " . $vol['idav'] . "</p>
                        <p>Ville dep : " . $vol['villedep'] . "</p>
                        <p>Ville arr : " . $vol['villearr'] . "</p>
                        <p>Heure dep : " . date("H:i", strtotime($vol['hdep'])) . "</p>
                        <p>Heure arr : " . date("H:i", strtotime($vol['harr'])) . "</p>
                        <p>Date : " . $vol['dat'] . "</p>
                        <p>Etoiles :" . $vol['etoiles'] . "</p>
                        <p>Prix :</p>
                        </div>
                        <span> " . $vol['prix'] . " XOF </span><br>";

                    // Avec le bouton, on retourne l'id du vol à la page reservation.php
                    echo "<a href='deletevol.php?id=" . $vol['idvol'] . "' class='btn delete'>Supprimer</a>
                        ";
                    echo "<a href='editvol.php?id=" . $vol['idvol'] . "' class='btn edit'>Modifier</a>
                        </div>
                        ";
                }

                ?>
            </div>
            <a href='addvol.php' class='btn'>Ajouter des vols</a>
        </div>
    </div>
    </div>

</section>

<?php include('./front-components/footer.php') ?>