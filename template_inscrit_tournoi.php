<?php
//on stocke le numéro du tournoi et le nombre maximal de participant
$num_tournoi = get_last_num_tournoi();
$nb_max = get_nombre_max_tournoi($num_tournoi);

//on prend la liste des inscrits au tournoi
$reponse = $bdd->prepare("select * from inscrits join adherents on inscrits.mail = adherents.adresse_mail where num='$num_tournoi'");
$reponse -> execute();
$donnees = $reponse->fetchAll();
$compteur = count(array_column($donnees, 'mail'));    


$j=0;
$nombre_inscrit=0;
while($j<$compteur) {
    $nombre_inscrit ++;
    $resmail = $donnees[$j]['mail'];
    $resfname[$j] = $donnees[$j]['nom'];
    $resname[$j] = $donnees[$j]['prenom'];
    $bool_inscrit[$j]=false;
    //si l'utilisateur est connecté
    if ($_SESSION["connecter"]=="oui"){
        $mail=$_SESSION['id_mail'];
        //on regarde l'utilisateur est parmi la liste des inscrits
        if ($mail == $resmail){
            $bool_inscrit[$j]=true;
        }
        else {
            $bool_inscrit[$j]=false;
        }
    }
    $j++;
}  


?>
<!-- Affichage de la liste des participants -->
<h1>Liste des inscrits au tournoi</h1>
<table>
    <thead>
        <tr class="legendes_tableau">
            <th>Prenom</th>
            <th>Nom</th>
        </tr>      
    </thead>
   
    <tbody>
        <?php 
        for($i=0;$i<$nombre_inscrit;$i++)
        {
            //si l'adherent est dans la liste
            if ($bool_inscrit[$i]==true){
                //l'adherent est affiché en vert
                echo '<tr>
                <td class="cellules_libres">'.$resname[$i].'</td>
                <td class="cellules_libres">'.$resfname[$i].'</td>
                </tr>';
            }
            else{
                //l'adherent est affiché en bleu
                echo '<tr>
                <td class="cellules_réservées_moi">'.$resname[$i].'</td>
                <td class="cellules_réservées_moi">'.$resfname[$i].'</td>
                </tr>';
            }
        }
        ?>
    </tbody>
</table>
<!-- Affichage du nombre de participant -->
<table>
    <thead>
        <tr class="legendes_tableau">
            <th>Nombres de participants</th>
        </tr>
       
    </thead>
   
    <tbody>
        <tr class="legendes_tableau">
            <?php 
            echo '<td>'.$nombre_inscrit.'/'.$nb_max.'</td>
            </tr>';
            ?>
    </tbody>
</table>
