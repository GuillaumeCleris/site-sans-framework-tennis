<?php

    $mail_a_bannir = "";
    $mail_debannir = "";

    if(!isset($_POST['liste_adherent']) or empty($_POST['liste_adherent'])){
        $mail_debannir = $_POST['liste_banni'];
        $type_action="deban";

        /*
        $select = $bdd->prepare("select * from adherents where adresse_mail = '$mail_debannir'");
        $select -> execute();
        $row = $select->fetchAll();
        $nom_debannir = $row[0]['nom'];
        $prenom_debannir = $row[0]['prenom'];
        */
    }
    else if(!isset($_POST['liste_banni']) or empty($_POST['liste_banni'])){
        $mail_a_bannir = $_POST['liste_adherent'];
        $type_action="ban";

        /*
        $select = $bdd->prepare("select * from adherents where adresse_mail = '$mail_a_bannir'");
        $select -> execute();
        $row = $select->fetchAll();
        $nom_a_bannir = $row[0]['nom'];
        $prenom_a_bannir = $row[0]['prenom'];
        */
    }
    //echo $mail_debannir.$mail_a_bannir;



    if($type_action=="deban"){
        $update = $bdd -> prepare("UPDATE adherents SET banni = FALSE WHERE adresse_mail = '$mail_debannir' ");
        $update -> execute();

        ?>
        <div class="Popup" id="deban_reussi"> 
            <div class='Popupencart'>
                <p> Opération de deban réussie </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('deban_reussi'),'gestion_adherent.php'); 
        </script>
        <?php

    }
    else if($type_action=="ban"){
        $update = $bdd -> prepare("UPDATE adherents SET banni = TRUE WHERE adresse_mail = '$mail_a_bannir' ");
        $update -> execute();

        ?>
        <div class="Popup" id="ban_reussi"> 
            <div class='Popupencart'>
                <p> Opération de ban réussie </p>
            </div>
        </div>
        <?php

        include('mail.php');
        if (envoyer_mail_compte($mail_a_bannir, "bannissement")) {
            ?>
            <script> 
                popup_et_redirection(document.getElementById('ban_reussi'),'gestion_adherent.php'); 
            </script>
            <?php
        }
        else {
            ?>
            <script> 
                popup_et_redirection(document.getElementById('ban_reussi'),'gestion_adherent.php'); 
            </script>
            <?php
        }
    }
    
?>


