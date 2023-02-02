<?php
include('./front-components/navbar.php');

// session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_SESSION['SESSION_MAIL'])) {
    header('location: index.php!?loggedin');
}

if (isset($_POST['submit_register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name_register']);
    $email = mysqli_real_escape_string($conn, $_POST['email_register']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password_register']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password_register']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'> Cet email ({$email}) a déjà été pris !</div>";
    } else {
        if ($password === $confirm_password) {
            $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
            $result = mysqli_query($conn, $sql);

            // echo mysqli_error($conn);

            if ($result) {
                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'alamine2902@gmail.com';                     //SMTP username
                    $mail->Password   = 'babacare98-';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('alamine2902@gmail.com');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body    = 'Voici votre lien de vérification <b><a href="http://localhost/ProjetMysql_PHP/DakarAirways/index.php?trylogin&verification=' . $code . '">http://localhost/ProjetMysql_PHP/DakarAirways/index.php?trylogin&verification=' . $code . '</a></b>';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";
                $msg = "<div class='alert alert-info'>Nous avons envoyé un code sur votre email, veuillez vérifier votre compte en appuyant"  . '<a href="http://localhost/ProjetMysql_PHP/DakarAirways/index.php?trylogin&verification=' . $code . '"> ici ! <a/></div>';
            } else {
                $msg = "<div class='alert alert-danger'> Oops, quelque chose a mal tourné, <br>veuillez réessayer :/</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Oops ! Les mots de passe ne correspondent pas ! </div>";
        }
    }

    // header('location: inscription.php?ez');
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
                    <?= $msg ?>
                    <div class="form-validation">
                        <input type="text" class="modal-input" id="name_register" name="name_register" placeholder="Entrez votre nom" required value=<?php if (isset($_POST['submit'])) echo $_POST['name']; ?>>
                    </div>
                    <div class="form-validation">
                        <input type="email" class="modal-input" id="email_register" name="email_register" placeholder="Entrez votre email" required value=<?php if (isset($_POST['submit'])) echo $_POST['email']; ?>>
                    </div>
                    <div class="form-validation">
                        <input type="password" class="modal-input" id="password_register" name="password_register" placeholder="Entrez votre mot de passe" required />
                    </div>
                    <div class="form-validation">
                        <input type="password" class="modal-input" id="password_register" name="confirm-password_register" placeholder="Confirmez votre mot de passe" />
                    </div>
                    <input type="submit" value="S'inscrire" name="submit_register" class="modal-input-btn highlight-btn" />
                    <br />
                </form>
            </div>
        </div>
    </section>


    <?php include('./front-components/footer.php') ?>