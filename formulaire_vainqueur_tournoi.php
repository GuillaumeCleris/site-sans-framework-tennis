<?php

//Si le premier formulaire a été rempli et confirmé
if (isset($_POST['match'])){
  //On récupère la réponse au formulaire 1 et on sépare la chaine de caractère pour récupérer : 
  //le numéro du tournoi / le numéro du match / le numéro du tour / le mail1 du joueur 1 et du joueur 2 ainsi que leur nom / prénom
  $match = $_POST['match'] ;
  $separation= explode(' ', $match);
  $num_tournoi=$separation[0];
  $num_match=$separation[1];
  $num_tour=$separation[2];
  $mail_j1=$separation[3];
  $j1 = $separation[4].' '.$separation[5];
  $mail_j2=$separation[7];
  $j2=$separation[8].' '.$separation[9];
}
?>

<div class='style_formulaire'>
<?php
  if (!isset($_POST['match'])){ ?>
    <form  action=""  method="post">
      <fieldset>
        <p> 
            <label for="match">Match :</label><br/>
              <select name="match" id="match">               
                  <?php 

                  for($i=0;$i<4;$i++){  //indice du jour de la semaine
                    $j_1=$joueur1[$i];
                    $j_2=$joueur2[$i];
                    $mail_1=$mail_joueur1[$i];
                    $mail_2=$mail_joueur2[$i];
                    $num_match = $i + 1;
                    $num_tour=1;
                    if ($joueur1[$i] != 'A definir' && $joueur2[$i] != 'A definir' && $tab_vainqueur[$i]=='A definir'){
                      echo '<option value="' . $num_tournoi.' '.$num_match.' '.$num_tour.' '.$mail_1.' '.$j_1.' contre '.$mail_2.' '.$j_2. '" >'.'Quart '.$j_1.' contre '.$j_2.'</option>';
                    }
                  }

                  for($i=4;$i<6;$i++){
                    $j_1=$joueur1[$i];
                    $j_2=$joueur2[$i];
                    $mail_1=$mail_joueur1[$i];
                    $mail_2=$mail_joueur2[$i];
                    $num_match = $i + 1;
                    $num_tour=2;
                    if ($joueur1[$i] != 'A definir' && $joueur2[$i] != 'A definir' && $tab_vainqueur[$i]=='A definir'){
                      echo '<option value="' . $num_tournoi.' '.$num_match.' '.$num_tour.' '.$mail_1.' '.$j_1.' contre '.$mail_2.' '.$j_2. '" >'.'Demi '.$j_1.' contre '.$j_2.'</option>';
                    }
                  }
                  $j_1=$joueur1[6];
                  $j_2=$joueur2[6];
                  $mail_1=$mail_joueur1[$i];
                  $mail_2=$mail_joueur2[$i];
                  $num_match = 6 + 1;
                  $num_tour=3;
                  if ($joueur1[$i] != 'A definir' && $joueur2[$i] != 'A definir' && $tab_vainqueur[6]=='A definir'){
                    echo '<option value="' . $num_tournoi.' '.$num_match.' '.$num_tour.' '.$mail_1.' '.$j_1.' contre '.$mail_2.' '.$j_2. '" >'.'Finale '.$j_1.' contre '.$j_2.'</option>';
                  }
                  ?>
              </select>
              </br>
              <button>Envoyer</button>
        </p>
      </fieldset>
    </form>
  
<?php 
  } 

  else{
    $tab_tour=array('du quart 1','du quart 2','du quart 3','du quart 4', 'de la demi 1', 'de la demi 2', 'de la finale');
    $etape=$tab_tour[$num_match - 1];
  ?>
    <form  action=""  method="post">
      <fieldset>
        <p> 
          <label for="vainqueur"><?php echo 'Vainqueur '.$etape.' '.$j1.' contre '.$j2. ' :';?></label><br/>
          <br/>
          <select name="vainqueur" id="vainqueur">
            <?php
            echo '<option value="' .$num_tournoi.' '.$num_match.' '.$num_tour.' '.$mail_j1.' '.$j1.' '.$mail_j2. '">'.$j1.'</option>'; 
            echo '<option value="' .$num_tournoi.' '.$num_match.' '.$num_tour.' '.$mail_j2.' '.$j2.' '.$mail_j1. '">'. $j2.'</option>'; ?>
          </select> 
          </br>
          <button name="annulation_choix_du_match">Annuler</button>
          <?php
          if(isset($_POST['annulation_choix_du_match'])){
            unset($_POST);
          }?>
          
          <button name='tournoi_en_cours' value='tournoi' >Envoyer</button>
        </p>
      </fieldset>
    </form>
  <?php 
  } 
  ?>
</div>

<?php
if(isset($_POST['tournoi_en_cours'])){
  include("tournoi_en_cours_process.php");
  unset($_POST);
}
?>
