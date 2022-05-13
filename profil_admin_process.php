<?php

    //récupération des données entrées par l'utilisateur et de la variable globale de connexion
    $oldid = $_SESSION['id_mail_admin'];

    $newid = "";
    $secid = "";
    $newmdp = "";
    $secmdp = "";

    if(!empty($_POST['nvid']) && !empty($_POST['idconfirmation'])){
        $newid = htmlspecialchars($_POST['nvid']);
        $secid = htmlspecialchars($_POST['idconfirmation']);
    }

    if(!empty($_POST['nvmdp']) && !empty($_POST['mdpconfirmation'])){
        $newmdp = htmlspecialchars($_POST['nvmdp']);
        $secmdp = htmlspecialchars($_POST['mdpconfirmation']);
    }


    if($newid != "" && $secid != ""){
        //Modification du mail si le nouveau choisi n'est pas un identifiant déjà présent dans notre base de données et si le nouveau mot de passe et sa confirmation sont identiques
        if ($newid != $secid) {
            ?>
            <div class="Popup" id="incoherence_mail_profil_admin" > 
                <div class='Popupencart'> 
                    <p> Erreur : vous avez entré deux adresses différentes </p>
                    <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('incoherence_mail_profil_admin'),'profil_admin.php')">&times;</button>
                </div>
            </div>

            <script> 
                popup_ouvrante(document.getElementById('incoherence_mail_profil_admin')); 
            </script> 
            <?php
        }
        else { //tester si newid == oldid : pas de changement

            //requête sur la bd pour tester si la nouvelle adresse correspond à un compte existant
            $test = $bdd->prepare("select * from administrateurs");
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
                <div class="Popup" id="existence_mail_profil_admin" > 
                    <div class='Popupencart'> 
                        <p> Erreur : un compte est déjà enregistré avec cette adresse </p>
                        <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('existence_mail_profil_admin'),'profil_admin.php')">&times;</button>
                    </div>
                </div>

                <script> 
                    popup_ouvrante(document.getElementById('existence_mail_profil_admin')); 
                </script> 
                <?php
            }
            else { //bool == true
                $req1 = $bdd -> prepare("update administrateurs set adresse_mail = :newid where adresse_mail = '$oldid'");
                $req1 -> bindValue(':newid',$newid,PDO::PARAM_STR);
                $req1 -> execute();
                $_SESSION['id_mail_admin'] = $newid;
                $_SESSION["connecter_admin"] = "oui";
                ?>
                <div class="Popup" id="modification_mail_admin"> 
                    <div class='Popupencart'>
                        <p> La modification de votre adresse mail a été enregistrée </p>
                    </div>
                </div>
                <?php

                include('mail.php');
                if (envoyer_mail_compte($newid, "modif_admin")) { 
                    ?>
                    <script> 
                        popup_et_redirection(document.getElementById('modification_mail_admin'),'profil_admin.php');
                    </script>
                    <?php
                }
                else {
                    ?>
                    <script> 
                        popup_et_redirection(document.getElementById('modification_mail_admin'),'profil_admin.php');
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
            <div class="Popup" id="incoherence_mdp_profil_admin" > 
                <div class='Popupencart'> 
                    <p> Erreur : vous avez entré deux mots de passe différents </p>
                    <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('incoherence_mdp_profil_admin'),'profil_admin.php')">&times;</button>
                </div>
            </div>

            <script> 
                popup_ouvrante(document.getElementById('incoherence_mdp_profil_admin')); 
            </script> 
            <?php
        } //Tester old != new
        else {
            $newmdp=password_hash($newmdp, PASSWORD_DEFAULT);
            $req = $bdd -> prepare("update administrateurs set mdp = :newmdp where adresse_mail = '$oldid'");
            $req -> bindValue(':newmdp',$newmdp,PDO::PARAM_STR);
            $req -> execute();
            ?>
            <div class="Popup" id="modification_mdp_admin"> 
                <div class='Popupencart'>
                    <p> La modification de votre mot de passe a été enregistrée </p>
                </div>
            </div>
            <script> 
                popup_et_redirection(document.getElementById('modification_mdp_admin'),'profil_admin.php'); 
            </script>
            <?php
        }
    }
?>
