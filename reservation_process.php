<?php
    //récupération des données entrées par l'utilisateur et de la variable globale de connexion
    $court = $_POST['court'];
    $i=$_POST['jour'];
    $date=$sem_sql[$i];
    $date_affichage=$sem_affichage[$i];
    $date_mail=$sem_mail[$i];
    $h = $_POST['heure'];
    $mail2 = $_POST['mail2'];

    //Si la connexion est de type arbitre le joueur1 correspond au mail1 (différent de l'arbitre) et la réservation est de type tournoi
    if ($typeConnexion=="arbitre") {
        $type = 'tournoi';
        $mail1 = $_POST['mail1'];
    }
    //Si la connexion est de type adhérent le mail1 correspond automatiquement à la personne qui reserve et la réservation est de type entrainement
    else if ($typeConnexion=="adherent"){
        $type = 'entrainement';
        $mail1 = $mail;
    }

    //requête sur la bd pour savoir si le créneau rentré dans le formulaire est déjà réservé (déjà dans la base de donnée)
    $reponse = $bdd->prepare("select * from reservations where date ='$date' and h_deb='$h' and court='$court'");
    $reponse -> execute();
    $donnees = $reponse->fetchAll();
    $compteur = count(array_column($donnees, 'adresse_mail'));

    //Si le créneau n'est pas dans la bd (le créneau est libre)
    if ($compteur == 0) {
        //Si l'arbitre a reservé un match opposant la même unique personne ou si l'adhérent a reservé un créneau avec lui-même
        if($mail1==$mail2){
        
        //Popup ouvrante / fermante (le div et la croix fermante s'affichent une fois que la pop-pup ouvrante est activé)
        ?>
        <div class="Popup" id="popup_joueurs_identiques" > 
                <div class='Popupencart'> 
                    <p> Vous ne pouvez pas réserver ce créneau pour une seule personne </p>
                    <button class="pointeur" onclick="redirection('planning.php')">&times;</button>
                </div>
        </div>

        <script> 
            popup_ouvrante(document.getElementById('popup_joueurs_identiques')); 
        </script> 
    
        <?php
        }

        //Sinon
        else{
            //La reservation s'effectue (on insère les joueurs, le type et le créneau)
            $req = $bdd->prepare("insert into reservations values('$mail','$date','$court','$h','$type','$mail1','$mail2')");
            $req->execute();


            //Pop-pup ouvrante / fermante (même principe que précédemment) confirmant la réservation
            //On redirige vers la page pour l'update
            ?>
            <div class="Popup" id="popup_reservation_réussie" > 
                    <div class='Popupencart'>  
                        <p> <?php echo 'Réservation du court '.$court.'<br/>'. ' le ' .$date_mail.' à ' .$h. ' h';?> </p>
                        <button class="pointeur" onclick="redirection('planning.php')">&times;</button>
                    </div>
            </div>
            <?php

            //Envoie du mail de confirmation du créneau de réservation
            include('mail.php');
            if (envoyer_mail_reservation($mail1, $mail2, $date_mail, $h, $court, $type)) {
                ?>
                <script> 
                    popup_ouvrante(document.getElementById('popup_reservation_réussie')); 
                </script>
                <?php
            }
            else {
                ?>
                <script> 
                    popup_ouvrante(document.getElementById('popup_reservation_réussie')); 
                </script>
                <?php
            }
        }
    }

    //Si le créneau choisi est déjà réservé 
    else {
        //Pop-pup erreur   
        ?>
        <div class="Popup" id="popup_reservation_ratée" > 
                <div class='Popupencart'> 
                    <p> Ce créneau est déjà réservé </p>
                    <button class="pointeur" onclick="redirection('planning.php')">&times;</button>
                </div>
        </div>

        <script> 
            popup_ouvrante(document.getElementById('popup_reservation_ratée')); 
        </script> 
        
        <?php    }
    ?>

    </body>
</html>