
<div class="style-formulaire" id="formulaireAnnulation" style="display:none">
  <form action="" method="post">
      <fieldset>
        <p>
          <label for="creneau">Creneau:</label><br/>
            <select name="creneau" id="creneau">
                <?php 
                for($i=0;$i<7;$i++) //indice du jour de la semaine
                { 
                  for($k=0;$k<9;$k++) //indice de l'heure - 8 
                  {
                    $h=$k +8;                  
                    for ($c=0;$c<2;$c++) //indice du court
                    { 
                      if (($_SESSION['typeConnexion'] == 'adherent' && $tab[$k][$c][$i]=="Entrainement")  || ($_SESSION['typeConnexion'] == 'arbitre' && $tab[$k][$c][$i]=="Tournoi" && is_moderator($mail)))
                      {
                        if($sem_sql[$i]<=$date_max && $sem_sql[$i] >= $date_min ){
                            echo '<option value="' .$c.' '.$i.' '.$h. '" >'.'court '.$court[$c].' '.$sem_affichage[$i].' '.$h.'h'.'</option>';
                        }
                      }
                    }
                  }
                }?>
            </select>
          <br/>
          <button type="reset" onclick="disparaitre(document.getElementById('formulaireAnnulation'))">Annuler</button>
          <button type="submit" name="annulation" value="annuler">Confirmer</button>
        </p>
      </fieldset> 
  </form>
  </div>

<?php
if(isset($_POST['annulation'])){
  include("annulation_process.php");
  unset($_POST);
}
?>