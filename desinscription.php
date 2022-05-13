<?php
    //permet la désinscription de l'utilisateur et une redirection vers la page d'accueil
    session_start();
    $id = $_SESSION['id_mail'];
    include("connexion_bd.php");
    $bdd = connect();
    $update = $bdd -> prepare("update adherents set banni = '1' where adresse_mail = '$id' ");
    $update -> execute();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>WIImblEdon</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="fonction.js"></script>
    </head>
 
    <body>
        <?php
        include("menu_bar.php");
        include("pieds_de_page.php");
        ?>
        <div class="Popup" id="desinscription"> 
            <div class='Popupencart'>
                <p> Votre désinscription a bien été prise en compte </p>
            </div>
        </div>
    
        <script> 
            popup_et_redirection(document.getElementById('desinscription'),'accueil.php'); 
        </script>
        <?php
        session_destroy();
        $_SESSION['id_mail']=NULL;
        ?>
    </body>
</html>