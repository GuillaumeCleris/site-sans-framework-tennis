<?php

    
//On récupère le numéro du tournoi
$num_tournoi=get_last_num_tournoi();

//On initialise à "A definir" les tableaux de prenom nom joueurs 1 / prenom nom joueurs 2 / mail joueur 1 / mail joueur 2 / prenom nom vainqueur / mail vainqueur
//Les indices correspondent au numéro du match
//Le tableau de moi permet de savoir si la personne connectée est un joueur du match et s'il s'agit du joueur 1 ou joueur 2 (dans le tableau son prenom nom sera colorisé)
for ($i=0;$i<7;$i++){
    $joueur1[$i]="A definir";
    $joueur2[$i]="A definir";
    $mail_joueur1[$i]="A definir";
    $mail_joueur2[$i]="A definir";
    $tab_vainqueur[$i]="A definir";
    $tab_mail_vainqueur[$i]="A definir";
    for ($k=0;$k<2;$k++){
        $moi[$i][$k]=false;
    } 
}


//On récupère les adresses mails, les noms prenoms, des joueurs 1 et 2 et des vainqueurs pour chaque match du tournoi
//'Place vacante' n'a donc pas de prenom / nom car est dans la table matchs en tant qu'adresse mais n'est pas dans la table adhérents
$reponse = $bdd->prepare("select * from matchs as ma left outer join adherents as ad on (ad.adresse_mail = ma.mail1 or ad.adresse_mail=ma.mail2)");
$reponse -> execute();
$donnees = $reponse->fetchAll();
$compteur = count(array_column($donnees, 'num_match')); 
$j=0;
while($j<$compteur) {
    $resnum_tournois = $donnees[$j]['num_tournoi'];
    $resnom =  $donnees[$j]['nom'];
    $resprenom =  $donnees[$j]['prenom'];
    $resmail = $donnees[$j]['adresse_mail'];

    $resmail1 = $donnees[$j]['mail1'];
    $restour = $donnees[$j]['tour'];
    $resnum_match = $donnees[$j]['num_match'];
    $resmail2 = $donnees[$j]['mail2'];

    $resvainqueur = $donnees[$j]['vainqueur'];
    
    if($resnum_tournois==$num_tournoi){               
        if ($resmail==$resmail1){
            $joueur1[$resnum_match - 1]=$resprenom.' '.$resnom;
            $mail_joueur1[$resnum_match - 1]=$resmail;
        }
        else if ($resmail==$resmail2){
            $joueur2[$resnum_match - 1]=$resprenom.' '.$resnom;
            $mail_joueur2[$resnum_match - 1]=$resmail;
        }

        if($resmail1=='Place vacante'){
            $joueur1[$resnum_match - 1]='Place vacante';
            $mail_joueur1[$resnum_match - 1]='Place vacante';
        }
        if($resmail2=='Place vacante'){
            $joueur2[$resnum_match - 1]='Place vacante';
            $mail_joueur2[$resnum_match - 1]='Place vacante';
        }


        $tab_mail_vainqueur[$resnum_match - 1] = $resvainqueur;
        if ($donnees[$j]['vainqueur'] == $resmail){
            $tab_vainqueur[$resnum_match - 1] = $resprenom.' '.$resnom;
        }


        if ($_SESSION["connecter"]=="oui"){
            $id=$_SESSION['id_mail'];
            if ($id == $resmail1){
                $moi[$resnum_match - 1][0]=true;
            }
            if ($id == $resmail2){
                $moi[$resnum_match - 1][1]=true;
            }
        }
        else {

            $id='';
        }
    }   
    $j++;
}


//On ajoute les joueurs 1 et 2 des matchs suivant (en fonction de ce que l'arbitre a rentré en vainqueur)
//Pour les matchs avec des places vacantes l'adversaire passe au prochain tour automatiquement
for($num_match=1;$num_match<7;$num_match++){
    if($num_match < 5){
        $tour_suivant=2;
    }
    else if($num_match == 5 || $num_match == 6){
        $tour_suivant=3;
    }
    $num_match_suivant = floor($num_match/2) + 2**(3-1) + $num_match % 2;

    if ($num_match % 2 !=0){
        if ($joueur1[$num_match -1]=='Place vacante' ){ 
            $tab_vainqueur[$num_match - 1 ]= $joueur2[$num_match -1];
            $tab_mail_vainqueur[$num_match - 1 ]= $mail_joueur2[$num_match -1];
            $ajout=$tab_mail_vainqueur[$num_match - 1 ]; 
            $req = $bdd->prepare("UPDATE matchs SET vainqueur='$ajout' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match'");
            $req->execute();
        }
        else if ($joueur2[$num_match -1]=='Place vacante' ){ 
            $tab_vainqueur[$num_match - 1 ]= $joueur1[$num_match -1];
            $tab_mail_vainqueur[$num_match - 1 ]= $mail_joueur1[$num_match -1];
            $ajout=$tab_mail_vainqueur[$num_match - 1 ]; 
            $req = $bdd->prepare("UPDATE matchs SET vainqueur='$ajout' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match'");
            $req->execute();
        }
        
        if ($tab_vainqueur[$num_match - 1 ] !="A definir" && $joueur1[$num_match_suivant -1]=="A definir"){   
            $joueur1[$num_match_suivant - 1]=$tab_vainqueur[$num_match - 1 ];
            $mail_joueur1[$num_match_suivant - 1]=$tab_mail_vainqueur[$num_match - 1 ];
            $ajout=$tab_mail_vainqueur[$num_match - 1 ];
            $classement = get_classement($ajout);   
            if ($id == $tab_mail_vainqueur[$num_match - 1 ]){
                $moi[$num_match_suivant -1][0]=true;
            }
            if ($joueur2[$num_match_suivant -1]!="A definir"){
                $req = $bdd->prepare("UPDATE matchs SET mail1='$ajout' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match_suivant'");
                $req->execute();
                $req = $bdd->prepare("UPDATE matchs SET classement1='$classement' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match_suivant'");
                $req->execute();
            }
            else {
                $req = $bdd->prepare("insert into matchs values('$num_tournoi','$num_match_suivant','$tour_suivant','$ajout','A definir','$classement',0,'A definir')");
                $req->execute();
            }
        }
    }


    else {

        if ($joueur1[$num_match -1]=='Place vacante' ){ 
            $tab_vainqueur[$num_match - 1 ]= $joueur2[$num_match -1];
            $tab_mail_vainqueur[$num_match - 1 ]= $mail_joueur2[$num_match -1];
            $ajout=$tab_mail_vainqueur[$num_match - 1 ]; 
            $req = $bdd->prepare("UPDATE matchs SET vainqueur='$ajout' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match'");
            $req->execute();
        }
        else if ($joueur2[$num_match -1]=='Place vacante' ){ 
            $tab_vainqueur[$num_match - 1 ]= $joueur1[$num_match -1];
            $tab_mail_vainqueur[$num_match - 1 ]= $mail_joueur1[$num_match -1];
            $ajout=$tab_mail_vainqueur[$num_match - 1 ]; 
            $req = $bdd->prepare("UPDATE matchs SET vainqueur='$ajout' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match'");
            $req->execute();
        }

        if ($tab_vainqueur[$num_match - 1 ] !="A definir" && $joueur2[$num_match_suivant -1]=="A definir"){
            $joueur2[$num_match_suivant - 1]=$tab_vainqueur[$num_match - 1 ];
            $mail_joueur2[$num_match_suivant - 1]=$tab_mail_vainqueur[$num_match - 1 ];
            $ajout=$tab_mail_vainqueur[$num_match - 1 ]; 
            $classement = get_classement($ajout);
            if ($id == $tab_mail_vainqueur[$num_match - 1 ]){
                $moi[$num_match_suivant -1][1]=true;
            }
            if ($joueur1[$num_match_suivant -1]!="A definir"){
                $req = $bdd->prepare("UPDATE matchs SET mail2='$ajout' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match_suivant'");
                $req->execute();
                $req = $bdd->prepare("UPDATE matchs SET classement2='$classement' WHERE num_tournoi = '$num_tournoi' and num_match='$num_match_suivant'");
                $req->execute();
            }
            else {
                $req = $bdd->prepare("insert into matchs values('$num_tournoi','$num_match_suivant','$tour_suivant','A definir','$ajout',0,'$classement','A definir',)");
                $req->execute();
            }
        }
    }
}
?>

<!--affichage de l'arbre de tournoi-->
<table>
    <thead>
        <tr class="legendes_tableau">
            <th>quart</th>
            <th></th>
            <th>demi</th>
            <th></th>
            <th>finale</th>
        </tr>
       
    </thead>
   
    <tbody>
        <tr class="legendes_tableau">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php 
        $nombrematch=0;

        //Affichage des matchs des quarts de final
        while($nombrematch<4){
            $nombrematch+=1;
            
            //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
            if ($moi[$nombrematch -1][0] && $typeConnexion=='adherent'){
                echo '<tr><td class="cellules_libres">'.$joueur1[$nombrematch -1].'</td>';
            }
            else {
                echo '<tr><td class="legendes_tableau">'.$joueur1[$nombrematch -1].'</td>';
            }
            echo '<td></td>
                <td></td>
                <td></td>
                <td></td></tr>';

            //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
            if ($moi[$nombrematch -1][1] && $typeConnexion=='adherent'){
                echo '<tr><td class="cellules_libres">'.$joueur2[$nombrematch -1].'</td>';
            }
            else {
                echo '<tr><td class="legendes_tableau">'.$joueur2[$nombrematch -1].'</td>';
            }
            echo '<td></td>
                <td></td>
                <td></td>
                <td></td></tr>';

            if($nombrematch==1)
            {
                echo '<tr>
                <td></td>
                <td></td>';

                //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
                if ($moi[5-1][0] && $typeConnexion=='adherent'){
                    echo '<td class="cellules_libres">'.$joueur1[5 -1].'</td>';
                }
                else {
                    echo '<td class="legendes_tableau">'.$joueur1[5 -1].'</td>';
                }
                echo '<td></td>
                <td></td>
                </tr>';

                echo '<tr>
                <td></td>
                <td></td>';

                //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
                if ($moi[5 -1][1] && $typeConnexion=='adherent'){
                    echo '<td class="cellules_libres">'.$joueur2[5 -1].'</td>';
                }
                else {
                    echo '<td class="legendes_tableau">'.$joueur2[5 -1].'</td>';
                }
                echo '<td></td>
                <td></td>
                </tr>';
            }
            else if($nombrematch==2){
                echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>';

                //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
                if ($moi[7 -1][0] && $typeConnexion=='adherent'){
                    echo '<td class="cellules_libres">'.$joueur1[7 -1].'</td>';
                }
                else {
                    echo '<td class="legendes_tableau">'.$joueur1[7 -1].'</td>';
                }

                echo '<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>';

                //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
                if ($moi[7 -1][1] && $typeConnexion=='adherent'){
                    echo '<td class="cellules_libres">'.$joueur2[7 -1].'</td>';
                }
                else {
                    echo '<td class="legendes_tableau">'.$joueur2[7 -1].'</td>';
                }

            }
            else if($nombrematch==3)
            {
                echo '<tr>
                <td></td>
                <td></td>';

                //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
                if ($moi[6 -1][0] && $typeConnexion=='adherent'){
                    echo '<td class="cellules_libres">'.$joueur1[6 -1].'</td>';
                }
                else {
                    echo '<td class="legendes_tableau">'.$joueur1[6 -1].'</td>';
                }
                echo
                '<td></td>
                <td></td>
                </tr>';

                echo '<tr>
                <td></td>
                <td></td>';

                //Si l'adhérent connecté est le joueur affiché alors sa case est colorée
                if ($moi[6 -1][1] && $typeConnexion=='adherent'){
                    echo '<td class="cellules_libres">'.$joueur2[6 -1].'</td>';
                }
                else {
                    echo '<td class="legendes_tableau">'.$joueur2[6 -1].'</td>';
                }
                echo 
                '<td></td>
                <td></td>
                </tr>';
            }
        }
        ?>
    </tbody>
</table>

<table>
    <thead>
        <tr class="legendes_tableau">
            <th>vainqueur</th>
        </tr>
       
    </thead>
   
    <tbody>
        <tr class="legendes_tableau">
            <?php echo '<td>'.$tab_vainqueur[6].'</td>
        </tr>';
?>
    </tbody>
</table>

<br/>