<?php
    session_start();

    if(!isset($_SESSION['id_mail_admin']) or empty($_SESSION['id_mail_admin'])){
      $_SESSION["connecter_admin"]="non";
    }

    include("connexion_bd.php");
    $bdd = connect();
    include("getters.php");
    $reponse = $bdd->prepare("select * from adherents");
    $reponse -> execute();
    $row = $reponse->fetchAll();
    $compteur = count(array_column($row, 'id')); 
    $i=0;
    $compteur_banni = 0;
    
    while($i<$compteur) {
        $resemail[$i] = $row[$i]['adresse_mail'];
        $resname[$i] = $row[$i]['prenom'];
        $resfname[$i] = $row[$i]['nom'];
        $resbanni[$i] = $row[$i]['banni'];
        if($resbanni[$i]){
            $compteur_banni++;
        }
        $i++;
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
    <?php include("menu_bar_admin.php");?>
    <?php include("pieds_de_page.php");?>
    <?php
    if($_SESSION["connecter_admin"]=="non"){
        ?>
        <div class="Popup" id="gestion_adherent"> 
            <div class='Popupencart'>
                <p> Veuillez vous connecter en tant qu'administrateur </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('gestion_adherent'),'connexion_admin.php'); 
        </script>
        <?php
    }
    else{ ?>
        <article>
            <h1>Gestion des adhérents</h1> 
            <?php
            if($compteur!=0){
                if($compteur_banni==0){
                    ?>
                    <button onclick="disparaitre(document.getElementById('formulaireUnbanAdh'));apparaitre(document.getElementById('formulaireBanAdh'))">Bannir un adherent</button>
                    <?php
                }
                else if($compteur_banni==$compteur){
                    ?>
                    <button onclick="disparaitre(document.getElementById('formulaireBanAdh'));apparaitre(document.getElementById('formulaireUnbanAdh'))">Redonner l'accès à un adherent</button>
                    <?php
                }
                else{
                    ?>
                    <button onclick="disparaitre(document.getElementById('formulaireUnbanAdh'));apparaitre(document.getElementById('formulaireBanAdh'))">Bannir un adherent</button>
                    <button onclick="disparaitre(document.getElementById('formulaireBanAdh'));apparaitre(document.getElementById('formulaireUnbanAdh'))">Redonner l'accès à un adherent</button>
                    <?php
                }   
            }

        else{
            ?>
            <p> Il n'y a pas de compte adherent </p>
            <?php
        }?>

        <div id="formulaireBanAdh" style="display:none">
            <form action="" method = "post">
                <fieldset>
                    <p class="style-formulaire">
                        <label for="liste_adherent">Listes des adherents :</label><br/>
                        <select name="liste_adherent" id="liste_adherent">
                            <?php 
                                for($i=0 ; $i<$compteur ; $i++){
                                    if(!$resbanni[$i]){
                                        echo '<option value="'.$resemail[$i].'" > Bannir : '.$resname[$i].' '.$resfname[$i].' '.'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <br>
                        <button type='reset' onclick="disparaitre(document.getElementById('formulaireBanAdh'))">Annuler</button>
                        <button type='submit' name="modifier_adherents">Confirmer</button>
                    </p> 
                </fieldset>
            </form>
        </div>

        <div id="formulaireUnbanAdh" style="display:none">
            <form action="" method = "post">
                <fieldset>
                    <p class="style-formulaire">
                        <label for="liste_banni">Listes des adherents bannis :</label><br/>
                        <select name="liste_banni" id="liste_banni">
                            <?php 
                                for($i=0 ; $i<$compteur ; $i++){
                                    if($resbanni[$i]){
                                        echo '<option value="'.$resemail[$i].'" > Redonner l\'accès à : '.$resname[$i].' '.$resfname[$i].' '.'</option>';
                                    }
                                }
                            ?>
                        </select>
                        <br>
                        <button type='reset' onclick="disparaitre(document.getElementById('formulaireUnbanAdh'))">Annuler</button>
                        <button type='submit' name="modifier_adherents">Confirmer</button>
                    </p>
                </fieldset>
            </form>
        </div>

        </article>
        <?php

        if(isset($_POST['modifier_adherents'])){
            include("gestion_adherent_process.php");
            unset($_POST);
        }
    }
    ?>

  </body>
</html>