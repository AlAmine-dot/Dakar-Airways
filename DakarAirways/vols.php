<?php include('./front-components/navbar.php') ?>

<main>

    <section class="vol-home" id="vol-home">
        <?php
        if (isset($_GET['cantbook']) && !isset($_GET['loggedin'])) {
            echo "<div class='alert alert-danger' id='danger'>Veuillez d'abord sélectionner un vol valide avant de réserver</div>";
        }
        ?>
        <?php include('./front-components/searchform-shortcut.php') ?>
    </section>

    <!-- Menu section -->

    <section class="menu" id="menu">
        <h3 class="sub-heading">Dakar Airways</h3>
        <h1 class="heading">Liste des vols disponibles</h1>
        <?php

        if (isset($_GET['villedep']) && isset($_GET['villearr']) && isset($_GET['datemin']) && isset($_GET['datemax'])) {

            $query_vols = mysqli_query($conn, "SELECT * FROM vol");
            $vols = mysqli_fetch_all($query_vols, MYSQLI_ASSOC);

            echo "
            <h1 class='heading' id='search-result'>RESULTATS DE VOTRE RECHERCHE :</h1>
            <div>
            <div class='box-container'>
            ";

            $countresults = 0;
            foreach ($vols as $vol) {
                // On teste les conditions de la recherche afin de n'afficher que les résultats
                // voulus
                if ($vol['villedep'] === $_GET['villedep'] && $vol['villearr'] === $_GET['villearr'] && date("Ymd", strtotime($vol['dat'])) >= date("Ymd", strtotime($_GET['datemin'])) && date("Ymd", strtotime($vol['dat'])) <= date("Ymd", strtotime($_GET['datemax']))) {
                    $countresults++;
                    echo "

                    <div class='box'>
                    <div class='image'>
                    <img src='images/" . $vol['image'] . "' alt='' />
                    <a href='' class='fas fa-heart'></a>
                    </div>
                    <div class='content'>
                    <div class='stars'>";
                    // On insère le nombre d'étoiles obtenue par la destination selon la valeur
                    // de la base de données (il n'y a pas de sections vote donc l'admin décide des valeurs)
                    for ($i = 0; $i <= $vol['etoiles']; $i++) {

                        echo "<i class='fas fa-star'></i>";
                    }
                    echo " 
                <i class='fas fa-star-half-alt'></i>
                </div>
                <h3>" . $vol['villedep'] . " (DEP)</h3>
                <h3>" . $vol['villearr'] . " (ARR)</h3>
                <p class='dates'>
                Date de départ : " . date("Y/m/d", strtotime($vol['dat'])) . "
                
                </p>
                <p class='classes'>
                Départ : " . date("H:i", strtotime($vol['hdep'])) . " | Arrivée : " . date("H:i", strtotime($vol['harr'])) . "
                </p>
                <div class='prix'>
                
                <a href='reservation.php' class='btn'>Réserver</a>
                <div>
                <p>
                À partir de
                </p>
                <span class='pice'>XOF 426</span>
                </div>
                </div>
                </div>
                </div>
                ";
                }
            }
            if ($countresults === 0) {

                echo "</div><div style='margin-top:2rem; text-align:center;' class='alert alert-danger'>" . $countresults . " résultats trouvés :/ </div>";
            } else {
                echo "</div><div style='margin-top:2rem; text-align:center;' class='alert alert-info'>" . $countresults . " résultats trouvés</div>";
            }
        } else {

            echo "
            <h1 class='heading search-result'>Tous les vols</h1>
            <div class='box-container'>

        ";
            foreach ($vols as $vol) {
                echo "
                <div class='box'>
                <div class='image'>
                <img src='./images/" . $vol['image'] . "' alt='' />
                    <a href='' class='fas fa-heart'></a>
                    </div>
                    <div class='content'>
                    <div class='stars'>";
                // On insère le nombre d'étoiles obtenue par la destination selon la valeur
                // de la base de données (il n'y a pas de sections vote donc l'admin décide des valeurs)
                for ($i = 0; $i <= $vol['etoiles']; $i++) {

                    echo "<i class='fas fa-star'></i>";
                }
                echo " 
                <i class='fas fa-star-half-alt'></i>
                </div>
                <h3>" . $vol['villedep'] . " (DEP)</h3>
                <h3>" . $vol['villearr'] . " (ARR)</h3>
                <p class='dates'>
                Date de départ : " . date("Y/m/d", strtotime($vol['dat'])) . "
                </p>
                <p class='classes'>
                Départ : " . date("H:i", strtotime($vol['hdep'])) . " | Arrivée : " . date("H:i", strtotime($vol['harr'])) . "
                </p>
                <div class='prix'>";

                // Avec le bouton, on retourne l'id du vol à la page reservation.php
                echo "<a href='reservation.php?id=" . $vol['idvol'] . "' class='btn'>Réserver</a>
                ";

                echo "
                <div>
                <p>
                À partir de
                </p>
                <span class='pice'>" . $vol['prix'] . " XOF </span>
                </div>
                </div>
                </div>
                </div>
                ";
            }
        }
        ?>

        </div>
    </section>

    <?php include('./front-components/footer.php') ?>