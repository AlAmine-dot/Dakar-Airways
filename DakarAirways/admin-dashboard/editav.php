<?php
include('./front-components/navbar.php');

if (isset($_GET['loginfirst'])) {
    $msg = "<div class='alert alert-danger'>Vous devez être connecté d'abord !</div>";
}

if (!isset($_SESSION['SESSION_ID'])) {
    header('location: connexion.php?loginfirst');
}

if (isset($_GET['failed'])) {
    $msg = "<div class='alert alert-danger'>Oops ! Quelque chose s'est mal déroulé, veuillez réessayer :/</div>";
}

// Requête pour aller chercher l'avion concerné par la modification 
$query_avtoedit = mysqli_query($conn, "SELECT * FROM avion");
$avs = mysqli_fetch_all($query_avtoedit, MYSQLI_ASSOC);


if (isset($_POST['submitedit'])) {

    $typeavion = mysqli_real_escape_string($conn, $_POST['typeavion']);
    $capaciteavion = mysqli_real_escape_string($conn, $_POST['capaciteavion']);
    $localisationavion = mysqli_real_escape_string($conn, $_POST['localisationavion']);
    $remarqueavion = mysqli_real_escape_string($conn, $_POST['remarqueavion']);

    //Create a SQL Query to Update Admin

    $sqlupdate = "UPDATE avion SET
                typeav = '{$typeavion}',
                cap = '{$capaciteavion}',
                loc = '{$localisationavion}',
                remarq = '{$remarqueavion}'
                WHERE idav='{$_GET['id']}'
                ";

        //Execute the Query
    ;

    //Check whether the query executed successfully or not
    if (mysqli_query($conn, $sqlupdate)) {
        header('location: listeavs.php?updated');
    } else {
        // Failed to Update Admin
        // Redirect to Manage Admin Page

        header('location: editav.php?id=' . $_GET['id'] . '&failed');
    }
}

?>

<section class="dashboard-home" id="home-booking">
    <!-- Login form -->

    <div class="modal-content-2">
        <div class="modal-content-right">
            <?php foreach ($avs as $av) {
                if ($av['idav'] === $_GET['id']) {
            ?>
                    <h1>Modifiez les informations de l'avion de type <?= $av['typeav'] ?> en remplissant le formulaire ci-dessous :</h1>
                    <?= $msg ?>
                    <form action="" method="POST" id="form" class="modal-form">
                        <div class="form-validation">
                            <label for="">Type avion : </label>
                            <input type="text" class="modal-input" id="typeavion" name="typeavion" value=<?= $av['typeav'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Capacité de l'avion : </label>
                            <input type="number" class="modal-input" name="capaciteavion" value=<?= $av['cap'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Localisation : </label>
                            <input type="text" class="modal-input" name="localisationavion" value=<?= $av['loc'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Remarque (état): </label>
                            <input type="text" class="modal-input" name="remarqueavion" value=<?= $av['remarq'] ?> required />
                        </div>
                        <input type="submit" name="submitedit" value="Modifier" class="modal-input-btn highlight-btn" />
                        <br />
                    </form>
                    <span>
                        Pour avoir un aperçu des modifications ou de l'ajout, vous pourrez retourner consulter la page de la liste des avions
                        en appuyant <a href="listeavs.php">ici !</a>
                    </span>
        </div>
<?php }
            }
?>
    </div>
</section>

<?php include('./front-components/footer.php') ?>