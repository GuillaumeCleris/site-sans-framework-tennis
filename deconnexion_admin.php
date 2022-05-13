<?php
	//permet la déconnexion de l'utilisateur et une redirection vers la page d'accueil
	session_start();
    session_unset();
	session_destroy();
	
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
        <nav class="menu-bar">
        <ul>
            <li>
            <div class="wimbledon">WIImblEdon</div>
            </li>
        </ul>
        </nav>
        <?php
        include("pieds_de_page.php");
        ?>
        <div class="Popup" id="deconnexion_admin"> 
            <div class='Popupencart'>
                <p> Votre déconnexion a bien été prise en compte </p>
            </div>
        </div>
        <script> 
            popup_et_redirection(document.getElementById('deconnexion_admin'),'connexion_admin.php'); 
        </script>
    </body>
</html>