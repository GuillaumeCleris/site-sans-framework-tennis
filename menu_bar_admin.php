<?php 
if($_SESSION["connecter_admin"]=="oui"){
    ?>
    <nav class="menu-bar">
    <ul>
        <li>
        <div class="wimbledon">WIImblEdon</div>
        </li>
        <li>
        <a href="accueil_admin.php">Accueil</a>
        </li>
        <li>
        <a href="profil_admin.php">Mon profil</a>
        </li>
        <li>
        <a href="deconnexion_admin.php">Déconnexion</a>
        </li>
        <li>
        <a href="gestion_arbitre.php">Arbitres</a>
        </li>
        <li>
        <a href="gestion_adherent.php">Adherents</a>
        </li>
        <li>
        <a href="gestion_tournoi.php">Tournois</a>
        </li>
        <li>
        <a href="gestion_admin.php">Administrateurs</a>
        </li>
    </ul>
    </nav>
    <?php
}
else{
    ?>
    <nav class="menu-bar">
    <ul>
        <li>
        <div class="wimbledon">WIImblEdon</div>
        </li>
    </ul>
    </nav>
    <?php
}
?>