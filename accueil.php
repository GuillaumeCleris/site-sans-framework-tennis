<?php 
  //test d'existence d'une session connectée
  session_start();

  include("connexion_bd.php");
  $bdd = connect();
  include("getters.php");
  $etatDuTournoi=get_tournament_state();

  $typeConnexion = "";
  if(isset($_SESSION['typeConnexion'])){
    $typeConnexion = $_SESSION["typeConnexion"];
  }

  if(!isset($_SESSION['id_mail']) or empty($_SESSION['id_mail'])){
    $_SESSION["connecter"]="non";
  }
  else{
    if($typeConnexion=="arbitre"){
      $prenom_nom = get_prenom_nom($_SESSION['id_mail'],'arbitre');
    }
    else if ($typeConnexion=="adherent"){
      $prenom_nom = get_prenom_nom($_SESSION['id_mail'],'adherent');
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
    <!--Affichage de la barre de menu en fonction de l'état connecté-->
    <?php 
    include("menu_bar.php");
    ?>
    <article>
      <h1 style="font-size:28px"> 
          <?php 
          if($_SESSION["connecter"]=="non"){ 
            echo 'Bienvenue !';
          } 
          else{ 
            echo 'Bienvenue '.$prenom_nom.' !';
          } 

      ?>
      </h1>

      <?php
      if($_SESSION["connecter"] == "non" || $typeConnexion == "adherent"){
        ?>
        <p class="bigger">
          Connectez-vous avec votre compte pour découvrir toutes les fonctionnalités du site.<br>
          Parmi les nombreux services accessibles, WIImblEdon vous permet de :
        </p> 
        <?php
      }
      ?>

      <div class="icones-accueil">
        <ul>
          <li>
            <a href=planning.php><i class="fa fa-table" aria-hidden="true"></i>Réserver des terrains</a>
          </li>
          <?php
          if($typeConnexion=="arbitre"){
            ?>
            <li>
              <a href=tournoi.php><i class="fa fa-trophy" aria-hidden="true"></i>Gérer un tournoi</a>
            </li>
            <?php
          }
          else { 
            ?>
            <li>
              <a href=tournoi.php><i class="fa fa-trophy" aria-hidden="true"></i>Participer à un tournoi</a>
            </li>
            <?php
          } ?>
          <li>
            <a href=classement.php><i class="fa fa-bar-chart" aria-hidden="true"></i>Consulter le classement</a>
          </li>
        </ul>
      </div> 
      <?php
        
      if($typeConnexion=="arbitre"){
        if($etatDuTournoi=="terminé"){
          ?>
          <div class="center">
            <button onclick="location.href='tournoi.php'">Créer un tournoi</button>
          </div> 
          <?php
        }
        else {
          ?>
          <div class="center">
            <button onclick="location.href='tournoi.php'">Tournoi en cours</button>
          </div> 
          <?php
        }
      }
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