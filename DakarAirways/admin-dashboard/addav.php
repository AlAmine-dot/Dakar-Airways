<?php
include('./front-components/navbar.php');

// On teste les conditions d'accessibilité à la page grâce aux variables d'url ex : si la personne n'est pas connectée, alors elle sera redirigée vers
// la page de connexion plutôt qu'ici.

if (isset($_GET['loginfirst'])) {
    $msg = "<div class='alert alert-danger'>Vous devez être connecté d'abord !</div>";
}

if (!isset($_SESSION['SESSION_ID'])) {
    header('location: connexion.php?loginfirst');
}

if (isset($_GET['failed'])) {
    $msg = "<div class='alert alert-danger'>Oops ! Quelque chose s'est mal déroulé, veuillez réessayer :/</div>";
}



if (isset($_POST['submitadd'])) {
    // echo "submitted !";
    // On créee les variables dès que le bouton " connexion " est triggered :

    // $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $typeavion = mysqli_real_escape_string($conn, $_POST['typeavion']);
    $capaciteavion = mysqli_real_escape_string($conn, $_POST['capaciteavion']);
    $localisationavion = mysqli_real_escape_string($conn, $_POST['localisationavion']);
    $remarqueavion = mysqli_real_escape_string($conn, $_POST['remarqueavion']);



    //On créee la requête SQL pour ajouter le vol :
    $sqladd = "INSERT INTO avion (typeav, cap, loc, remarq) VALUES ('{$typeavion}', '{$capaciteavion}', '{$localisationavion}', '{$remarqueavion}')";

    //On vérifie sie la requête a été bonne ou pas :
    if (mysqli_query($conn, $sqladd)) {
        header('location: listeavs.php?added');
    } else {

        header('location: addav.php?failed');
    }
}

?>

<section class="dashboard-home" id="home-booking">
    <!-- Login form -->

    <div class="modal-content-2">
        <div class="modal-content-right">
            <h1>Ajoutez un nouvel avion en remplissant le formulaire ci-dessous :</h1>
            <?= $msg ?>
            <form action="" method="POST" id="form" class="modal-form">
                <div class="form-validation">
                    <label for="">Type de l'avion : </label>
                    <input type="text" class="modal-input" id="nomav" name="typeavion" required />
                </div>
                <div class="form-validation">
                    <label for="">Capacité de l'avion : </label>
                    <input type="number" class="modal-input" name="capaciteavion" required />
                </div>
                <div class="form-validation">
                    <label for="">Localisation : </label>
                    <input type="text" class="modal-input" name="localisationavion" required />
                </div>
                <div class="form-validation">
                    <label for="">Remarque (état): </label>
                    <input type="text" class="modal-input" name="remarqueavion" required />
                </div>
                <input type="submit" name="submitadd" value="Ajouter" class="modal-input-btn highlight-btn" />
                <br />
            </form>
            <span>
                Pour avoir un aperçu des modifications ou de l'ajout, vous pourrez retourner consulter la page de la liste des avions
                en appuyant <a href="listeavs.php">ici !</a>
            </span>
        </div>
    </div>
</section>

<?php include('./front-components/footer.php') ?>