<?php

    $nom = "";
    $prenom = "";
    $naissance = "";
    $mail = "";
    $mdp = "";

    $arbitre_mail = "";

    //récupération des donées pour l'inscription d'un arbitre
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['naissance']) && !empty($_POST['identifiant']) && !empty($_POST['motDePasse'])){
        $nom = strtoupper(htmlspecialchars($_POST['nom']));
        $prenom = ucfirst(htmlspecialchars($_POST['prenom']));
        $naissance = htmlspecialchars($_POST['naissance']);
        $mail = htmlspecialchars($_POST['identifiant']);
        $mdp = htmlspecialchars($_POST['motDePasse']);
        $type_action = "inscription";
    }
    

    //récupération des donées entrées par l'utilisateur et de la variable globale de connexion
    if(!empty($_POST['liste_arbitre'])){
        $arbitre_mail = $_POST['liste_arbitre'];
        $type_action = "suppression";
    }



    if($type_action == "inscription"){
        $test = $bdd->prepare("select * from arbitres");
        $test -> execute();
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
            <div class="Popup" id="incoherence_mail_arbitre" > 
                    <div class='Popupencart'> 
                        <p> Cette adresse mail est déjà inscrite </p>
                        <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('incoherence_mail_arbitre'),'gestion_arbitre.php')">&times;</button>
                    </div>
            </div>

            <script> 
                popup_ouvrante(document.getElementById('incoherence_mail_arbitre')); 
            </script> 
            <?php
        }
        else
        {
            
            include("id_creation.php");
            $id = creerIdArbitre();
            $bool = 0;
            
            
            $mdp=password_hash($mdp, PASSWORD_DEFAULT);
            
            $result = $bdd->prepare("insert into  arbitres values(:id, :mail, :naissance, :nom, :prenom, :mdp, FALSE)");
            $result -> bindValue(':id',$id,PDO::PARAM_STR);
            $result -> bindValue(':mail',$mail,PDO::PARAM_STR);
            $result -> bindValue(':naissance',$naissance,PDO::PARAM_STR);
            $result -> bindValue(':nom',$nom,PDO::PARAM_STR);
            $result -> bindValue(':prenom',$prenom,PDO::PARAM_STR);
            $result -> bindValue(':mdp',$mdp,PDO::PARAM_STR);
            $result -> execute();
            
            ?>
            <div class="Popup" id="ajout_arbitre"> 
                <div class='Popupencart'>
                    <p> Le compte a été créé </p>
                </div>
            </div>
            <?php

            include('mail.php');
            if (envoyer_mail_compte($mail, "ajout_arbitre")) { 
                ?>
                <script> 
                    popup_et_redirection(document.getElementById('ajout_arbitre'),'gestion_arbitre.php');
                </script>
                <?php
            }
            else {
                ?>
                <script> 
                    popup_et_redirection(document.getElementById('ajout_arbitre'),'gestion_arbitre.php');
                </script>
                <?php
            }
            
        }
    }
    else if($type_action=="suppression"){
        $reponse = $bdd->prepare("select * from arbitres where adresse_mail = '$arbitre_mail'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        
        $resname = $row[0]['prenom'];
        $resfname = $row[0]['nom'];
    
        //requête sur la bd pour savoir quels créneaux sont réservés
        $delete = $bdd->prepare("delete from arbitres where adresse_mail='$arbitre_mail'");
        $delete -> execute();

        ?>
        <div class="Popup" id="suppression_arbitre"> 
            <div class='Popupencart'>
                <p> <?php echo 'L\'arbitre '.' '.$resname.' '.$resfname.' a bien été supprimé'; ?> </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('suppression_arbitre'),'gestion_arbitre.php'); 
        </script>
        <?php
    }
?>


