<?php 
//test d'existence d'une session connectée
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
    <article>
    <h1>Mon palmarès</h1>

    <!--Affichage de la barre de menu en fonction de l'état connecté-->
    <?php 
    include("menu_bar.php");

    if($_SESSION["connecter"]=="non"){
      ?>
      <div class="center">
        <button onclick="location.href='connexion.php'">Connexion</button>
        <button onclick="location.href='inscription.php'">Inscription</button>
      </div> 
     <?php
      include("pieds_de_page.php");
    }
    else{
      $id = $_SESSION['id_mail'];
      include("connexion_bd.php");
      $bdd = connect();
      include("template_palmares.php");
    }
    include("pieds_de_page.php"); ?>
    </article>
  </body>
</html>