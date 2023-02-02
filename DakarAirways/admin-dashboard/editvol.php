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

// Requête pour aller chercher le vol concerné par la modification 
$query_voltoedit = mysqli_query($conn, "SELECT * FROM vol");
$vols = mysqli_fetch_all($query_voltoedit, MYSQLI_ASSOC);


if (isset($_POST['submitedit'])) {
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

    // Cette variable trylogin permet de vérifier si l'utilisateur est actuellement entrain d'essayer de se connecter 
    // afin d'afficher le pop-up
    // echo "<script>alert('chill')</script>";


    // Gestion du fichier images (extension et taille) pour l'illustration du vol :

    $typesAllowed = ['jpg', 'png', 'jpeg'];
    $fileExt = explode('.', $_FILES['profileImage']['name']);
    $fileActualExt = strtolower(end($fileExt));

    // echo $fileActualExt;
    // Au cas où la personne modifie sans insérer d'image, l'image actuelle est conservée :

    if (empty($fileActualExt)) {
        $sqlupdate = "UPDATE pilote SET
        nompil = '{$nompilote}',
        dnaiss = '{$dnaisspilote}',
        adr = '{$adrpilote}',
        tel = '{$telpilote}',
        sal = '{$salpilote}'
        WHERE idpil='{$_GET['id']}'
        ";

        //Check whether the query executed successfully or not
        if (mysqli_query($conn, $sqlupdate)) {
            header('location: listepils.php?updated');
        } else {
            // Failed to Update Admin
            // Redirect to Manage Admin Page

            header('location: editpil.php?id=' . $_GET['id'] . '&failed');
        }

        $dataQuery = mysqli_query($conn, $sqlQuery);
        if ($dataQuery) {
            $msg = "<div class='alert alert-success'>L'image a été téléchargée avec succès</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Echec du téléchargement de l'image</div>";
        }
    }

    if (!in_array($fileActualExt, $typesAllowed)) {
        $msg = "<div class='alert alert-danger'>Oops, cette extension image n'est pas autorisée, veuillez en essayer une autre.</div>";
    } else {

        if ($_FILES['profileImage']['size'] > 50000000) {
            $msg = "<div class='alert alert-danger'>Oops, la taille (kbits) de l'image est trop élevée.</div>";
        } else {

            $profileImageName = time() . '_' . $_FILES['profileImage']['name'];
            $target = '../images/' . $profileImageName;
            $sqlQuery = "UPDATE vol SET image='{$profileImageName}' WHERE idvol='{$_GET['id']}'";
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)) {

                $sqlupdate = "UPDATE vol SET
                idpil = '{$idpil}',
                idav = '{$idav}',
                villedep = '{$villedep}' ,
                villearr = '{$villearr}' ,
                harr = '{$harr}',
                hdep = '{$hdep}',
                dat = '{$date}',
                etoiles = '{$etoiles}',
                prix = '{$prix}'
                WHERE idvol='{$_GET['id']}'
                ";


                    //Execute the Query
                ;

                //Check whether the query executed successfully or not
                if (mysqli_query($conn, $sqlupdate)) {
                    header('location: listevols.php?updated');
                } else {
                    // Failed to Update Admin
                    // Redirect to Manage Admin Page

                    header('location: editvol.php?id=' . $_GET['id'] . '&failed');
                }

                $dataQuery = mysqli_query($conn, $sqlQuery);
                if ($dataQuery) {
                    $msg = "<div class='alert alert-success'>L'image a été téléchargée avec succès</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Echec du téléchargement de l'image</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Echec du téléchargement de l'image</div>";
            }
        }
    }

        //Create a SQL Query to Update Admin




        // echo $email;
        // On vérifie si les identifiants entrés dans le formulaire correspondent à un compte dans la base de données :

        // if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM admin WHERE identifiant='{$identifiant}' AND password='{$password}'")) === 1) {
        //     $query = "SELECT * FROM admin WHERE identifiant='{$identifiant}' AND password='{$password}'";
        //     $result = mysqli_query($conn, $query);
        //     $row = mysqli_fetch_assoc($result);

        //     $_SESSION['SESSION_ID'] = $identifiant;
        //     header('location: index.php?loggedin');
    ;
    // } else {
    //     $msg = "<div class='alert alert-info'>Cet identifiant ou ce mot de passe n'existent pas !</div>";
    // }
}

?>

<section class="dashboard-home" id="home-booking">
    <!-- Login form -->

    <div class="modal-content-2">
        <div class="modal-content-right">
            <?php foreach ($vols as $vol) {
                if ($vol['idvol'] === $_GET['id']) {
            ?>
                    <h1>Modifiez le vol d'id <?= $vol['idvol'] ?> en remplissant le formulaire ci-dessous :</h1>
                    <?= $msg ?>
                    <form action="" method="POST" id="form" class="modal-form" enctype="multipart/form-data">
                        <div class="form-validation">
                            <label for="">Image d'illustration: </label>
                            <input type="file" name="profileImage" id="fileInput">
                        </div>
                        <div class="form-validation">
                            <label for="">Id pilote : </label>
                            <input type="number" class="modal-input" id="idpil" name="idpil" value=<?= $vol['idpil'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Id avion : </label>
                            <input type="number" class="modal-input" id="idav" name="idav" value=<?= $vol['idav'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Ville dep : </label>
                            <input type="text" class="modal-input" name="villedep" value=<?= $vol['villedep'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Ville arr : </label>
                            <input type="text" class="modal-input" name="villearr" value=<?= $vol['villearr'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Heure dep (non formaté) : </label>
                            <input type="number" class="modal-input" name="hdep" value=<?= $vol['hdep'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Heure arr (non formaté) : </label>
                            <input type="number" class="modal-input" name="harr" value=<?= $vol['harr'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Date (non formaté) : </label>
                            <input type="date" class="modal-input" name="date" value=<?= $vol['dat'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Nombre d'étoiles : </label>
                            <input type="number" class="modal-input" name="etoiles" value=<?= $vol['etoiles'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Prix (en XOF) : </label>
                            <input type="number" class="modal-input" name="prix" value=<?= $vol['prix'] ?> required />
                        </div>
                        <input type="submit" name="submitedit" value="Modifier" class="modal-input-btn highlight-btn" />
                        <br />
                    </form>
                    <span>
                        Pour avoir un aperçu des modifications ou de l'ajout, vous pourrez retourner consulter la page de la liste des vols
                        en appuyant <a href="listevols.php">ici !</a>
                    </span>
        </div>
<?php }
            }
?>
    </div>
</section>

<?php include('./front-components/footer.php') ?>