<?php 
//test d'existence d'une session connectée pour la barre de menu
  session_start();

  $typeConnexion=""; 
  if(!isset($_SESSION['id_mail']) or empty($_SESSION['id_mail'])){
    $_SESSION["connecter"]="non";
  }
  else{
    if($_SESSION["typeConnexion"]=="arbitre"){
      $typeConnexion="arbitre";
    }
    else{
      $typeConnexion="adherent";
    }
  }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>WIImblEdon</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="fonction.js"></script>
  </head>
    
  <body>
    <?php 
    include("menu_bar.php");
    ?>
    <article>

      <h1>Le club</h1>

      <div class="encart" style="height:575px">

        <p style="text-align: center; color:black">Le club de Tennis d'Evry-Courcouronnes met à disposition des étudiants deux terrains de tennis. Vous pouvez visualiser les créneaux horaires disponibles via l'onglet planning situé ci-dessus. Une carte étudiante vous sera demandée lors de l'accueil au club. Voici quelques images du club de tennis.<br></p>
        
        <div class="diaporama-div">

          <!-- Classe des images -->
          <div class="slide fade">
            <div class="numero-slide">1 / 5</div>
            <img src="small_terrain.png" class="img-slide">
          </div>

          <div class="slide fade">
            <div class="numero-slide">2 / 5</div>
            <img src="terrain2.png" class="img-slide">
          </div>

          <div class="slide fade">
            <div class="numero-slide">3 / 5</div>
            <img src="long_club.png" class="img-slide">
          </div>

          <div class="slide fade">
            <div class="numero-slide">4 / 5</div>
            <img src="courts.JPG" class="img-slide">
          </div>

          <div class="slide fade">
            <div class="numero-slide">5 / 5</div>
            <img src="autre_vue.jpg" class="img-slide">
          </div>

          <!-- Boutons précédent/suivant -->
          <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
          <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <!-- Petits points -->
        <div style="text-align:center">
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>


        <script>
        var slideIndex = 1;
        showSlides(slideIndex);
        </script>

      </div>

      <!--Affichage des boutons connexion/inscription si absence de connexion-->
      <?php 
      if($_SESSION["connecter"]=="non"){
      ?>
        <div class="center">
          <button onclick="location.href='connexion.php'">Connexion</button>
          <button onclick="location.href='inscription.php'">Inscription</button>
        </div> 
      <?php
      }
      ?>
    </article>

    <?php include("pieds_de_page.php");?>

  </body>
</html>