<!-- Cette composante est le formulaire raccourci permettant de faire une recherche de vol grace à l'heure d'arrivée, l'heure de départ et autres infos. -->


<!-- Récupération de la liste des vols -->

<?php
$query_vols = mysqli_query($conn, "SELECT * FROM vol");
$vols = mysqli_fetch_all($query_vols, MYSQLI_ASSOC);
?>
<div class="booking-box">
    <h2 class="booking-box-title">
        Consultez les vols disponibles :
    </h2>
    <form action="vols.php" method="GET" class="booking-box-form">
        <div class="booking-form-inputs">
            <label for="villedep" class="custom-selector">
                Ville de départ :
                <select name="villedep">
                    <?php
                    // On insère toutes les villes de départ comme option

                    foreach ($vols as $vol) {
                        echo "
                                <option value='" . $vol['villedep'] . "' class='selector-options'>
                                    " . $vol['villedep'] . "
                                </option>
                            ";
                    }
                    ?>
                </select>
            </label>
            <label for="villearr" class="custom-selector">
                Ville d'arrivée :
                <select name="villearr">

                    <?php
                    // On insère toutes les villes d'arrivée comme option
                    foreach ($vols as $vol) {
                        echo "
                        <option value='" . $vol['villearr'] . "' class='selector-options'>
                            " . $vol['villearr'] . "
                        </option>
                    ";
                    }
                    ?>
                </select>
            </label>
            <label for="jourmindep" class="custom-selector">
                Date de départ :
                <input class="date" name="datemin" min="1979-01-01" max="2023-01-01" type="date">
            </label>
            <label for="jourmindep" class="custom-selector">
                Date d'arrivée :
                <input class="date" name="datemax" min="1979-01-01" max="2023-01-01" type="date">
            </label>
        </div>
        <input type="submit" class="highlight-btn" value="Rechercher" />
    </form>
</div>