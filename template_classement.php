<?php

    //On récupère les adhérents par nombre de point décroissant
    $reponse = $bdd->prepare("select * from adherents order by nb_points desc");
    $reponse -> execute();
    $donnees = $reponse->fetchAll();
    $compteur = count(array_column($donnees, 'adresse_mail'));    
    
    
    //On remplit les tableaux de prenom / nom / classement / points et on fait un tableau $bool_classement pour savoir où est l'adhérent connecté dans le classement
    $j=0;
    $nombre_class=0;
    while($j<$compteur) {
        if ($donnees[$j]['nb_points'] != 0){
            $nombre_class+=1;
            $resmail = $donnees[$j]['adresse_mail'];
            $resnom[$j] = $donnees[$j]['nom'];
            $resprenom[$j] = $donnees[$j]['prenom'];
            $resclassement[$j] = $donnees[$j]['classement'];
            $resnb_points[$j] = $donnees[$j]['nb_points'];
            $bool_classement[$j]=false;
            if ($_SESSION["connecter"]=="oui"){
                $id=$_SESSION['id_mail'];
                if ($id == $resmail){
                    $bool_classement[$j]=true;
                }
                else {
                    $bool_classement[$j]=false;
                }
            }
        }
        $j++;
    }              
?>

<!--affichage du tableau-->
<table>
    <thead>
        <tr class="legendes_tableau">
            <th>Classement</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Nombre de points</th>
        </tr>      
    </thead>
   
    <tbody>
        <?php 
        for($i=0;$i<$nombre_class;$i++)
        {   
            //Si le type de connexion est adhérent et si l'adresse mail connecté correspond à l'adresse mail de la ligne du tableau 
            //alors la colorisation est verte
            if ($bool_classement[$i]==true && $typeConnexion == 'adherent'){

                //On affiche le classement / son nom / son prenom / son nombre de point correspondant à l'adresse mail de cette ligne
                echo '<tr><td class="cellules_libres">'.$resclassement[$i].'</td>
                <td class="cellules_libres">'.$resnom[$i].'</td>
                <td class="cellules_libres">'.$resprenom[$i].'</td>
                <td class="cellules_libres">'.$resnb_points[$i].'</td>
                </tr>';
            }

            //Sinon la colorisation est bleu
            else{
                //On affiche son classement / son nom / son prenom / son nombre de point correspondant à l'adresse mail de cette ligne
                echo '<tr><td class="cellules_réservées_moi">'.$resclassement[$i].'</td>
                <td class="cellules_réservées_moi">'.$resnom[$i].'</td>
                <td class="cellules_réservées_moi">'.$resprenom[$i].'</td>
                <td class="cellules_réservées_moi">'.$resnb_points[$i].'</td>
                </tr>';
            }
        }
        ?>
    </tbody>
</table>
