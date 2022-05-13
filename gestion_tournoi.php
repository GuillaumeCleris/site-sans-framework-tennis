<?php 
    //test d'existence d'une session connectée
    session_start();

    if(!isset($_SESSION['id_mail_admin']) or empty($_SESSION['id_mail_admin'])){
    $_SESSION["connecter_admin"]="non";
    }

    include("connexion_bd.php");
    $bdd = connect();
    
    $reponse = $bdd->prepare("select * from tournois where situation='inscription'");
    $reponse -> execute();
    $donnees = $reponse->fetchAll();
    $compteur_inscription = count(array_column($donnees, 'num')); 
    $i=0;

    while($i<$compteur_inscription) {
        $resnum1[$i] = $donnees[$i]['num'];
        $resname1[$i] = $donnees[$i]['nom_tournoi'];
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
        <div class="Popup" id="gestion_tournoi"> 
            <div class='Popupencart'>
                <p> Veuillez vous connecter en tant qu'administrateur </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('gestion_tournoi'),'connexion_admin.php'); 
        </script>
        <?php
    }
    else{ ?>
        <article> 
            <h1>Gestion des tournois</h1>
            <?php
            if($compteur_inscription!=0){
                ?>
                <p>Arrêt d'un tournoi en phase d'inscription</p>
                    <form action="" method = "post">
                        <fieldset>
                            <p class="style-formulaire">
                                <label for="liste_tournoi_inscription">Listes des tournois en phase d'inscription :</label><br/>
                                    <select name="liste_tournoi_inscription" id="liste_tournoi_inscription">
                                        <?php 
                                            for($i=0 ; $i<$compteur_inscription ; $i++){
                                                echo '<option value="'.$resnum1[$i].'" >'.$resname1[$i].'</option>';
                                            }
                                        ?>
                                    </select>
                            </p>
                        </fieldset>
                        <button type="submit" name="gerer_tournoi">Confirmer</button>
                    </form>
                <?php
            } 

            else{
                ?>
                <p> Il n'y a aucun tournoi en phase d'inscription </p>
                <?php
            } ?>

        </article>
        <?php

        if(isset($_POST['gerer_tournoi'])){
            include("gestion_tournoi_process.php");
            unset($_POST);
        }
    }
    ?>
     
    
    

    
</body>
</html>

