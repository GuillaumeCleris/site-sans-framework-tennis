<nav class="menu-bar">
  <ul>
    <li>
      <div class="wimbledon">WIImblEdon</div>
    </li>
    <li>
      <a href="accueil.php">Accueil</a>
    </li>


    <?php if($_SESSION["connecter"]!="non"){ 
      if($_SESSION["typeConnexion"]=="arbitre"){ ?>
        <li>
          <a href="profil.php">Mon Profil</a>
        </li>
        <li>
          <a href="deconnexion.php">Déconnexion</a>
        </li>
      <?php }
      else { ?>
        <li>
          <div class="dropdown">
            <button class="dropbtn">Mon Profil 
              <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
              <a href="profil.php">Informations</a>
              <a href="palmares.php">Palmarès</a>
            </div>
          </div> 
        </li>
        <li>
          <a href="deconnexion.php">Déconnexion</a>
        </li>
      <?php } 
    } 
    else { ?>
      <li>
        <a href="connexion.php">Connexion</a>
      </li>
      <li>
        <a href="inscription.php">Inscription</a>
      </li>
    <?php } ?>


    <li>
      <a href="planning.php">Planning</a>
    </li>
    <li>
      <a href="tournoi.php">Tournoi</a>
    </li>
    <li>
      <a href="classement.php">Classement</a>
    </li>

    <?php
    if($_SESSION["connecter"]=="non" || $_SESSION["typeConnexion"]=="adherent") { ?>
      <li>
        <a href="club.php">Le club</a>
      </li>
      <li>
        <a href="plan.php">Plan du site</a>
      </li>
    <?php } ?>
    
  </ul>
</nav>