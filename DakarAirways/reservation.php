<?php include('./front-components/navbar.php');
$message = " ";
if (!isset($_SESSION['SESSION_MAIL'])) {
    header('location: index.php?cantbook');
    die;
}

// On récupère les informations du client :

$query = "SELECT * FROM users WHERE email='{$_SESSION['SESSION_MAIL']}'";
$result = mysqli_query($conn, $query);
$client = mysqli_fetch_assoc($result);

if (!isset($_GET['id']) || mysqli_num_rows(mysqli_query($conn, "SELECT * FROM vol WHERE idvol='{$_GET['id']}'")) === 0) {
    header('location: vols.php?cantbook');
}
// On récupère les informations du vol :

$query_vols = "SELECT * FROM vol WHERE idvol='{$_GET['id']}'";
$result_vols = mysqli_query($conn, $query_vols);
$vol = mysqli_fetch_assoc($result_vols);
$myRandomString = generateRandomString(5);

if (isset($_POST['submit_booking'])) {

    // echo "submitted !";
    // On créee les variables correspondant aux informations à récolter

    $idclient = mysqli_real_escape_string($conn, $client['id']);
    $idvol = mysqli_real_escape_string($conn, $_GET['id']);
    $code = generateRandomString(3) . "-" . generateRandomString(3) . "-" . generateRandomString(3);
    $nbplaces = $_POST['nbplaces'];
    $tarif = $vol['prix'] * $nbplaces;

    // On teste si le formulaire a été rempli correctement :
    if (empty($nbplaces)) {
        $message = "<div class='alert alert-danger'>Oops ! il faut d'abord remplir TOUT le formulaire :/</div>";
    }
    // echo $email;
    // On vérifie si les identifiants entrés dans le formulaire correspondent à un compte dans la base de données :

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE id='{$idclient}'")) === 1) {

        //2. SCréation de la requête SQL :
        $query_booked = "INSERT INTO reservations SET 
                id_client='$idclient',
                id_vol='$idvol',
                ticket='$code',
                places='$nbplaces',
                tarif='$tarif'
            ";

        //3. Execution de la requête SQL :
        $res = mysqli_query($conn, $query_booked);
        if ($res == TRUE) {
            // Réservation validée
            header("location: dashboard.php?bookeddone");
        } else {
            $message = "<div class='alert alert-danger'>Oops ! quelque chose s'est mal passé, veuillez réessayer :/</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Oops ! quelque chose s'est mal passé, veuillez réessayer :/</div>";
    }
}
?>


<main>

    <section class="home-booking" id="home-booking">
        <div class="wrapper">
            <div class="content-left">
                <img src="./images/booking_1.svg" alt="">
            </div>
            <div class="content-right">
                <form action="" method="POST" id="form" class="modal-form">
                    <?= $message ?>
                    <div class="form-validation">
                        <label for="eco">Nom du vol :</label>
                        <input type="text" class="modal-input frozenInput" name="fly_name" placeholder="id du vol" value=<?php echo $vol['villedep'] . "-" . $vol['villearr'] ?> />
                    </div>
                    <div class="form-validation">
                        <label for="eco">Pseudo du réserveur :</label>
                        <input type="text" class="modal-input frozenInput" name="booker_name" placeholder="id du vol" value=<?php echo $client['name'] ?> />
                    </div>
                    <div class="form-validation">
                        <label for="eco">Prix d'une place à l'unité :</label>
                        <input type="text" class="modal-input frozenInput" name="fly_price" placeholder="id du vol" value=<?php echo $vol['prix'] . "XOF" ?> />
                    </div>
                    <div class="form-validation">
                        <!-- Ici on utilise deux champs fantômes remplies par l'id du client et l'id du vol afin de les utiliser comme clés étrangères, elles seront cachées de la page. -->
                        <input type="" class="modal-input" style="display:none;" id="id_client frozenInput" name="id_client" placeholder="id du client" value=<?php echo $client['id'] ?> />
                        <input type="number" class="modal-input" style="display:none;" id="id_vol frozenInput" name="id_vol" placeholder="id du vol" value=<?php echo $_GET['id'] ?> />
                    </div>
                    <div class="form-validation">
                        <label for="eco">Nb de places à réserver :</label>
                        <input type="number" min="0" max="55" class="modal-input" name="nbplaces" placeholder="55 max" />
                    </div>
                    <input type="submit" name="submit_booking" value="Confirmer la réservation" class="modal-input-btn highlight-btn" />
                    <br />
                </form>
            </div>
        </div>
    </section>

    <script>
        // Ce petit script permet de geler les inputs qui ne sont pas censés être modifiés.
        const frozenInput = document.querySelectorAll(".frozenInput");
        frozenInput.forEach((input) => {
            input.disabled = true;
        })
    </script>

    <?php include('./front-components/footer.php') ?>