<?php

//On récupère l'état et le num du dernier tournoi (qui est en phase d'inscription)
$etatDuTournoi = get_tournament_state();
$num_tournoi = get_last_num_tournoi();

//On recupére les inscrits dans l'ordre des points 
$reponse = $bdd->prepare("select * from inscrits as i natural join adherents as a where a.adresse_mail = i.mail  and i.num='$num_tournoi' order by a.nb_points desc");
$reponse -> execute();
$donnees = $reponse->fetchAll();
$compteur = count(array_column($donnees, 'mail'));    

//On initialise les mails à place vacante et les classements à 0
$resmail = array();
for($i=0;$i<8;$i++){
    $resmail[$i] = "Place vacante";
    $resclassement[$i] = 0;
}

//On remplit les mails dans l'ordre de classement (grace à l'order by de la requête sql les joueurs non classé et les places vacantes seront mis après les joueurs classés)
//ON récupère le nombre de joueurs inscrits (les suivants resteront à l'initialisation de place vacante)
$j=0;    
$nombre_inscrit=0;
while($j<$compteur && $nombre_inscrit < 8) { 
    $nombre_inscrit ++;
    $resmail[$j] = $donnees[$j]['mail'];
    $resclassement[$j]=get_classement($resmail[$j]);
    $j++;
}

//On ajout le match 1 : 1 er contre 8 eme
$mail1=$resmail[0];
$mail2=$resmail[7];
$classement1=$resclassement[0];
$classement2=$resclassement[7];
$match = $bdd->prepare("insert into matchs values('$num_tournoi','1', '1', '$mail1', '$mail2', '$classement1','$classement2','A definir')");
$match -> execute();

//On ajout le match 2 : 5 eme contre 4 eme
$mail1=$resmail[4];
$mail2=$resmail[3];
$classement1=$resclassement[4];
$classement2=$resclassement[3];
$match = $bdd->prepare("insert into matchs values('$num_tournoi','2', '1', '$mail1', '$mail2', '$classement1','$classement2','A definir')");
$match -> execute();

//On ajout le match 3 : 3 eme contre 6 eme 
$mail1=$resmail[2];
$mail2=$resmail[5];
$classement1=$resclassement[2];
$classement2=$resclassement[5];
$match = $bdd->prepare("insert into matchs values('$num_tournoi','3', '1', '$mail1', '$mail2', '$classement1','$classement2', 'A definir')");
$match -> execute();

//On ajout le match 4 : 7 eme contre 1er
$mail1=$resmail[6];
$mail2=$resmail[1];
$classement1=$resclassement[6];
$classement2=$resclassement[1];
$match = $bdd->prepare("insert into matchs values('$num_tournoi','4', '1', '$mail1', '$mail2','$classement1','$classement2','A definir')");
$match -> execute();

//On update le nb réel de participant
$update = $bdd -> prepare("UPDATE tournois SET nb_reel = '$compteur' WHERE situation = 'inscription'");
$update -> execute();

//On update l'état du tournoi (inscription -> en cours)
$update = $bdd -> prepare("UPDATE tournois SET situation='en cours' WHERE num='$num_tournoi'");
$update -> execute();


//Popup et redirection (le div s'affiche une fois que la popup est enclenchée)
?>
<div class="Popup" id="clore"> 
        <div class='Popupencart'><p> Les inscriptions sont donc closes </p>
        </div>
</div>
<script> popup_et_redirection(document.getElementById('clore'),'tournoi.php'); 
</script>
<?php
?>