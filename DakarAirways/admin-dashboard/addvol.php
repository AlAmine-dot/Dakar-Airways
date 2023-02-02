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
    $idpil = mysqli_real_escape_string($conn, $_POST['idpil']);
    $idav = mysqli_real_escape_string($conn, $_POST['idav']);
    $villedep = mysqli_real_escape_string($conn, $_POST['villedep']);
    $villearr = mysqli_real_escape_string($conn, $_POST['villearr']);
    $harr = mysqli_real_escape_string($conn, $_POST['harr']);
    $hdep = mysqli_real_escape_string($conn, $_POST['hdep']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $etoiles = mysqli_real_escape_string($conn, $_POST['etoiles']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix']);

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
                $sqladd = "INSERT INTO vol (idpil, idav, villedep, villearr, harr, hdep, dat, etoiles, prix, image) VALUES ('{$idpil}', '{$idav}', '{$villedep}', '{$villearr}', '{$harr}', '{$hdep}', '{$date}', '{$etoiles}', '{$prix}', '{$profileImageName}')";

                //On vérifie sie la requête a été bonne ou pas :
                if (mysqli_query($conn, $sqladd)) {
                    header('location: listevols.php?added');
                } else {

                    header('location: addvol.php?failed');
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
            <h1>Ajoutez un nouveau vol en remplissant le formulaire ci-dessous :</h1>
            <?= $msg ?>
            <form action="" method="POST" id="form" class="modal-form" enctype="multipart/form-data">
                <div class="form-validation">
                    <label for="">Image d'illustration: </label>
                    <input type="file" name="profileImage" id="fileInput">
                </div>
                <div class="form-validation">
                    <label for="">Id pilote : </label>
                    <input type="number" class="modal-input" id="idpil" name="idpil" required />
                </div>
                <div class="form-validation">
                    <label for="">Id avion : </label>
                    <input type="number" class="modal-input" id="idav" name="idav" required />
                </div>
                <div class="form-validation">
                    <label for="">Ville dep : </label>
                    <input type="text" class="modal-input" name="villedep" required />
                </div>
                <div class="form-validation">
                    <label for="">Ville arr : </label>
                    <input type="text" class="modal-input" name="villearr" required />
                </div>
                <div class="form-validation">
                    <label for="">Heure dep (non formaté) : </label>
                    <input type="number" class="modal-input" name="hdep" required />
                </div>
                <div class="form-validation">
                    <label for="">Heure arr (non formaté) : </label>
                    <input type="number" class="modal-input" name="harr" required />
                </div>
                <div class="form-validation">
                    <label for="">Date (non formaté) : </label>
                    <input type="date" class="modal-input" name="date" required />
                </div>
                <div class="form-validation">
                    <label for="">Nombre d'étoiles : </label>
                    <input type="number" class="modal-input" name="etoiles" required />
                </div>
                <div class="form-validation">
                    <label for="">Prix (en XOF) : </label>
                    <input type="number" class="modal-input" name="prix" required />
                </div>
                <input type="submit" name="submitadd" value="Ajouter" class="modal-input-btn highlight-btn" />
                <br />
            </form>
            <span>
                Pour avoir un aperçu des modifications ou de l'ajout, vous pourrez retourner consulter la page de la liste des vols
                en appuyant <a href="listevols.php">ici !</a>
            </span>
        </div>
    </div>
</section>

<?php include('./front-components/footer.php') ?>