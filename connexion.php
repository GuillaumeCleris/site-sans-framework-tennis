<?php 
//test d'existence d'une session connectée
  session_start();

  // connexion à la base de données
  include("connexion_bd.php");
  $bdd = connect();
  include("getters.php");
  $_SESSION["typeConnexion"]="";
  $_SESSION["id"]="";
  $_SESSION["connecter"]="non";
  

 
?>

<?php
 
  
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
    <?php include("menu_bar.php"); ?>

    <article>
      <h1>Connexion</h1>
      <p>
        Connectez-vous en utilisant l'email avec lequel vous vous êtes inscrit
      </p>

      <!--Formulaire de connexion-->
      <div>
        <form  method="post" action="">
          <fieldset>
            <p class="style-formulaire">
              <label for="adresse_mail">Adresse Mail</label><br/>
              <input type="email" id="adresse_mail" name="adresse_mail" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$" required><br>
              <label for="motDePasse">Mot de passe</label><br/>
              <input type="password" id="motDePasse" name="motDePasse" required><br/>
              Connexion en tant que:<br/><br/>
              <input type="radio" id="adherent" name="typeConnexion" value="adherent" checked="checked"/>
              <label for="adherent">Adhérent</label>
              <input type="radio" id="arbitre" name="typeConnexion" value="arbitre"/>
              <label for="arbitre">Arbitre</label><br/>
              <?php
                if(isset($_POST['valider'])){
                  include("connect_process.php");
                  if ($message !=''){
                    echo $message;
                  }
                  unset($_POST);
                }
              ?>
              <br/>
              <button type="submit" name="valider" value="Connexion"> Connexion </button>             
              <br/>
            </p>
          </fieldset>          
        </form> 

        <p>
          Pas encore de compte ?<br/>
          <a class="white-link" href="inscription.php">Inscrivez-vous</a>
        </p>
      </div>
    </article>


    <?php
    include("pieds_de_page.php");?>
  </body>
</html>