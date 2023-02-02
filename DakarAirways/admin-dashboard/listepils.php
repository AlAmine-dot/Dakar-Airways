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
    $message = "<div class='alert alert-success'>Le pilote a été modifié avec succès !</div>";
}

if (isset($_GET['added'])) {
    $message = "<div class='alert alert-success'>Le pilote a été ajouté avec succès !</div>";
}

if (isset($_GET['wrongid'])) {
    $message = "<div class='alert alert-info'>Le pilote que vous essayez de supprimer n'est pas valide !</div>";
}

if (isset($_GET['deleted'])) {
    $message = "<div class='alert alert-success'>Le pilote a été supprimé avec succès</div>";
}

if (isset($_GET['deletefailed'])) {
    $message = "<div class='alert alert-danger'>Oops ! Quelque chose a mal tourné :/ Veuillez réessayer !</div>";
}


?>

<section class="dashboard-home" id="dashboard-home">
    <div class="wrapper">
        <div class="profile-edit admin-dest destinations">
            <?= $message ?>
            <h1 class='admin-heading'>Liste des pilotes :</h1>
            <p class='admin-description'>
                Tous les pilotes de la base de données sont répertoriés ci-dessous :
            </p>

            <div class="box-container">
                <?php
                $query_pilotes = mysqli_query($conn, "SELECT * FROM pilote");
                $pilotes = mysqli_fetch_all($query_pilotes, MYSQLI_ASSOC);
                foreach ($pilotes as $pilote) {
                    echo "
                        <div class='box'>
                        <img src='../images/" . $pilote['image'] . "' alt='' />
                        <h3>" . $pilote['nompil'] . " </h3>
                        <div class='stars'>
                        <p></p>
                        <p>Id pilote : " . $pilote['idpil'] . "</p> 
                        <p>Adresse : " . $pilote['adr'] . "</p>
                        <p>No Tel : " . $pilote['tel'] . "</p>
                        <p>Date de naissance : " . $pilote['dnaiss'] . "</p>
                        <p>Salaire :" . $pilote['sal'] . "</p>
                        </div>";
                    // Avec le bouton, on retourne l'id du vol à la page reservation.php
                    echo "<a href='deletepil.php?id=" . $pilote['idpil'] . "' class='btn delete'>Supprimer</a>
                        ";
                    echo "<a href='editpil.php?id=" . $pilote['idpil'] . "' class='btn edit'>Modifier</a>
                        </div>
                        ";
                }

                ?>
            </div>
            <a href='addpil.php' class='btn'>Ajouter des pilotes</a>
        </div>
    </div>
    </div>

</section>

<?php include('./front-components/footer.php') ?>