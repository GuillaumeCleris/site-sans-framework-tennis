<?php

    $nom = "";
    $prenom = "";
    $naissance = "";
    $mail = "";
    $mdp = "";

    $admin_mail = "";

    //récupération des données pour l'inscription d'un administrateur
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['naissance']) && !empty($_POST['identifiant']) && !empty($_POST['motDePasse'])){
        $nom = strtoupper(htmlspecialchars($_POST['nom']));
        $prenom = ucfirst(htmlspecialchars($_POST['prenom']));
        $naissance = htmlspecialchars($_POST['naissance']);
        $mail = htmlspecialchars($_POST['identifiant']);
        $mdp = htmlspecialchars($_POST['motDePasse']);
        $type_action = "inscription";
    }
    

    //récupération des données entrées par l'utilisateur et de la variable globale de connexion
    if(!empty($_POST['liste_admin'])){
        $admin_mail = $_POST['liste_admin'];
        $type_action = "suppression";
    }
    





    if($type_action == "inscription"){
        $test = $bdd->prepare("select * from administrateurs");
        $test ->execute();
        $row = $test->fetchAll();
        $c=count(array_column($row, 'adresse_mail'));
        $i=0;
        $bool=true;
        while($i<$c && $bool) {
            $resemail = $row[$i]['adresse_mail'];
            if ($resemail==$mail) {
                $bool=false;
            }
            $i++;
        }

        if (!$bool)
        {
            ?>
            <div class="Popup" id="incoherence_mail_admin" > 
                    <div class='Popupencart'> 
                        <p> Cette adresse mail est déjà inscrite </p>
                        <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('incoherence_mail_admin'),'gestion_admin.php')">&times;</button>
                    </div>
            </div>

            <script> 
                popup_ouvrante(document.getElementById('incoherence_mail_admin')); 
            </script> 
        
            <?php                
        }
        else
        {
            
            include("id_creation.php");
            $id = creerIdAdministrateur();
            
            $mdp=password_hash($mdp, PASSWORD_DEFAULT);
            $result = $bdd->prepare("insert into administrateurs values(:id, :mail, :naissance, :nom, :prenom, :mdp)");
            $result -> bindValue(':id',$id,PDO::PARAM_STR);
            $result -> bindValue(':mail',$mail,PDO::PARAM_STR);
            $result -> bindValue(':naissance',$naissance,PDO::PARAM_STR);
            $result -> bindValue(':nom',$nom,PDO::PARAM_STR);
            $result -> bindValue(':prenom',$prenom,PDO::PARAM_STR);
            $result -> bindValue(':mdp',$mdp,PDO::PARAM_STR);
            $result -> execute();

            ?>
            <div class="Popup" id="compte_admin_cree" > 
                    <div class='Popupencart'> 
                        <p> Le compte a été créé </p>
                    </div>
            </div>
            <?php
            
            include('mail.php');
            if (envoyer_mail_compte($mail, "ajout_admin")) { 
                ?>
                <script> 
                    popup_et_redirection(document.getElementById('compte_admin_cree'),'gestion_admin.php');
                </script>
                <?php
            }
            else {
                ?>
                <script> 
                    popup_et_redirection(document.getElementById('compte_admin_cree'),'gestion_admin.php');
                </script>
                <?php
            }
            
        }
    }
    else if($type_action=="suppression"){
        $reponse = $bdd->prepare("select * from administrateurs where adresse_mail = '$admin_mail'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        
        $resname = $row[0]['prenom'];
        $resfname = $row[0]['nom'];
    
        //requête sur la bd pour savoir quels créneaux sont réservés
        $delete = $bdd->prepare("delete from administrateurs where adresse_mail='$admin_mail'");
        $delete -> execute();

        ?>

        <div class="Popup" id="suppression_admin" > 
                <div class='Popupencart'> 
                    <p> <?php echo 'L\'administrateur '.' '.$resname.' '.$resfname.' a bien été supprimé'; ?> </p>
                    <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('suppression_admin'),'gestion_admin.php')">&times;</button>
                </div>
        </div>

        <script> 
            popup_ouvrante(document.getElementById('suppression_admin')); 
        </script> 
    
        <?php   
    }
?>

