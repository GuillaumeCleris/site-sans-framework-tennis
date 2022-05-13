<?php
//récupération des donées entrées par l'utilisateur et de la variable globale de connexion
$creneau = $_POST['creneau'];
$separation= explode(' ', $creneau);
$court=$court[$separation[0]];
$date=$sem_sql[$separation[1]];
$date_mail=$sem_mail[$separation[1]];
$h=$separation[2];

$req = $bdd->prepare("delete from reservations where adresse_mail='$mail' and court='$court' and h_deb='$h' and date='$date'");
$req->execute();
?>

<div class="Popup" id="popup_annulation_réussie" > 
    <div class='Popupencart'> 
        <p> <?php echo 'Annulation du court ' .$court.'<br/> le ' .$date_mail. ' à ' .$h. ' h';?> </p>
        <button class="pointeur" onclick="popup_fermante_avec_redirection(document.getElementById('popup_annulation_réussie'),'planning.php')">&times;</button>
    </div>
</div>

<script> 
    popup_ouvrante(document.getElementById('popup_annulation_réussie')); 
</script> 
 