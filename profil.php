<?php 
  //test d'existence d'une session connectée et différenciation adhérent/arbitre
  session_start();

  include('getters.php');
  
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
    <h1>Mon profil</h1>

    <?php 
    include("menu_bar.php");

    if($_SESSION["connecter"]=="non"){
      ?>
      <div class="center">
        <button onclick="location.href='connexion.php'">Connexion</button>
        <button onclick="location.href='inscription.php'">Inscription</button>
      </div> 
     <?php
    }
    else{
      $id = $_SESSION['id_mail'];
      include("connexion_bd.php");
      $bdd = connect();
        ?>
        <div class="informations-personnelles">
          <?php 
          if ($typeConnexion == "arbitre"){ ?>
            <div class = "infos">
              <div class="categories">
                <p>
                  Identifiant : &nbsp <br>
                  Nom : &nbsp <br>
                  Prénom : &nbsp <br>
                  Date de naissance :  &nbsp <br>
                  Adresse mail :  &nbsp <br>
                </p>
              </div>
              <div class="valeurs">
                <p>
                  <mark><?php echo getIdById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getNameById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getFirstnameById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getBirthDateById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo $id; ?></mark>
                </p>
              </div>
            </div>
          <?php
          }
          else {?>
            <div class = "infos">
              <div class="categories">
                <p>
                  Identifiant : &nbsp <br>
                  Nom : &nbsp <br>
                  Prénom : &nbsp <br>
                  Date de naissance :  &nbsp <br>
                  Adresse :  &nbsp <br>
                  Adresse mail :  &nbsp <br>
                </p>
              </div>
              <div class="valeurs">
                <p>
                  <mark><?php echo getIdById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getNameById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getFirstnameById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getBirthDateById($id, $typeConnexion); ?></mark><br>
                  <mark><?php echo getAddressById($id); ?></mark><br>
                  <mark><?php echo $id; ?></mark>
                </p>
              </div>
            </div>
            <a href="desinscription.php">Se désinscrire</a>
          <?php
          }
          ?>

          <p>
            <button onclick="disparaitre(document.getElementById('formulaireModificationMdp'));apparaitre(document.getElementById('formulaireModificationMail'))">Modifier mon adresse mail</button>
            <button onclick="disparaitre(document.getElementById('formulaireModificationMail'));apparaitre(document.getElementById('formulaireModificationMdp'))">Modifier mon mot de passe</button>
          </p>

          <div id="formulaireModificationMail" style="display:none">
            <form action="" method="post">
                <p class="style-formulaire">
                  <label for="nvid">Nouvelle adresse mail :</label><br>
                  <input type="email" id="nvid" name="nvid" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$" required><br>
                  <label for="idconfirmation">Confirmation :</label><br>
                  <input type="email" id="idconfirmation" name="idconfirmation" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$" required><br><br>
                  <button type="reset" onclick="disparaitre(document.getElementById('formulaireModificationMail'))">Annuler</button>
                  <button type="submit" name="modifier_profil">Confirmer</button>
                </p> 
            </form>
          </div>

          <div id="formulaireModificationMdp" style="display:none">
            <form action="" method="post">
              <p class="style-formulaire">
                <label for="nvmdp">Nouveau mot de passe :</label><br>
                <input type="password" id="nvmdp" name="nvmdp" required><br>
                <label for="mdpconfirmation">Confirmation</label><br>
                <input type="password" id="mdpconfirmation" name="mdpconfirmation" required><br><br>
                <button type="reset" onclick="disparaitre(document.getElementById('formulaireModificationMdp'))">Annuler</button>
                <button type="submit" name="modifier_profil">Confirmer</button>
              </p>
            </form>
          </div>

        </div>
        <?php
        if(isset($_POST['modifier_profil'])){
          include("profil_process.php");
          unset($_POST);
        }
    }
    include("pieds_de_page.php"); ?>
    </article>
  </body>
</html>