<?php

    //récupération des données entrées par l'utilisateur et de la variable globale de connexion
    $oldid = $_SESSION['id_mail'];
    $typeConnexion = $_SESSION["typeConnexion"];

    $newid = "";
    $secid = "";
    $newmdp = "";
    $secmdp = "";

    if(!empty($_POST['nvid']) && !empty($_POST['idconfirmation'])){
        $newid = $_POST['nvid'];
        $secid = $_POST['idconfirmation'];
    }

    if(!empty($_POST['nvmdp']) && !empty($_POST['mdpconfirmation'])){
        $newmdp = htmlspecialchars($_POST['nvmdp']);
        $secmdp = htmlspecialchars($_POST['mdpconfirmation']);
    }


    if($newid != "" && $secid != ""){
        //Modification du mail si le nouveau choisi n'est pas un identifiant déjà présent dans notre base de données et si le nouveau mot de passe et sa confirmation sont identiques
        if ($newid != $secid) {
            ?>
            <div class="Popup" id="incoherence_mail_profil" > 
                <div class='Popupencart'> 
                    <p> Erreur : vous avez entré deux adresses différentes </p>
                    <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('incoherence_mail_profil'),'profil.php')">&times;</button>
                </div>
            </div>

            <script> 
                popup_ouvrante(document.getElementById('incoherence_mail_profil')); 
            </script> 
            <?php
        }
        else { //tester si newid == oldid : pas de changement

            //requête sur la bd pour tester si la nouvelle adresse correspond à un compte existant
            if ($typeConnexion=="arbitre") {
                $test = $bdd->prepare("select * from arbitres");
            }
            else {
                $test = $bdd->prepare("select * from adherents");
            }
            $test ->execute();
            $row = $test->fetchAll();
            $c=count(array_column($row, 'adresse_mail'));
            $i=0;
            $bool=true;
            while($i<$c && $bool) {
                $resemail = $row[$i]['adresse_mail'];
                if ($resemail==$newid) {    
                    $bool=false;
                }
                $i++;
            }

            if($bool == false) {
                ?>
                <div class="Popup" id="existence_mail_profil" > 
                    <div class='Popupencart'> 
                        <p> Erreur : un compte est déjà enregistré avec cette adresse </p>
                        <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('existence_mail_profil'),'profil.php')">&times;</button>
                    </div>
                </div>

                <script> 
                    popup_ouvrante(document.getElementById('existence_mail_profil')); 
                </script> 
                <?php
            }
            else { //bool == true
                if ($typeConnexion=="arbitre") {
                    $req1 = $bdd -> prepare("update arbitres set adresse_mail = :newid where adresse_mail = '$oldid'");
                    $req1 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req1 -> execute();
                    $_SESSION['id_mail'] = $newid;
                }
                else {
                    //Modification de l'email dans la table adhérents
                    $req1 = $bdd -> prepare("update adherents set adresse_mail = :newid where adresse_mail = '$oldid'");
                    $req1 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req1 -> execute();
                    //Modification de l'email dans la table réservations
                    $req2 = $bdd -> prepare("update reservations set adresse_mail = :newid where adresse_mail = '$oldid'");
                    $req2 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req2 -> execute();
                    //Modification de l'email dans la table tournois
                    $req3 = $bdd -> prepare("update tournois set vainqueur_tournoi = :newid where vainqueur_tournoi = '$oldid'");
                    $req3 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req3 -> execute();
                    //Modification de l'email dans la table inscrits
                    $req4 = $bdd -> prepare("update inscrits set mail = :newid where mail = '$oldid'");
                    $req4 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req4 -> execute();
                    //Modification de l'email dans la table matchs
                    $req5 = $bdd -> prepare("update matchs set mail1 = :newid where mail1 = '$oldid'");
                    $req5 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req5 -> execute();
                    
                    $req6 = $bdd -> prepare("update matchs set mail2 = :newid where mail2 = '$oldid'");
                    $req6 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req6 -> execute();
                    
                    $req7 = $bdd -> prepare("update matchs set vainqueur = :newid where vainqueur = '$oldid'");
                    $req7 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                    $req7 -> execute();
                    $_SESSION['id_mail'] = $newid;
                }
                ?>
                <div class="Popup" id="modification_mail"> 
                    <div class='Popupencart'>
                        <p> La modification de votre adresse mail a été enregistrée </p>
                    </div>
                </div>
                <?php

                include('mail.php');
                if ($typeConnexion=="arbitre") {
                    $statut = "modif_arbitre";
                }
                else {
                    $statut = "modif_adherant";
                }
                if (envoyer_mail_compte($newid, $statut)) { 
                    ?>
                    <script> 
                        popup_et_redirection(document.getElementById('modification_mail'),'profil.php');
                    </script>
                    <?php
                }
                else {
                    ?>
                    <script> 
                        popup_et_redirection(document.getElementById('modification_mail'),'profil.php');
                    </script>
                    <?php
                }
            }
        }
    }



    if ($newmdp != "" && $secmdp != "") {
        //Modification du mot de passe si le nouveau mot de passe et sa confirmation sont identiques
        if ($newmdp != $secmdp) {
            ?>
            <div class="Popup" id="incoherence_mdp_profil" > 
                <div class='Popupencart'> 
                    <p> Erreur : vous avez entré deux mots de passe différents </p>
                    <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('incoherence_mdp_profil'),'profil.php')">&times;</button>
                </div>
            </div>

            <script> 
                popup_ouvrante(document.getElementById('incoherence_mdp_profil')); 
            </script> 
            <?php
        } //Tester old != new
        else {
            $newmdp=password_hash($newmdp, PASSWORD_DEFAULT);
            if ($typeConnexion=="arbitre") {
                $req = $bdd -> prepare("update arbitres set mdp = :newmdp where adresse_mail = '$oldid'");
                $req -> bindValue(':newmdp',$newmdp,PDO::PARAM_STR);
                $req -> execute();
            }
            else {
                $req = $bdd -> prepare("update adherents set mdp = :newmdp where adresse_mail = '$oldid'");
                $req -> bindValue(':newmdp',$newmdp,PDO::PARAM_STR);
                $req -> execute();
            }
            ?>
            <div class="Popup" id="modification_mdp"> 
                <div class='Popupencart'>
                    <p> La modification de votre mot de passe a été enregistrée </p>
                </div>
            </div>
            <script> 
                popup_et_redirection(document.getElementById('modification_mdp'),'profil.php'); 
            </script>
            <?php
        }
    }
?>
