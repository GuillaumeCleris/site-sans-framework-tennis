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

  // connexion à la base de données
  include("connexion_bd.php");
  $bdd = connect();
  include("getters.php");
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>WIImblEdon</title>
    <link rel="stylesheet" href="style.css"  />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="fonction.js"></script>
  </head>

  <body>
    <?php include("menu_bar.php"); ?>

    <article>
      <h1>Formulaire d'inscription</h1>

      <form method="post" action="">
        <fieldset>
          <p class="style-formulaire">
            <label for="nom">Nom</label><br>
            <input type="text" id="nom" name="nom" pattern="[a-zA-ZÀ-ÿ-]{2,30}$" title="alphabet requis" required><br>
            <label for="prenom">Prenom</label><br>
            <input type="text" id="prenom" name="prenom" pattern="[a-zA-ZÀ-ÿ-]{2,30}$" title="alphabet requis" required><br>
            <label for="naissance">Date de naissance</label><br>
            <input type="date" id="naissance" name="naissance" required><br>
            <label for="adresse">Adresse</label><br>
            <input type="text" id="adresse" name="adresse" required><br>
            <label for="mail">Adresse mail</label><br>
            <input type="email" id="mail" name="mail" maxlength="30" placeholder="Ce sera votre identifiant" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$" required><br>
            <label for="nvmdp">Mot de passe</label><br>
            <input type="password" id="nvmdp" name="nvmdp" placeholder="Maximum 30 caractères" minlength="8"  maxlength="30" required>
            <br>
      <?php
              if(isset($_POST['inscrire'])){
                include("inscription_process.php");
                echo $message;
                unset($_POST);
              }
            ?>
    <br>
            <button type="submit" name="inscrire">Envoyer</button>
            <br>
          </p>
        </fieldset>  
      </form>
    </article>

    <?php include("pieds_de_page.php");?>
    
  </body>
</html>