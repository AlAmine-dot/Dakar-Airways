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

// Requête pour aller chercher le pil concerné par la modification 
$query_piltoedit = mysqli_query($conn, "SELECT * FROM pilote");
$pils = mysqli_fetch_all($query_piltoedit, MYSQLI_ASSOC);


if (isset($_POST['submitedit'])) {
    // echo "submitted !";
    // On créee les variables email et mot de passe dès que le bouton " connexion " est triggered

    // $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $nompilote = mysqli_real_escape_string($conn, $_POST['nompilote']);
    $adrpilote = mysqli_real_escape_string($conn, $_POST['adrpilote']);
    $telpilote = mysqli_real_escape_string($conn, $_POST['telpilote']);
    $salpilote = mysqli_real_escape_string($conn, $_POST['salpilote']);
    $dnaisspilote = mysqli_real_escape_string($conn, $_POST['dnaisspilote']);

    // Cette variable trylogin permet de vérifier si l'utilisateur est actuellement entrain d'essayer de se connecter 
    // afin d'afficher le pop-up
    // echo "<script>alert('chill')</script>";


    // Gestion du fichier images (extension et taille) pour l'illustration du pil :

    $typesAllowed = ['jpg', 'png', 'jpeg'];
    $fileExt = explode('.', $_FILES['profileImage']['name']);
    $fileActualExt = strtolower(end($fileExt));


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

        if ($_FILES['profileImage']['size'] > 500000) {
            $msg = "<div class='alert alert-danger'>Oops, la taille (kbits) de l'image est trop élevée.</div>";
        } else {

            $profileImageName = time() . '_' . $_FILES['profileImage']['name'];
            $target = '../images/' . $profileImageName;
            $sqlQuery = "UPDATE pilote SET image='{$profileImageName}' WHERE idpil='{$_GET['id']}'";
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target)) {

                //Create a SQL Query to Update Admin



                $sqlupdate = "UPDATE pilote SET
                nompil = '{$nompilote}',
                dnaiss = '{$dnaisspilote}',
                adr = '{$adrpilote}',
                tel = '{$telpilote}',
                sal = '{$salpilote}'
                WHERE idpil='{$_GET['id']}'
                ";


                    //Execute the Query
                ;

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
            <?php foreach ($pils as $pil) {
                if ($pil['idpil'] === $_GET['id']) {
            ?>
                    <h1>Modifiez les informations du pilote nommé <?= $pil['nompil'] ?> en remplissant le formulaire ci-dessous :</h1>
                    <?= $msg ?>
                    <form action="" method="POST" id="form" class="modal-form" enctype="multipart/form-data">
                        <div class="form-validation">
                            <label for="">Image d'illustration: </label>
                            <input type="file" name="profileImage" id="fileInput">
                        </div>
                        <div class="form-validation">
                            <label for="">Nom pilote : </label>
                            <input type="text" class="modal-input" id="nompil" name="nompilote" value=<?= $pil['nompil'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Adresse : </label>
                            <input type="text" class="modal-input" name="adrpilote" value=<?= $pil['adr'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">No téléphone : </label>
                            <input type="text" class="modal-input" name="telpilote" value=<?= $pil['tel'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Salaire (en XOF): </label>
                            <input type="number" class="modal-input" name="salpilote" value=<?= $pil['sal'] ?> required />
                        </div>
                        <div class="form-validation">
                            <label for="">Date (non formatée) : </label>
                            <input type="date" class="modal-input" name="dnaisspilote" value=<?= $pil['dnaiss'] ?> required />
                        </div>
                        <input type="submit" name="submitedit" value="Modifier" class="modal-input-btn highlight-btn" />
                        <br />
                    </form>
                    <span>
                        Pour avoir un aperçu des modifications ou de l'ajout, vous pourrez retourner consulter la page de la liste des pilotes
                        en appuyant <a href="listepils.php">ici !</a>
                    </span>
        </div>
<?php }
            }
?>
    </div>
</section>

<?php include('./front-components/footer.php') ?>