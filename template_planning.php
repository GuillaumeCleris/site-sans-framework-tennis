<?php

//On set la date selon l'UTC Francais
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);

$semaine = array('lundi', 'mardi','mercredi','jeudi','vendredi', 'samedi', 'dimanche');
$week = array('Monday', 'Tuesday','Wednesday','Thursday','Friday', 'Saturday','Sunday');
$mois = array('janvier', 'fevrier','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','decembre');
$zero_chiffre = array('01','02','03','04','05','06','07','08','09','10','11','12');

$chiffre=array();
$zero_chiffre2=array();
for ($i=1;$i<32;$i++){
    $chiffre[$i-1]=''.$i.'';
    if($i<10){
        $zero_chiffre2[$i-1]='0'.$i.' /';
    }
    else{
        $zero_chiffre2[$i-1]=$i.' /';
    }
}

//On recupère la date sous le format sql 'AAAA-MM-JJ' (ex: '2021-03-05') pour les tests sur la base de données
$date_sql=strftime('%Y-%m-%d');

//On recupère la date sous le format suivant l'ex: 'lundi 02 / 05' grâce au format précédant (pour les formulaire et l'affichage du planning)
$date_affichage=str_replace($week,$semaine,strftime('%A %d / %B',strtotime($date_sql)));

/*fonction qui prend en argument sous le format sql 'AAAA-MM-JJ' et qui renvoie :
* en indice 0 un tableau des 7 jours consécutifs commencant à la date actuelle sous le format 'AAAA-MM-JJ'
* en indice 1 un tableau des 7 jours consécutifs commencant à la date actuelle sous le format 'lundi 2 decembre'
*/
function plagesemaine($date){
    $semaine=$GLOBALS['semaine'];
    $week=$GLOBALS['week'];
    
    //On insère la date d'aujourd'hui sous les deux formats
    $sem_sql[0] = $date;
    $sem_affichage[0] = str_replace($week,$semaine,strftime('%A %d / %m',strtotime($date)));
    
    //On insère les jours suivants par incrémentation (+1 day)
    for($i=1;$i<7;$i++){
        $sem_sql[$i]  = strftime('%Y-%m-%d', strtotime($sem_sql[$i-1].'+1 day'));
        $sem_affichage[$i] = str_replace($week,$semaine,strftime('%A %d / %m',strtotime($sem_sql[$i])));
    }
    return array($sem_sql,$sem_affichage);
}

//On récupère la plage de 7 jours sous les deux formats
$sem_sql=plagesemaine($date_sql)[0];
$sem_affichage=plagesemaine($date_sql)[1];

//On récupère la plage de 7 jours sous un troisième format (pour les mails et popup)
$sem_mail=str_replace($zero_chiffre,$mois,str_replace($zero_chiffre2,$chiffre,$sem_affichage));

//On récupère le premier jours (aujourd'hui) et le dernier jour de la plage de 7 jours sous format sql
$date_min=$sem_sql[0];
$date_max=$sem_sql[6];
    
//On récupère les réservations de la plage de 7 jours
$reponse = $bdd->prepare("select * from reservations where date between '$date_min' and '$date_max'");
$reponse -> execute();
$donnees = $reponse->fetchAll();
$compteur = count(array_column($donnees, 'adresse_mail'));    

$court = array('central', 'un');

//création du tableau affichant le planning dont les indices correspondent respectivement à l'heure-8, au court et à la date de la plage de 7 jours
for($k=0;$k<9;$k++) //indice de l'heure - 8 
{
    $h=$k +8;                  
    for ($c=0;$c<2;$c++){ //indice du court
        for($i=0;$i<7;$i++) //indice du jour de la plage de 7 jours
        { 
            $bool=true;

            //On initialise $creneau à libre (il restera à libre si le créneau n'est pas réservé)
            $creneau='Libre';
            $j=0;
            while($j<$compteur && $bool==true) {
                //type de réservation  
                $restype=$donnees[$j]['type'];
                //mail de la personne qui a reservé
                $resmail = $donnees[$j]['adresse_mail'];

                //mail 1 et mail 2 des joueurs (lorsqu'il s'agit d'une reservation entrainement mail1 correspond au mail de la personne qui a reservé) 
                $resmail1 = $donnees[$j]['mail1'];
                $resmail2 = $donnees[$j]['mail2'];
                
                //heure de début du créneau / court / date
                $reshdeb = $donnees[$j]['h_deb'];
                $rescourt = $donnees[$j]['court'];
                $resdate = $donnees[$j]['date'];

                //Si la réservation correspond aux indices du tableau
                if ($reshdeb== $h && $rescourt==$court[$c] && $resdate==$sem_sql[$i]){
                    
                    //On récupère le nom et le prénom des adhérents joueurs
                    $resnom_prenom1 = get_prenom_nom($resmail1,'adherent');
                    $resnom_prenom2 = get_prenom_nom($resmail2,'adherent');
                    
                    //Si un adhérent connecté participe à un créneau de type entrainement alors la case s'affiche en Entrainement
                    if ($restype=='entrainement' && $_SESSION["connecter"]=="oui" && $typeConnexion=='adherent' && ($resmail1==$mail || $resmail2==$mail)){
                        $creneau='Entrainement';
                    }

                    //S'il s'agit d'un créneau de type tournoi alors dans tous les cas tournoi est affiché
                    else if ($restype=='tournoi'){
                        $creneau='Tournoi';
                    }

                    //S'il s'agit d'un créneau de type entrainement et que la connexion est de type arbitre
                    //S'il s'agit d'un créneau de type entrainement dont l'adhérent connecté ne participe pas
                    //alors la page s'affiche en indisponible
                    else{
                        $creneau='Indisponible';
                    }

                    //On sort de la boucle car on a trouvé la correspondance avec les indices
                    $bool=false;
                }
                $j++;
            }

            $tab[$k][$c][$i]=$creneau;
            if ($bool==true){
                //Pas reservation pour ce créneau donc pas de joueurs
                $tab_mail[$k][$c][$i][0]='rien';
                $tab_mail[$k][$c][$i][1]='rien';
            }
            else{
                //On rentre les prenoms et noms des 2 joueurs pour ce créneau
                $tab_mail[$k][$c][$i][0]=$resnom_prenom1;
                $tab_mail[$k][$c][$i][1]=$resnom_prenom2;
            }

            //On initialise l'indice suivant pour 
            $bool=true;
            $creneau='libre';
        }
    }
}       
?>

<!--affichage du planning-->
<table>
    <thead>
        <tr class="legendes_tableau">
            <th></th>
            <th>Court n°</th>
            <?php 

            for($i=0;$i<7;$i++){ 
                ?>
                <td> <?php echo $sem_affichage[$i]; ?></td>
                <?php
            }
            ?>
        </tr>      
    </thead>
   
    <tbody>
        <?php 
        for($h=8;$h<17;$h++){
        $k=$h-8;                 
            for ($ct=0;$ct<2;$ct++){
                ?>
                <tr>
                <?php
                if ($court[$ct]=='central'){
                    ?>
                    <td rowspan="2" class="legendes_tableau"><?php echo $h.'h';?></td>
                    <?php 
                }   
                echo '<td class="legendes_tableau">' .$court[$ct]. '</td>';
                for($i=0;$i<7;$i++){ 
                    if ($tab[$k][$ct][$i]=='Libre'){
                        ?>
                        <td class="cellules_libres"> 
                            <?php echo $tab[$k][$ct][$i]; ?>                 
                        </td>
                        <?php
                    }
                    else{
                        if($tab[$k][$ct][$i]=='Indisponible'){
                            ?>
                            <td class="cellules_réservées"> 
                                <?php $valeur1=$tab_mail[$k][$ct][$i][0];
                                $valeur2=$tab_mail[$k][$ct][$i][1];
                                ?>

                                <div class="pointeur" onclick="popup_ouvrante(document.getElementById('<?php echo $k.$ct.$i;?>'))">
                                 <?php echo $tab[$k][$ct][$i] ?> </div>
                                <div class="Popup" id="<?php echo $k.$ct.$i;?>">
                                    <div class='Popupencart'>
                                        <p> 
                                            <?php echo $valeur1.' et '.$valeur2.'<br/>';?> 
                                        </p> 
                                        <button class="pointeur" onclick="popup_fermante_sans_redirection(document.getElementById('<?php echo $k.$ct.$i;?>'))">&times;</button>
                                    </div>
                                </div>
                            </td>
                            <?php
                        }
                        else if($tab[$k][$ct][$i]=='Entrainement'){
                            ?>
                            <td class="cellules_réservées_moi"> 
                                <?php $valeur1=$tab_mail[$k][$ct][$i][0];
                                $valeur2=$tab_mail[$k][$ct][$i][1];
                            ?>

                          <div class="pointeur" onclick="popup_ouvrante(document.getElementById('<?php echo $k.$ct.$i;?>'))">
                                 <?php echo $tab[$k][$ct][$i] ?> </div>
                                <div class="Popup" id="<?php echo $k.$ct.$i;?>">
                                    <div class='Popupencart'>
                                        <p> 
                                            <?php echo $valeur1.' et '.$valeur2.'<br/>';?> 
                                        </p> 
                                        <button class="pointeur" onclick="popup_fermante_sans_redirection(document.getElementById('<?php echo $k.$ct.$i;?>'))">&times;</button>
                                    </div>
                                </div>
                            </td>
                            <?php
                        }
                        else if($tab[$k][$ct][$i]=='Tournoi'){
                            ?>
                            <td class="cellules_tournoi"> 
                                <?php $valeur1=$tab_mail[$k][$ct][$i][0];
                                $valeur2=$tab_mail[$k][$ct][$i][1];
                                ?>

                          <div class="pointeur" onclick="popup_ouvrante(document.getElementById('<?php echo $k.$ct.$i;?>'))">
                                 <?php echo $tab[$k][$ct][$i] ?> </div>
                                <div class="Popup" id="<?php echo $k.$ct.$i;?>">
                                    <div class='Popupencart'>
                                        <p> 
                                            <?php echo $valeur1.' et '.$valeur2.'<br/>';?> 
                                        </p> 
                                        <button class="pointeur" onclick="popup_fermante_sans_redirection(document.getElementById('<?php echo $k.$ct.$i;?>'))">&times;</button>
                                    </div>
                                </div>
                            </td>
                            <?php
                        }  
                    }       
                }
                ?>
                </tr>
                <?php
            }
        }
        ?>                        
    </tbody>
</table>