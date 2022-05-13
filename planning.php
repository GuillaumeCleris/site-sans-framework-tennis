<?php 
//test d'existence d'une session connectée
session_start();

// connexion à la base de données
include("connexion_bd.php");
$bdd = connect();

//inclusion du fichier pour les guetters
include("getters.php");

//On test les variables globales de connecter et du type connexion 
if(!isset($_SESSION['id_mail']) or empty($_SESSION['id_mail'])){
  $_SESSION["connecter"]="non";
}
else{
  $mail=$_SESSION['id_mail'];
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
      <h1>Tableau de réservation</h1>

      <!--Affichage de la barre de menu en fonction de l'état connecté-->
      <?php 
      include("menu_bar.php");
      ?>

      <!--Affichage du planning des réservations-->
      <?php 
      include("template_planning.php");
      ?>
       
      <!--Affichage des boutons connexion/inscription ou du formulaire de réservation en fonction de l'état connecté-->
      <?php 
      if($_SESSION["connecter"]=="non"){
      ?>
        <div class="center">
          <button onclick="location.href='connexion.php'">Connexion</button>
          <button onclick="location.href='inscription.php'">Inscription</button>
       </div> 
       <?php
      }
      else if ($_SESSION["typeConnexion"]=='adherent' || ($_SESSION["typeConnexion"]=='arbitre' && is_moderator($mail))) { ?>

          <div class="center">
            <?php //les formulaires apparaissent et disparaissent en fonction de l'un et l'autre suite à l'appuie sur un des deux boutons ?>
            <button type="button" onclick="disparaitre(document.getElementById('formulaireAnnulation'));apparaitre(document.getElementById('formulaireReservation'))">Réservation</button>
            <button type="button" onclick="disparaitre(document.getElementById('formulaireReservation'));apparaitre(document.getElementById('formulaireAnnulation'))">Annulation</button>
          </div>
          <?php
          include("formulaire_reservation.php");
          include("formulaire_annulation.php");
      }
      ?>
      <?php include("pieds_de_page.php");?>
    </article>
  </body>
</html>