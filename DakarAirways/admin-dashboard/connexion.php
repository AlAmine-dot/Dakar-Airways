<?php
include('./front-components/navbar.php');

if (isset($_GET['loginfirst'])) {
    $msg = "<div class='alert alert-danger'>Vous devez être connecté d'abord !</div>";
}


if (isset($_POST['submit'])) {
    // echo "submitted !";
    // On créee les variables email et mot de passe dès que le bouton " connexion " est triggered

    $identifiant = mysqli_real_escape_string($conn, $_POST['identifiant']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Cette variable trylogin permet de vérifier si l'utilisateur est actuellement entrain d'essayer de se connecter 
    // afin d'afficher le pop-up

    // echo $email;
    // On vérifie si les identifiants entrés dans le formulaire correspondent à un compte dans la base de données :

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM admin WHERE identifiant='{$identifiant}' AND password='{$password}'")) === 1) {
        $query = "SELECT * FROM admin WHERE identifiant='{$identifiant}' AND password='{$password}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        $_SESSION['SESSION_ID'] = $identifiant;
        header('location: index.php?loggedin');
        // echo "<script>
        // alert('chill');
        // </script>";
    } else {
        $msg = "<div class='alert alert-info'>Cet identifiant ou ce mot de passe n'existent pas !</div>";
    }
}

?>

<section class="dashboard-home" id="home-booking">
    <!-- Login form -->

    <div class="modal-content">
        <div class="modal-content-left">
            <img src="../images/login_svg.svg" alt="Spaceship image" id="modal-img" />
        </div>
        <div class="modal-content-right">
            <h1>Connectez vous en remplissant les informations ci-dessous !</h1>
            <?= $msg ?>
            <form action="" method="POST" id="form" class="modal-form">
                <div class="form-validation">
                    <input type="text" class="modal-input" id="email" name="identifiant" placeholder="Entrez votre identifiant admin" required />
                </div>
                <div class="form-validation">
                    <input type="password" class="modal-input" id="password" name="password" placeholder="Entrez votre mot de passe" />
                </div>
                <input type="submit" name="submit" value="Connexion" class="modal-input-btn highlight-btn" />
                <br />
            </form>
            <span>
                Le compte administrateur est donné par le gestionnaire base de données. Veuillez le contacter en cas de problèmes <br />
            </span>
        </div>
    </div>
</section>

<?php include('./front-components/footer.php') ?>