<?php
    //récupération des entrées du formulaire d'inscription
    $nom = strtoupper(htmlspecialchars($_POST['nom']));
    $prenom = ucfirst(htmlspecialchars($_POST['prenom']));
    $naissance = htmlspecialchars($_POST['naissance']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = htmlspecialchars($_POST['nvmdp']);
    $message = '';

    //requête sur la bd pour tester si le compte existe déjà
    $test = $bdd->prepare("select * from adherents");
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


   //pop-up et redirection vers la page d'inscription si le compte existe déjà
    if (!$bool)
    {
        $message = 'Cette adresse mail est déjà inscrite';
    }
    //insertion des données dans la bd, pop-up et redirection vers la page de connexion si le compte à été créé
    else
    {
        //création d'un id pour le nouvel utilisateur
        include("id_creation.php");
        $id = creerIdAdherent();
        $mdp=password_hash($mdp, PASSWORD_DEFAULT);
        $result = $bdd->prepare("insert into adherents values(:id, :mail, :naissance, :adresse, :nom, :prenom, :mdp,0,0,FALSE)");
        $result->bindValue(':id',$id,PDO::PARAM_STR);
        $result->bindValue(':mail',$mail,PDO::PARAM_STR);
        $result->bindValue(':naissance',$naissance,PDO::PARAM_STR);
        $result->bindValue(':adresse',$adresse,PDO::PARAM_STR);
        $result->bindValue(':nom',$nom,PDO::PARAM_STR);
        $result->bindValue(':prenom',$prenom,PDO::PARAM_STR);
        $result->bindValue(':mdp',$mdp,PDO::PARAM_STR);
        $result ->execute();
        ?>
        <div class="Popup" id="popup_inscription_réussie" > 
            <div class='Popupencart'> 
                <p> <?php echo 'Votre compte a été créé. Veuillez-vous connecter';?> </p>
                <button class='pointeur' onclick="popup_fermante_avec_redirection(document.getElementById('popup_inscription_réussie'),'connexion.php')">&times;</button>
            </div>
        </div>
        <?php

        include('mail.php');
        if (envoyer_mail_compte($mail, "inscription")) {
            ?> 
            <script> 
                popup_ouvrante(document.getElementById('popup_inscription_réussie'));
            </script>
            <?php
        }
        else { 
            ?> 
            <script> 
                popup_ouvrante(document.getElementById('popup_inscription_réussie'));
            </script>
            <?php
        }
    }

?>