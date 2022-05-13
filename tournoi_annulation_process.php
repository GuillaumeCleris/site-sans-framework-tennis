<?php
    
$result = $bdd->prepare("select * from tournois where situation='inscription'");
$result -> execute();
$valeurs = $result->fetchAll();
$num_tournoi = $valeurs[0]['num'];
$id_mail=$_SESSION['id_mail'];


$delete = $bdd->prepare("delete from inscrits where mail ='$id_mail' and num = '$num_tournoi'");
$delete -> execute();

$nb_inscrit = get_nombre_inscrit($num_tournoi);
$update = $bdd->prepare("UPDATE tournois SET nb_reel = '$nb_inscrit' WHERE num = '$num_tournoi' ");
$update -> execute();

?>
<script> 
redirection('tournoi.php'); 
</script>
<?php
    
   
?>
