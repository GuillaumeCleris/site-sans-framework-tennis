<?php 
//test d'existence d'une session connectée
session_start();

// connexion à la base de données
include("connexion_bd.php");
$bdd = connect();

//inclusion du fichier pour les guetters
include("getters.php");

//On récupère l'état du tournoi du dernier tournoi crée = {'inscription','en cours','termniné',''}
$etatDuTournoi=get_tournament_state();

//On test les variables globales de connecter et du type connexion 
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

    <!--Affichage de la barre de menu en fonction de l'état connecté-->
    <?php 
    //include("template_inscrit_tournoi.php");
    include("menu_bar.php");
    ?>

    <?php
    if($_SESSION["connecter"]=="non"){
      if($etatDuTournoi=="inscription"){
        include("template_inscrit_tournoi.php");
        echo '<br/>';
      }
      else if($etatDuTournoi=="en cours"){
        ?>
        <h1>Tableau du tournoi en cours</h1>
        <?php
        include("template_tournoi.php");
        echo '<br/>';
      }
      else if($etatDuTournoi=="terminé"){
        ?>
        <h1>Tableau du tournoi terminé</h1>
        <?php
        include("template_tournoi.php");
        echo '<br/>';
        }
      }
    ?>

    <!-- Affichage pour un adherent -->
    <?php
    if($typeConnexion=="adherent"){

      //Si le tournoi précédent est terminé, on affiche le template du tournoi terminé 
      if($etatDuTournoi=="terminé"){
        ?>
        <h1>Tableau du tournoi terminé</h1>
        <?php
        include("template_tournoi.php");
      }
      
      //Si le tournoi est en phase d'inscription on affiche le template des inscrits et l'adhérent peut s'inscrire/se désinscrire du tournoi
      else if($etatDuTournoi=="inscription"){
        
        //On test si l'adhérent est inscrit ou non grâce à $bool égal à false s'il est déja inscrit ou à true s'il n'est pas inscrit
        $reponse = $bdd->prepare("select * from inscrits as i natural join tournois as t where t.num=i.num and situation ='inscription'");
        $reponse -> execute();
        $donnees = $reponse ->fetchAll();
        $compteur=count(array_column($donnees, 'mail'));
        $i=0;

        $bool=true;
        while($i<$compteur && $bool) {
            $resemail = $donnees[$i]['mail'];
            if ($resemail==$_SESSION['id_mail']) {
                $bool=false;
            }
            $i++;
        }

        //On récupère le numéro du tournoi
        $num_tournoi = get_last_num_tournoi();

        //On affiche les inscrits actuels pour le tournoi
        include("template_inscrit_tournoi.php");
        
        //Si l'adhérent n'est pas inscrit et que le tournoi n'est pas plein alors il peut s'inscrire
        if($bool && get_nombre_inscrit($num_tournoi)<get_nombre_max_tournoi($num_tournoi)){
          ?>
          <form action="" method="post">
              <button type="submit" name="valider_inscription" value="valider_inscription">Cliquez-ici pour vous inscrire</button>
        
          </form>
          <?php
          //On inclut le process si le formulaire a été envoyé
          if(isset($_POST['valider_inscription'])){
            include("tournoi_inscription_process.php");
            //On supprime les variables post après utilisation
            unset($_POST);
          }
        }

        //Si l'adhérent est inscrit alors il peut se désinscrire
        else if(!$bool){
          ?>
          <form action="" method="post">
              <button type="submit" name="valider_desinscription" value="valider_desinscription">Cliquez-ici pour vous désinscrire</button>
          </form>
          <?php
          //On inclut le process si le formulaire a été envoyé
          if(isset($_POST['valider_desinscription'])){
            include("tournoi_annulation_process.php");
            //On supprime les variables post après utilisation
            unset($_POST);
          }
        }      
      }

      //Si le tournoi est en cours on affiche le tournoi
      else if ($etatDuTournoi=="en cours") { 
        ?>
        <h1>Tableau du tournoi en cours</h1>
        <?php
        include("template_tournoi.php");
      }
    }
    ?>

    <!-- Affichage pour un arbitre -->
    <?php
    if($typeConnexion=="arbitre"){

      //Si le tournoi est en phase d'inscription
      if($etatDuTournoi=="inscription"){
        
        //On affiche le template des inscrits
        include("template_inscrit_tournoi.php");

        //Les arbitres modérateurs peuvent cloturer le tournoi si la taille est supérieure à 5
        if(is_moderator($_SESSION['id_mail']) && get_nombre_inscrit(get_last_num_tournoi())>=5){
          ?>
          <form action="" method="post">
            <button type="submit" name="clore_inscription" value="clore_inscription">Clore les inscriptions</button>
          </form>
          <?php

          //On inclut le process si le formulaire a été envoyé
          if(isset($_POST['clore_inscription'])){
            include("tournoi_fin_inscription_process.php");

            //On supprime les variables post après utilisation
            unset($_POST);
          }
        }

      }

      //Si le tournoi est en cours 
      else if ($etatDuTournoi=="en cours") { 
        //On affiche le tournoi
        ?>
        <h1>Tableau du tournoi en cours</h1>
        <?php
        include("template_tournoi.php");

        //Si l'arbitre connecté est modérateur on affiche le formulaire pour ajouter les vainqueurs de chaque match
        if(is_moderator($_SESSION['id_mail'])){
          include("formulaire_vainqueur_tournoi.php");
        }
      }

      //Si le tournoi est terminé ou qu'il n'y a aucun tournoi dans la base de donnée
      else {

        //L'arbitre peut crée un tournoi grâce au formulaire
        include("formulaire_creation_tournoi.php");

        //Si le tournoi est terminé
        if ($etatDuTournoi=="terminé") { 
          
          //On affiche le tournoi terminé
          ?>
          <h1>Tableau du tournoi terminé</h1>
          <?php
          include("template_tournoi.php");
        }
      }
    }
    ?>
   
    <!-- On inclut le pieds_de_page -->
    <?php 
    include("pieds_de_page.php");
    ?>
    </article>
  </body>
</html>