<?php include('./front-components/navbar.php');
$message = "";
if (!isset($_SESSION['SESSION_MAIL'])) {
    header('location: index.php');
    die;
}

if (isset($_GET['unavailable'])) {
    $message = "<div class='alert alert-danger' id='danger'>Désolé cette fonctionnalité n'est pas encore disponible :/</div>";
}

if (isset($_GET['deleted'])) {
    $message = "<div class='alert alert-success' id='danger'>Votre réservation a été annulée avec succès</div>";
}

if (isset($_GET['bookeddone'])) {
    $message = "<div class='alert alert-success' id='danger'>Votre réservation a été effectuée avec succès !</div>";
}



?>

<main>

    <section class="dashboard-home" id="dashboard-home">
        <?=
        $message;
        ?>
        <div class="wrapper">
            <div class="profile-edit">
                <div class="image">
                    <img src="./images/profile_avatar.svg" alt="">
                    <?php
                    $query = "SELECT * FROM users WHERE email='{$_SESSION['SESSION_MAIL']}'";
                    $result = mysqli_query($conn, $query);
                    $client = mysqli_fetch_assoc($result);
                    ?>
                </div>
                <div class="infos">
                    <p class="info">
                        <span>Pseudo :</span> <?= $client['name'] ?>
                    </p>
                    <p class="info">
                        <span>Email :</span> <?= $client['email'] ?>
                    </p>
                </div>
                <div class="buttons">
                    <a href="dashboard.php?unavailable" class="highlight-btn">Modifier le profil <i class="fa-solid fa-user-pen"></i></a>
                    <a href="loggout.php" class="highlight-btn delete-btn">Déconnexion <i class="fa-solid fa-door-open"></i> </a>
                </div>

            </div>
        </div>

    </section>

    <section class="menu" id="menu">
        <h3 class="sub-heading">Dakar Airways</h3>
        <h1 class="heading">Mes réservations</h1>
        <?php
        $query_reservations = mysqli_query($conn, "SELECT * FROM reservations WHERE id_client={$client['id']}");
        $reservations = mysqli_fetch_all($query_reservations, MYSQLI_ASSOC);

        $countrows = 0;
        echo "
        <div class='box-container'>
        ";
        foreach ($reservations as $reservation) {
            $countrows++;
            $query_flies = mysqli_query($conn, "SELECT * FROM vol WHERE idvol={$reservation['id_vol']}");
            $flies = mysqli_fetch_all($query_flies, MYSQLI_ASSOC);
            foreach ($flies as $fly) {

                echo "
            <div class='box'>
            <div class='image'>
                <img src='images/" . $fly['image'] . "' alt='' />
                <a href='' class='fas fa-heart'></a>
                </div>
            <div class='content'>
                <div class='stars'>";
                // On insère le nombre d'étoiles obtenue par la destination selon la valeur
                // de la base de données (il n'y a pas de sections vote donc l'admin décide des valeurs)
                for ($i = 0; $i <= $fly['etoiles']; $i++) {

                    echo "<i class='fas fa-star'></i>";
                }
                echo "  
                <i class='fas fa-star-half-alt'></i>
                </div>
                <h3>" . $fly['villedep'] . "</h3>
                <h3>" . $fly['villearr'] . "</h3>
                <p class='dates'>
                    Date de départ : " . date("Y/m/d", strtotime($fly['dat'])) . "
                </p>
                <p class='classes'>
               Départ : " . date("H:i", strtotime($fly['hdep'])) . " | Arrivée : " . date("H:i", strtotime($fly['harr'])) . "
                </p>
                <p class='classes'>
                    Code du ticket : " . $reservation['ticket'] . "
                    </p>
                <p class='classes'>
                Nb places réservées : " . $reservation['places'] . "
                </p>
                <div class='prix'>
                
                <a href='deletereservation.php?id=" . $reservation['id'] . "' class='delete-btn highlight-btn'>Annuler</a>
                <div>
                <p>
                Pour un tarif de
                </p>
                <span class='pice'>XOF " . $reservation['tarif'] . "</span>
                </div>
                </div>
                </div>
                </div>
                ";
            }
        }
        if ($countrows === 0) {

            echo "</div></div><div style='margin-top:2rem; text-align:center;' class='alert alert-danger'> Vous n'avez aucune réservation </div>";
        } else {
            echo "</div></div><div style='margin-top:2rem; text-align:center;' class='alert alert-info'> Vous avez " . $countrows . " réservations</div>";
        }

        ?>
    </section>


    <?php include('./front-components/footer.php') ?>