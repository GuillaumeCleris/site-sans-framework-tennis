<?php
    $req_pts = $bdd->prepare("select nb_points from adherents where adresse_mail='$id'");
    $req_pts->execute();
    $nb_pts = $req_pts->fetchAll();

    $req_class = $bdd->prepare("select classement from adherents where adresse_mail='$id'");
    $req_class->execute();
    $classement = $req_class->fetchAll();

    $req_vict = $bdd->prepare("select count(vainqueur) from matchs where vainqueur='$id'");
    $req_vict->execute();
    $nb_vict = $req_vict->fetchAll();

    $req_match = $bdd->prepare("select count(vainqueur) from (select * from matchs where vainqueur <> 'A definir') as a where (mail1='$id' or mail2='$id')");
    $req_match->execute();
    $nb_match = $req_match->fetchAll();
    
    if ($nb_match[0][0]==0) {
        $pourcentage_vict = 0;
    }
    else {
        $pourcentage_vict = floor(($nb_vict[0][0] / $nb_match[0][0]) * 100);
    }
    
    $req = $bdd->prepare("select num_tournoi, nom_tournoi, tour, mail1, mail2, classement1, classement2, vainqueur, adresse_mail, prenom, nom from (select num_tournoi, nom_tournoi, tour, mail1, mail2, classement1, classement2, vainqueur from matchs join tournois on matchs.num_tournoi = tournois.num) as ma natural join adherents as ad where (ad.adresse_mail = ma.mail1 or ad.adresse_mail=ma.mail2) order by num_tournoi desc, tour desc");
    $req->execute();
    $res = $req->fetchAll();
    $compteur = count(array_column($res, 'nom_tournoi'));
?>
<div class="palmares">
    <div class="chiffre-cle">
        <p>
            Points<br>
            <mark><?php echo $nb_pts[0][0]; ?></mark>
        </p>
    </div>
    <div class="chiffre-cle">
        <p>
            Clasement<br>
            <mark><?php echo $classement[0][0]; ?></mark>
        </p>
    </div>
    <div class="chiffre-cle">
        <p>
            Victoires<br>
            <mark><?php echo $pourcentage_vict; ?>&#37;</mark>
        </p>
    </div>
</div>
<div>
    <table>
        <thead>
            <tr class="legendes_tableau">
                <th>Tournoi</th>
                <th>Tour</th>
                <th>Mon classement</th>
                <th>Mon adversaire</th>
                <th>Son classement</th>
                <th>Statut</th>
            </tr>      
        </thead>
   
        <tbody>
            <?php
            for ($i=0;$i<$compteur;$i++) {
                if ($res[$i][3] == $id || $res[$i][4] == $id) {
                    if ($res[$i][8] != $id) {
                        ?><tr><?php
                        if ($res[$i][7] == 'A definir') { ?>
                            <td class="cellules_réservées_moi"> <?php echo $res[$i][1]; ?></td>
                            <td class="cellules_réservées_moi"> <?php echo $res[$i][2]; ?></td>
                            <?php if ($res[$i][3] == $id) { 
                                if ($res[$i][5]==0) { ?>
                                    <td class="cellules_réservées_moi">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées_moi"> <?php echo $res[$i][5]; ?></td>
                                <?php }
                            }
                            else {
                                if ($res[$i][6]==0) { ?>
                                    <td class="cellules_réservées_moi">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées_moi"> <?php echo $res[$i][6]; ?></td>
                                <?php }
                            } ?>
                            <td class="cellules_réservées_moi"> <?php echo $res[$i][9].' '.$res[$i][10]; ?></td>
                            <?php if ($res[$i][3] == $id) { 
                                if ($res[$i][6]==0) { ?>
                                    <td class="cellules_réservées_moi">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées_moi"> <?php echo $res[$i][6]; ?></td>
                                <?php }
                            }
                            else {
                                if ($res[$i][5]==0) { ?>
                                    <td class="cellules_réservées_moi">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées_moi"> <?php echo $res[$i][5]; ?></td>
                                <?php }
                            } ?>
                            <td class="cellules_réservées_moi">A venir</td>
                        <?php }

                        else if ($res[$i][7] == $id) { ?>
                            <td class="cellules_libres"> <?php echo $res[$i][1]; ?></td>
                            <td class="cellules_libres"> <?php echo $res[$i][2]; ?></td>
                            <?php if ($res[$i][3] == $id) { 
                                if ($res[$i][5]==0) { ?>
                                    <td class="cellules_libres">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_libres"> <?php echo $res[$i][5]; ?></td>
                                <?php }
                            }
                            else {
                                if ($res[$i][6]==0) { ?>
                                    <td class="cellules_libres">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_libres"> <?php echo $res[$i][6]; ?></td>
                                <?php }
                            } ?>
                            <td class="cellules_libres"> <?php echo $res[$i][9].' '.$res[$i][10]; ?></td>
                            <?php if ($res[$i][3] == $id) { 
                                if ($res[$i][6]==0) { ?>
                                    <td class="cellules_libres">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_libres"> <?php echo $res[$i][6]; ?></td>
                                <?php }
                            }
                            else {
                                if ($res[$i][5]==0) { ?>
                                    <td class="cellules_libres">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_libres"> <?php echo $res[$i][5]; ?></td>
                                <?php }
                            } ?>
                            <td class="cellules_libres">Victoire</td>
                        <?php }

                        else { ?>
                            <td class="cellules_réservées"> <?php echo $res[$i][1]; ?></td>
                            <td class="cellules_réservées"> <?php echo $res[$i][2]; ?></td>
                            <?php if ($res[$i][3] == $id) { 
                                if ($res[$i][5]==0) { ?>
                                    <td class="cellules_réservées">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées"> <?php echo $res[$i][5]; ?></td>
                                <?php }
                            }
                            else {
                                if ($res[$i][6]==0) { ?>
                                    <td class="cellules_réservées">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées"> <?php echo $res[$i][6]; ?></td>
                                <?php }
                            } ?>
                            <td class="cellules_réservées"> <?php echo $res[$i][9].' '.$res[$i][10]; ?></td>
                            <?php if ($res[$i][3] == $id) { 
                                if ($res[$i][6]==0) { ?>
                                    <td class="cellules_réservées">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées"> <?php echo $res[$i][6]; ?></td>
                                <?php }
                            }
                            else {
                                if ($res[$i][5]==0) { ?>
                                    <td class="cellules_réservées">NC</td>
                                <?php }
                                else { ?>
                                    <td class="cellules_réservées"> <?php echo $res[$i][5]; ?></td>
                                <?php }
                            } ?>
                            <td class="cellules_réservées">Défaite</td>
                        <?php }
                        ?></tr><?php
                    }
                }

            }
            ?>
        </tbody>
    </table>
<?php
if ($compteur == 0) {
    ?><p>Vous n'avez pas encore participé à un tournoi</p><?php
} ?>

</div>

