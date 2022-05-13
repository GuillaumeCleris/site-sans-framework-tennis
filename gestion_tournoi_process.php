<?php

    $num_tournoi = $_POST['liste_tournoi_inscription'];


    $select = $bdd->prepare("select * from tournois where num = '$num_tournoi'");
    $select -> execute();
    $row = $select->fetchAll();
    $nom_tournoi = $row[0]['nom_tournoi'];


    $update = $bdd -> prepare("UPDATE tournois SET situation = 'terminé' WHERE num = '$num_tournoi'");
    $update -> execute();

    
    $update = $bdd -> prepare("UPDATE arbitres SET moderateur = FALSE WHERE moderateur = TRUE ");
    $update -> execute();


    $delete = $bdd -> prepare("delete from inscrits where num = '$num_tournoi'");
    $delete -> execute();


?>
<div class="Popup" id="arret_tournoi"> 
    <div class='Popupencart'>
        <p> <?php echo 'Le tournoi '.$nom_tournoi.' a bien été arrêté'; ?> </p>
    </div>
</div>
<script> 
    popup_et_redirection(document.getElementById('arret_tournoi'),'gestion_tournoi.php'); 
</script>
