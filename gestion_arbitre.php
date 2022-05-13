<?php 
    //test d'existence d'une session connectée
    session_start();

    if(!isset($_SESSION['id_mail_admin']) or empty($_SESSION['id_mail_admin'])){
        $_SESSION["connecter_admin"]="non";
    }

    include("connexion_bd.php");
    $bdd = connect();
    include("getters.php");
    $bool = "false";
    $reponse = $bdd->prepare("select * from arbitres where moderateur = '$bool'");
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
        <div class="Popup" id="gestion_arbitre"> 
            <div class='Popupencart'>
                <p> Veuillez vous connecter en tant qu'administrateur </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('gestion_arbitre'),'connexion_admin.php'); 
        </script>
        <?php
    } 
    else{
        ?>
        <article>
            <h1>Gestion des arbitres</h1>
            <button onclick="disparaitre(document.getElementById('formulaireSuppArbitre'));apparaitre(document.getElementById('formulaireAjoutArbitre'))">Ajouter un arbitre</button>
            <button onclick="disparaitre(document.getElementById('formulaireAjoutArbitre'));apparaitre(document.getElementById('formulaireSuppArbitre'))">Supprimer un arbitre</button>
            <div id="formulaireAjoutArbitre" style="display:none">
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
                            <button type='reset' onclick="disparaitre(document.getElementById('formulaireAjoutArbitre'))">Annuler</button>
                            <button type='submit' name="gerer_arbitres">Confirmer</button>
                        </p> 
                    </fieldset>
                </form>
            </div>
            <div id="formulaireSuppArbitre" style="display:none">
                <?php
                if($compteur!=0){
                    ?>
                    <form action="" method = "post"> <!--suppression_arbitre_process.php -->
                        <fieldset>
                            <p class="style-formulaire">
                                <label for="liste_arbitre">Listes arbitres (non modérateur) :</label><br/>
                                <select name="liste_arbitre" id="liste_arbitre">
                                    <?php 
                                        for($i=0 ; $i<$compteur ; $i++){
                                            echo '<option value="'.$resemail[$i].'" >'.$resname[$i].' '.$resfname[$i].' '.'</option>';
                                        }
                                    ?>
                                </select>
                                <br>
                                <button type='reset' onclick="disparaitre(document.getElementById('formulaireSuppArbitre'))">Annuler</button>
                                <button type='submit' name="gerer_arbitres">Confirmer</button>
                            </p>
                        </fieldset>
                    </form>
                    <?php
                }
                else{
                    ?>
                    <p> Il n'y a pas d'arbitre non modérateur à supprimer</p>
                    <?php
                } ?>
            </div>

        </article>   
        <?php  

        if(isset($_POST['gerer_arbitres'])){
            include("gestion_arbitre_process.php");
            unset($_POST);
        }
    }
    ?>

  </body>
</html>