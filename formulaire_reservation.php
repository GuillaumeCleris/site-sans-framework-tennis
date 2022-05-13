<?php
  $req = $bdd->prepare("select adresse_mail, prenom, nom from adherents;");
  $req -> execute();
  $tableau_joueurs = $req->fetchAll();
  $nb_joueurs = count(array_column($tableau_joueurs, 'adresse_mail'));
?>

<div class="Popup" id="popup_reservation"> 
</div>



<div class="style-formulaire" id="formulaireReservation" style="display:none">
  <form action="" method="post">
      <fieldset>
        <p>
          <label for="court">Court :</label><br/>
          <select name="court" id="court">
              <?php 
              for($c=0; $c<2;$c++){
                echo '<option value="' .$court[$c]. '">'.$court[$c].'</option>';
              }?>
          </select>
          <br/><br/>
          <label for="jour">Jour :</label><br/>
          <select name="jour" id="jour">
            <?php 
            for($i=0; $i<7;$i++){
              if($sem_sql[$i]<=$date_max && $sem_sql[$i] >= $date_min ){
                echo '<option value="'.$i. '">'.$sem_affichage[$i].'</option>';
              }
            } ?>

          </select>
          <br/><br/>
          <label for="heure">Heure :</label><br/>
          <select name="heure" id="heure">
            <?php 
            for($h=8; $h<17;$h++){
              echo '<option value="' .$h. '">'.$h.'h'.'</option>';
            }?>
          </select>
          <br/><br/>
          <?php 
          if ($typeConnexion=="arbitre") { ?>
            <label for="mail1">Joueur 1 :</label><br/>
            <select name="mail1" id="mail1">
              <?php 
              for($i=0; $i<$nb_joueurs;$i++){
                echo '<option value="' .$tableau_joueurs[$i][0]. '">'.$tableau_joueurs[$i][1].' '.$tableau_joueurs[$i][2].'</option>';
              }?>
            </select>
            <br/><br/>
            <?php
          } ?>
          <label for="mail2">Adversaire :</label><br/>
          <select name="mail2" id="mail2">
            <?php 
            for($i=0; $i<$nb_joueurs;$i++){
              echo '<option value="' .$tableau_joueurs[$i][0]. '">'.$tableau_joueurs[$i][1].' '.$tableau_joueurs[$i][2].'</option>';
            }?>
          </select>
          <br/>
          <button type="reset" onclick="disparaitre(document.getElementById('formulaireReservation'))">Annuler</button>
          <button type="submit" name="reservation" value="reserver">Confirmer</button>
         </p>
      </fieldset>
      
  </form>
</div>

<?php
if(isset($_POST['reservation'])){
  include("reservation_process.php");
  unset($_POST);
}
?>


