<?php
    //On récupère le numéro du tournoi
    $num_tournoi = get_last_num_tournoi();

    //On récupère la variable globale mail connecté
    $id_mail=$_SESSION['id_mail'];

    //On ajoute l'adhérent qui s'est inscrit dans la table des inscrits de la bd
    $insertion = $bdd->prepare("insert into inscrits values('$num_tournoi', '$id_mail')");
    $insertion -> execute();

    //On récupère le nombre d'inscrit et on incrémente de 1 dans la base de donnée le nombre d'inscrit
    $nb_inscrit = get_nombre_inscrit($num_tournoi);
    $update = $bdd->prepare("UPDATE tournois SET nb_reel = '$nb_inscrit' WHERE num = '$num_tournoi' ");
    $update -> execute();

    //On envoie un mail après inscription à l'adhérent puis on le rédirige sur tournoi
    include('mail.php');
    if (envoyer_mail_compte($id_mail, "inscription_tournoi")) { 
        ?>
        <script> 
            redirection('tournoi.php');
        </script>
        <?php
    }
    else {
        ?>
        <script> 
            redirection('tournoi.php');
        </script>
        <?php
    }
?>

   