<?php 
    //test d'existence d'une session connectée
    session_start();

    if(!isset($_SESSION['id_mail_admin']) or empty($_SESSION['id_mail_admin'])){
        $_SESSION["connecter_admin"]="non";
    }

    include("connexion_bd.php");
    $bdd = connect();
    include("getters.php");
    $bool = false;
    $reponse = $bdd->prepare("select * from administrateurs");
    $reponse -> execute();
    $row = $reponse->fetchAll();
    $compteur = count(array_column($row, 'id')); 
    $i=0;

    while($i<$compteur) {
        $resemail[$i] = $row[$i]['adresse_mail'];
        $resname[$i] = $row[$i]['prenom'];
        $resfname[$i] = $row[$i]['nom'];
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
    <?php include("menu_bar_admin.php"); ?>
    <?php include("pieds_de_page.php");?>
    <?php 
    if($_SESSION["connecter_admin"]=="non"){
        ?>
        <div class="Popup" id="gestion_admin"> 
            <div class='Popupencart'>
                <p> Veuillez vous connecter en tant qu'administrateur </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('gestion_admin'),'connexion_admin.php'); 
        </script>
        <?php
    } 
    else{ ?>
        <article>
            <h1>Gestion des administrateurs</h1>
            <p>
                <button onclick="disparaitre(document.getElementById('formulaireSuppAdmin'));apparaitre(document.getElementById('formulaireAjoutAdmin'))">Ajouter un administrateur</button>
                <button onclick="disparaitre(document.getElementById('formulaireAjoutAdmin'));apparaitre(document.getElementById('formulaireSuppAdmin'))">Supprimer un administrateur</button>
            </p>
            <div id="formulaireAjoutAdmin" style="display:none">
                <form action="" method = "post">
                    <fieldset>
                        <p class="style-formulaire">
                            <label for="nom">Nom</label></br>
                            <input type="text" id="nom" name="nom" pattern="[a-zA-ZÀ-ÿ-]{2,30}$" title="alphabet requis" required></br>

                            <label for="prenom">Prenom</label></br>
                            <input type="text" id="prenom" name="prenom" pattern="[a-zA-ZÀ-ÿ-]{2,30}$" title="alphabet requis" required></br>

                            <label for="naissance">Date de naissance</label></br>
                            <input type="date" id="naissance" name="naissance" required></br>

                            <label for="identifiant">Adresse Mail</label></br>
                            <input type="email" id="identifiant" name="identifiant" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$" required></br>

                            <label for="motDePasse">Mot de passe</label></br>
                            <input type="password" id="motDePasse" name="motDePasse" required></br>
                            </br>
                            <button type='reset' onclick="disparaitre(document.getElementById('formulaireAjoutAdmin'))">Annuler</button>
                            <button type='submit' name="ajouter_admin">Confirmer</button>
                        </p>
                    </fieldset>
                </form>
            </div>

            
            <div id="formulaireSuppAdmin" style="display:none">
                <?php
                if($compteur>1){ ?>
                    <form action="" method = "post"> 
                        <fieldset>
                            <p class="style-formulaire">
                                <label for="liste_admin">Listes administrateurs :</label><br/>
                                <select name="liste_admin" id="liste_admin">
                                    <?php 
                                        for($i=0 ; $i<$compteur ; $i++){
                                            echo '<option value="'.$resemail[$i].'" >'.$resname[$i].' '.$resfname[$i].' '.'</option>';
                                        }
                                    ?>
                                </select>
                                <br>
                                <button type='reset' onclick="disparaitre(document.getElementById('formulaireSuppAdmin'))">Annuler</button>
                                <button type='submit' name="ajouter_admin">Confirmer</button>
                            </p>
                                
                        </fieldset>
                    </form>
                <?php
                }
                else{ ?>
                    <p> Il n'y a pas d'autre administrateur</p>
                    <?php
                } ?>
            </div>
            
        </article>  
        <?php

        if(isset($_POST['ajouter_admin'])){
            include("gestion_admin_process.php");
            unset($_POST);
        }

    } ?>

  </body>
</html>