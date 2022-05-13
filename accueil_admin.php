<?php 
  //test d'existence d'une session connectée
  session_start();
  
  if(!isset($_SESSION['id_mail_admin']) or empty($_SESSION['id_mail_admin'])){
    $_SESSION["connecter_admin"]="non";
  }
  else {
    include("connexion_bd.php");
    $bdd = connect();
    include('getters.php');
    $id_mail_admin = $_SESSION['id_mail_admin'];
    $identite = get_prenom_nom($id_mail_admin,'administrateur');
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
    include("menu_bar_admin.php");
    
    if($_SESSION["connecter_admin"]=="non"){
        ?>
        <div class="Popup" id="accueil_admin"> 
            <div class='Popupencart'>
                <p> Veuillez vous connecter en tant qu'administrateur </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('accueil_admin'),'connexion_admin.php'); 
        </script>
        <?php
    } 

    else {
      ?>
      <article>
        <h1><?php echo 'Bonjour '.$identite.' !'; ?></h1>
        <div class="icones-accueil">
          <ul>
            <li>
              <a href=gestion_adherent.php><i class="fa fa-user-times" aria-hidden="true"></i>Gérer les comptes adhérents</a>
            </li>
            <li>
              <a href=gestion_tournoi.php><i class="fa fa-trophy" aria-hidden="true"></i>Gérer un tournoi en cours</a>
            </li>
            <li>
              <a href=gestion_arbitre.php><i class="fa fa-users" aria-hidden="true"></i>Gérer les comptes arbitres</a>
            </li>
          </ul>
        </div> 
      </article>
      <?php
    }

    include("pieds_de_page.php");
    ?>
  </body>
</html>