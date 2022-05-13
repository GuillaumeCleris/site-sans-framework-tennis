<?php 
  session_start();
  include("connexion_bd.php");
  $bdd = connect();
  if(!isset($_SESSION['id_mail_admin']) or empty($_SESSION['id_mail_admin'])){
    $_SESSION["connecter_admin"]="non";
  }
?> 
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>WIImblEdon</title>
    <link rel="stylesheet" href="style.css" />
    <script src="fonction.js"></script>
  </head>

  <body>
    <?php include("menu_bar_admin.php"); ?>

    <article>
      <h1>Connexion</h1>
      <p>
        Connectez-vous en utilisant l'email administrateur
      </p>

      <!--Formulaire de connexion-->
      <div>
        <form  method="post" action="">
          <fieldset>
            <p class="style-formulaire">
              <label for="identifiant">Adresse Mail</label><br>
              <input type="email" id="identifiant" name="identifiant" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$" required><br>
              <label for="motDePasse">Mot de passe</label><br>
              <input type="password" id="motDePasse" name="motDePasse" required><br>
              <button type="submit" name="connecter_admin">Connexion</button>
              <br>
              <?php
                if(isset($_POST['connecter_admin'])){
                  include("connect_admin_process.php");
                  echo $message;
                  unset($_POST);
                }
              ?>
              <br/>
            </p>
          </fieldset>
        </form> 
        </br>
        <p>
          <a class="white-link" href="accueil.php">Site principal</a> 
        </p>
      </div>
    </article>

    <?php include("pieds_de_page.php");?>
  </body>
</html>