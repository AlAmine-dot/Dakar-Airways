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
    // On créee les variables email et mot de passe dès que le bouton " connexion " est triggered

    // $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $nompilote = mysqli_real_escape_string($conn, $_POST['nompilote']);
    $adrpilote = mysqli_real_escape_string($conn, $_POST['adrpilote']);
    $telpilote = mysqli_real_escape_string($conn, $_POST['telpilote']);
    $salpilote = mysqli_real_escape_string($conn, $_POST['salpilote']);
    $dnaisspilote = mysqli_real_escape_string($conn, $_POST['dnaisspilote']);

    // Gestion du fichier images (extension et taille) pour l'illustration du vol :

    $typesAllowed = ['jpg', 'png', 'jpeg'];
    $fileExt = explode('.', $_FILES['profileImage']['name']);
    $fileActualExt = strtolower(end($fileExt));


    if (!in_array($fileActualExt, $typesAllowed)) {
        $msg = "<div class='alert alert-danger'>Oops, cette extension image n'est pas autorisée, veuillez en essayer une autre.</div>";
    } else {

        if ($_FILES['profileImage']['size'] > 500000) {
            $msg = "<div class='alert alert-danger'>Oops, la taille (kbits) de l'image est trop élevée.</div>";
        } else {

            $profileImageName = time() . '_' . $_FILES['profileImage']['name'];
            $target = '../images/' . $profileImageName;
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)) {

                //On créee la requête SQL pour ajouter le vol
                $sqladd = "INSERT INTO pilote (nompil, dnaiss, adr, tel, sal, image) VALUES ('{$nompilote}', '{$dnaisspilote}', '{$adrpilote}', '{$telpilote}', '{$salpilote}', '{$profileImageName}')";

                //On vérifie sie la requête a été bonne ou pas :
                if (mysqli_query($conn, $sqladd)) {
                    header('location: listepils.php?added');
                } else {

                    header('location: addpil.php?failed');
                }
            } else {
                $msg = "<div class='alert alert-danger'>Echec du téléchargement de l'image</div>";
            }
        }
    }
}

?>

<section class="dashboard-home" id="home-booking">
    <!-- Login form -->

    <div class="modal-content-2">
        <div class="modal-content-right">
            <h1>Ajoutez un nouveau pilote en remplissant le formulaire ci-dessous :</h1>
            <?= $msg ?>
            <form action="" method="POST" id="form" class="modal-form" enctype="multipart/form-data">
                <div class="form-validation">
                    <label for="">Image d'illustration: </label>
                    <input type="file" name="profileImage" id="fileInput">
                </div>
                <div class="form-validation">
                    <label for="">Nom pilote : </label>
                    <input type="text" class="modal-input" id="nompil" name="nompilote" required />
                </div>
                <div class="form-validation">
                    <label for="">Adresse : </label>
                    <input type="text" class="modal-input" name="adrpilote" required />
                </div>
                <div class="form-validation">
                    <label for="">No téléphone : </label>
                    <input type="text" class="modal-input" name="telpilote" required />
                </div>
                <div class="form-validation">
                    <label for="">Salaire (en XOF): </label>
                    <input type="number" class="modal-input" name="salpilote" required />
                </div>
                <div class="form-validation">
                    <label for="">Date (non formatée) : </label>
                    <input type="date" class="modal-input" name="dnaisspilote" required />
                </div>
                <input type="submit" name="submitadd" value="Ajouter" class="modal-input-btn highlight-btn" />
                <br />
            </form>
            <span>
                Pour avoir un aperçu des modifications ou de l'ajout, vous pourrez retourner consulter la page de la liste des pilotes
                en appuyant <a href="listepils.php">ici !</a>
            </span>
        </div>
    </div>
</section>

<?php include('./front-components/footer.php') ?>