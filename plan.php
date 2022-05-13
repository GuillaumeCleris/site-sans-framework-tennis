<?php 
//test d'existence d'une session connectée
  session_start();

  $typeConnexion=""; 
  if(!isset($_SESSION['id_mail']) or empty($_SESSION['id_mail'])){
    $_SESSION["connecter"]="non";
  }
  else{
    if($_SESSION["typeConnexion"]=="arbitre"){
      $typeConnexion="arbitre";
    }
    else{
      $typeConnexion="adherent";
    }
  }
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
    <!--affichage différent de la barre de menu en fonction de l'état connecté-->
    <?php 
    include("menu_bar.php");
    ?>

    <article>
     
      <h1>Manuel d'utilisation du site </h1>

      <div class="encart">

        <div class="plan_bloc1">
          <h3>Procédure de connexion/déconnexion</h3>
          <hr/>
          <h4>Etape 1: S'inscrire</h4>
          <p>
            -Vous pouvez accéder à la page d'inscription à partir de "Inscrivez-vous" sur la page de connexion ou bien à partir du bouton "inscription" présent sur n'importe quelle page hormis la page du plan du site<br/>
            -Remplissez le formulaire d'inscription dont tous les champs sont obligatoires et doivent suivre un pattern précis<br/>
            -Si l'adresse mail est déjà dans la base de donnée il sera indiqué que l'adresse mail est déjà utilisée pour un compte existant, sinon vous serez dès lors inscrit et directement redirigé vers la page de connexion<br/>
          </p>
          <hr/>
          <h4>Etape 2: Se connecter</h4>
          <p>
            -Vous pouvez accéder à la page de connexion à partir du bouton "connexion" présent sur n'importe quelle page hormis la page du plan du site<br/>
            -Remplissez le formulaire de connexion dont tous les champs sont obligatoires et doivent suivre un pattern précis<br/>
            -Si l'adresse mail ou le mot de passe est incorrect, vous resterez sur la page de connexion<br/>
            -Sinon vous êtes maintenant connecté et êtes dirigé vers le planning de réservation avec la possibilité de réserver. Vous êtes alors connecté quelque soit la page où vous vous rendez et la barre de menu affiche un onglet déconnexion à la place de connexion et inscription.
           </p>
           <hr/>
           <h4>Etape 3: Se déconnecter</h4>
           <p>
            -Pour se déconnecter il suffit de cliquer sur l'onglet déconnexion de la barre de menu<br/>
            -Vous vous retrouvez alors sur la page d'accueil comme au début de la procédure de connexion/déconnexion.<br/>  
           </p>

        </div>

        <div class="plan_bloc2">

          <h3>Procedure de réservation</h3>
          <hr/>
           <h4>Etape 1: Effectuer une réservation</h4>
           <p>
            -Vous devez être connecté pour avoir la possibilité de réserver un créneau<br/>
            -Pour effectuer une réservation il faut se rendre sur la page planning et cliquer sur le bouton "réserver"<br/>
            -Remplissez le formulaire de réservation déroulant<br/>
            -Si le créneau est déjà réservé, il vous sera indiqué que le créneau est indisponible. Sinon votre réservation sera prise en compte et le planning mis à jour.
           </p>
           <hr/>
           <h4>Etape 2: Visualisez le tableau de réservation </h4>
           <p>
            -Vous pouvez observer à tout moment quels créneaux et quels courts sont réservés sur le planning.
          </p>

        </div>

      </div>
    </article>

    <?php include("pieds_de_page.php");?>

  </body>
</html>