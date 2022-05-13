<?php

$id = $_SESSION['id_mail'];
$chaine_vainqueur = $_POST['vainqueur'];
$separation= explode(' ', $chaine_vainqueur);
$num_tournoi=$separation[0];
$num_match=$separation[1];
$tour=$separation[2];
$mail_vainqueur=$separation[3];
$prenom_nom_vainqueur= $separation[4].' '.$separation[5];
$mail_perdant=$separation[6];

$tab_tour=array('son quart','sa demi','le tournoi');
$etape=$tab_tour[$tour - 1];



$reponse = $bdd->prepare("select * from adherents order by nb_points desc");
$reponse -> execute();
$donnees = $reponse->fetchAll();
$compteur = count(array_column($donnees, 'adresse_mail'));


$j=0;
$nombre_joueur_classé=0;
while($j<$compteur) {

        $resmail = $donnees[$j]['adresse_mail'];

        $resclassement= $donnees[$j]['classement'];

        $respoints= $donnees[$j]['nb_points'];

        if($respoints != 0){
            $tab_tri[$nombre_joueur_classé][0] = $resmail;
            $tab_tri[$nombre_joueur_classé][1] = $respoints;
            $nombre_joueur_classé += 1;
        }
        
        if($resmail==$mail_vainqueur){  
            $classement_vainqueur=$resclassement;
            $points_vainqueur=$respoints;

        } 

        else if($resmail==$mail_perdant){
            $classement_perdant=$resclassement;
            $points_perdant=$respoints;
        }
    $j++;
}


if ($classement_perdant == 0){
    $points = $points_vainqueur + 2**($tour);
}
else{
    $points = $points_vainqueur + 2**($tour) * ($nombre_joueur_classé + 2 - $classement_perdant);
}


if ($classement_vainqueur == 0){
    $i=$nombre_joueur_classé;
    $tab_tri[$i][0] = $mail_vainqueur;
    $tab_tri[$i][1] = $points;
    
}
else{
    $i=$classement_vainqueur - 1;
    $tab_tri[$i][1] = $points;
}

$req = $bdd->prepare("UPDATE matchs SET vainqueur='$mail_vainqueur' WHERE num_tournoi ='$num_tournoi' and num_match='$num_match'");
$req->execute();

$req = $bdd->prepare("UPDATE adherents SET nb_points='$points' WHERE adresse_mail ='$mail_vainqueur'");
$req->execute();


$bool=true;
while($i>0 && $bool==true) {
    if($tab_tri[$i][1] > $tab_tri[$i - 1][1]){
        $tmp_mail = $tab_tri[$i][0];
        $tmp_nb_points = $tab_tri[$i][1];
        $tab_tri[$i][0] = $tab_tri[$i - 1][0];
        $tab_tri[$i][1] = $tab_tri[$i - 1][1];
        $tab_tri[$i - 1][0]=$tmp_mail;
        $tab_tri[$i - 1][1]=$tmp_nb_points;

        $mail=$tab_tri[$i][0];
        $class=$i+1;
        $req = $bdd->prepare("UPDATE adherents SET classement='$class' WHERE adresse_mail='$mail'");
        $req->execute();
        $i-=1;
    }
    else if($tab_tri[$i][1] == $tab_tri[$i - 1][1]){
        $i-=1;
    }
    else{
        $bool=false;
    }
}
if(($i+1) != $classement_vainqueur){
    $classement_vainqueur = $i+1;
    $req = $bdd->prepare("UPDATE adherents SET classement='$classement_vainqueur' WHERE adresse_mail='$mail_vainqueur'");
    $req->execute();
}
    


if($num_match==7){
    $req = $bdd->prepare("UPDATE tournois SET situation='terminé' WHERE num ='$num_tournoi'");
    $req->execute();
    $req = $bdd->prepare("UPDATE tournois SET vainqueur_tournoi='$mail_vainqueur' WHERE num ='$num_tournoi'");
    $req->execute();
    $update = $bdd -> prepare("UPDATE arbitres SET moderateur = FALSE WHERE moderateur = TRUE");
    $update ->execute();

}

$typeConnexion = $_SESSION["typeConnexion"];
include('menu_bar.php');
include('pieds_de_page.php');
?>

<div class="Popup" id="ajout_vainqueur_match"> 
<div class='Popupencart'>
    <p> <?php echo $prenom_nom_vainqueur.' a remporté ' .$etape ;?> </p>
</div>
</div>
<script> 
    popup_et_redirection(document.getElementById('ajout_vainqueur_match'),'tournoi.php'); 
</script>