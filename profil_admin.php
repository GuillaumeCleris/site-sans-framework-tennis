<?php 
  //test d'existence d'une session connectée
  session_start();
  
  include('getters.php');
  
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
    <article>
      <h1>Mon profil</h1>
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
        $id = $_SESSION['id_mail_admin'];
        include("connexion_bd.php");
        $bdd = connect();
        ?>
        <div class="informations-personnelles">
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
                <mark><?php echo getIdById($id, "administrateur"); ?></mark><br>
                <mark><?php echo getNameById($id, "administrateur"); ?></mark><br>
                <mark><?php echo getFirstnameById($id, "administrateur"); ?></mark><br>
                <mark><?php echo getBirthDateById($id, "administrateur"); ?></mark><br>
                <mark><?php echo $id; ?></mark>
              </p>
            </div>
          </div>

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
                  <button type="submit" name="modifier_profil_admin">Confirmer</button>
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
                <button type="submit" name="modifier_profil_admin">Confirmer</button>
              </p>  
            </form>
          </div>

        </div>
        <?php
        if(isset($_POST['modifier_profil_admin'])){
          include("profil_admin_process.php");
          unset($_POST);
        }
      }
      include("pieds_de_page.php");
      ?>
    </article>
  </body>
</html>