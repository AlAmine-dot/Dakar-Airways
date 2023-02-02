<?php include("./front-components/navbar.php");


// if (isset($_SESSION['SESSION_MAIL'])) {
//   header('location: dashboard.php');
// }

?>
<!-- Main section -->

<main>
  <!-- Home section -->

  <section class="home" id="home">
    <?php
    if (isset($_SESSION['SESSION_MAIL'])) {
      $query = "SELECT * FROM users WHERE email='{$_SESSION['SESSION_MAIL']}'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);

      echo "<div class='alert alert-success' id='welcome'>Bienvenue " . $row['name'] . " :) </div>";
      // echo "<a href='logout.php'>Logout</a>";
    }

    if (isset($_GET['cantbook']) && !isset($_GET['loggedin'])) {
      echo "<div class='alert alert-danger' id='danger'>Vous devez être inscrit et connecté pour effectuer cette action !</div>";
    }
    if (isset($_GET['loggedin'])) {
      echo "<div class='alert alert-danger' id='dangerous'>Vous êtes déjà inscrit et connecté :p !</div>";
    }
    ?>
    <div class="swiper mySwiper container home-slider">
      <div class="swiper-wrapper wrapper">
        <div class="swiper-slide slide slide1">
          <div class="quotes quotes1">
            <h1>
              La vie est courte,<br />
              mais le monde est grand !
            </h1>
            <p>
              Avec la compagnie Dakar Airways, réservez des vols à tarifs
              exclusifs et parcourez le monde dans un luxe inégalable.
            </p>
          </div>

          <!-- On inclut le formulaire de recherche raccourci -->
          <?php include('./front-components/searchform-shortcut.php') ?>

        </div>
        <div class="swiper-slide slide slide2">
          <div class="quotes quotes2">
            <h1>Rëew mi njukël na leen</h1>
            <a href="vols.php" class="highlight-btn">Réservez maintenant ! </a>
          </div>
        </div>
        <div class="swiper-slide slide slide3">
          <div class="quotes quotes3">
            <h1>Envolée de Dakar vers le monde !</h1>
            <a href="vols.php" class="highlight-btn">Réservez maintenant ! </a>
          </div>
        </div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <!-- destinations section -->

  <section class="destinations" id="destinations">
    <h3 class="sub-heading">Nos destinations</h3>
    <h1 class="heading">Les plus populaires</h1>
    <?php
    // Requête SQL pour la liste des vols :
    // On n'affiche que les destinations ayant plus de 5 étoiles car elles sont les plus populaires
    $query_vols = mysqli_query($conn, "SELECT * FROM vol WHERE etoiles>=5");

    ?>
    <div class="cards-container">

      <div class="box-container">
        <?php
        $volspopulaires = mysqli_fetch_all($query_vols, MYSQLI_ASSOC);
        foreach ($volspopulaires as $volpopulaire) {
          echo "
          <div class='box'>
          <a href='#' class='fas fa-heart'></a>
          <a href='#' class='fas fa-eye'></a>
          <img src='images/".$volpopulaire['image']."' alt='' />
          <h3>" . $volpopulaire['villedep'] . " - " . $volpopulaire['villearr'] . " </h3>
          <div class='stars'>";

          // On insère le nombre d'étoiles obtenue par la destination selon la valeur
          // de la base de données (il n'y a pas de sections vote donc l'admin décide des valeurs)
          for ($i = 0; $i <= $volpopulaire['etoiles']; $i++) {

            echo "<i class='fas fa-star'></i>";
          }
          $idvol = $volpopulaire['idvol'];

          echo "
          <i class='fas fa-star-half-alt'></i>
          </div>
          <span> " . $volpopulaire['prix'] . " XOF </span>";

          // Avec le bouton, on retourne l'id du vol à la page reservation.php
          echo "<a href='reservation.php?id=" . $volpopulaire['idvol'] . "' class='btn'>Réserver</a>
          </div>
          ";
        }

        ?>
      </div>
      <a href="vols.php" class="btn">Voir plus...</a>
    </div>
  </section>

  <!-- About section -->

  <section class="about" id="about">
    <h3 class="sub-heading">À propos de Dakar Airways</h3>
    <h1 class="heading">Pourquoi nous choisir ?</h1>

    <div class="row">
      <div class="image">
        <img src="images/about-img.jpg" alt="" />
      </div>
      <div class="content">
        <h3>Meilleure compagnie du pays</h3>
        <p>
          Cette nouvelle compagnie aérienne nationale, Dakar Airways, est au
          coeur du Plan Sénégal Émergent avec pour ambition d’ériger un
          véritable hub aérien régional autour de l’Aéroport International
          Blaise Diagne.
        </p>
        <p>
          Profitez de l’hospitalité réputée du Sénégal grâce à Dakar Airways
          qui permet à chaque individu de voyager sur le réseau domestique
          et régional à des prix imbattables, un luxe inégalable et surtout
          un service fiable.
        </p>
        <div class="icons-container">
          <div class="icons">
            <i class="fa-solid fa-plane-circle-check"></i>
            <span>Fiability</span>
          </div>
          <div class="icons">
            <i class="fas fa-dollar-sign"></i>
            <span>Easy payment</span>
          </div>
          <div class="icons">
            <i class="fas fa-headset"></i>
            <span>24/7 service</span>
          </div>
        </div>
        <a href="" class="btn">En savoir plus</a>
      </div>
    </div>
  </section>

  <!-- Review section -->

  <section class="review" id="review">
    <h3 class="sub-heading">Avis des clients</h3>
    <h1 class="heading">Que disent-ils ?</h1>

    <div class="swiper mySwiper container review-slider">
      <div class="swiper-wrapper wrapper">
        <div class="swiper-slide slide">
          <i class="fas fa-quote-right"></i>
          <div class="user">
            <img src="images/mineta.jpeg" alt="" />
            <div class="user-info">
              <h3>Minéta l'ornithorynque</h3>
              <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
            </div>
          </div>
          <p>
            Ce site est parfait pour réserver des vols ! J'arrive à mener mes missions d'agent secret en toute discrétion
            jusqu'à présent, personne n'a pu trouver mon identité secrète... Oups :O
          </p>
        </div>

        <div class="swiper-slide slide">
          <i class="fas fa-quote-right"></i>
          <div class="user">
            <img src="images/review-2.jpg" alt="" />
            <div class="user-info">
              <h3>Eikichi Onizuka</h3>
              <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
              </div>
            </div>
          </div>
          <p>
            Je donne 5 étoiles et demis pour la qualité des sei.. euh des services de l'hotesse.
            Parcontre je me demande toujours où vont les excréments après qu'on aie tiré la chasse dans ces avions :/
          </p>
        </div>

        <div class="swiper-slide slide">
          <i class="fas fa-quote-right"></i>
          <div class="user">
            <img src="images/review-3.jfif" alt="" />
            <div class="user-info">
              <h3>Kelly</h3>
              <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
              </div>
            </div>
          </div>
          <p>
            J'adore le Sénégal ! Ce voyage était tout simplement fabuleux, j'ai découvert énormément de choses
            et rien que pour ça je donne 3 étoiles et demi ! Sinon trop stylé la restauration ! J'ai adoré le thiebou djeun
          </p>
        </div>

        <div class="swiper-slide slide">
          <i class="fas fa-quote-right"></i>
          <div class="user">
            <img src="images/review-4.jpg" alt="" />
            <div class="user-info">
              <h3>Papi William</h3>
              <div class="stars">
                <i class="fas fa-star-half-alt"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
              </div>
            </div>
          </div>
          <p>
            C'est quoi ces sites là hein ? Moi de mon époque on se déplaçait en charette et avec des navires.. hmpf, le monde n'est plus ce que c'était ! En 1930, lors de la révolution française, on a du prendre des bunkers nous !
          </p>
        </div>
      </div>
    </div>
  </section>

  <!--  newsletter section -->

  <section class="newsletter" id="newsletter">
    <h3 class="sub-heading">Inscrivez vous à notre newsletter</h3>
    <h1 class="heading">Rapide et gratuit</h1>

    <form action="">
      <div class="inputBox">
        <div class="input">
          <span>Votre prénom</span>
          <input type="text" placeholder="Entrez votre prénom" />
        </div>
      </div>
      <div class="inputBox">
        <div class="input">
          <span>Votre email</span>
          <input type="email" placeholder="Entrez votre email" />
        </div>
      </div>
      <div class="inputBox">
        <input type="submit" value="S'inscrire" class="highlight-btn" />
      </div>
    </form>
  </section>

  <!-- Footer section -->

  <?php include('./front-components/footer.php') ?>