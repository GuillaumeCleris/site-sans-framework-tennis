<?php 

//Template de mail pour une inscription d'adhérent
function template_inscription($mail) {
    $identite = get_prenom_nom($mail,"adherent");
    $message = "
    <html>
        <head>
            <title>Merci pour votre inscription sur WIImblEdon</title>
        </head>
        <body>
            <p>Bienvenue sur WIImblEdon ".$identite." !</p>
            <p>Vous pouvez dès à présent réserver des courts pour vous entrainer ou participer aux tournois organisés.</p>
            <p>Cordialement,</p>
            <p>L'équipe WIImblEdon</p>
        </body>
    </html>
    "; 
    return $message;
}

//Template de mail pour une inscription d'arbitre ou d'administrateur (par un administrateur)
function template_ajout($mail, $type) {
    $bdd = $GLOBALS['bdd'];
    if ($type == "arbitre") {
        $req1 = $bdd->prepare("select prenom, nom, mdp from arbitres where adresse_mail = '$mail'");
    }
    else {
        $req1 = $bdd->prepare("select prenom, nom, mdp from administrateurs where adresse_mail = '$mail'");
    }
    $req1->execute();
    $new = $req1->fetchAll();
    $prenom = $new[0][0];
    $nom = $new[0][1];
    $mdp = $new[0][2];
    $message = "
        <html>
            <head>
                <title>Création d'un compte ".$type." WIImblEdon à votre nom</title>             
            </head>
            <body>
                <p>Bienvenue sur WIImblEdon ".$prenom." ".$nom." !</p>
                <p>Notre équipe vous a créé un compte ".$type." avec cette adresse mail. Pour votre première connexion, veuillez utiliser : </p>
                <p>Identifiant : ".$mail."</p>
                <p>Mot de passe : ".$mdp."</p>
                <p>Cordialement,</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

function template_inscription_tournoi($mail) {
    $bdd = $GLOBALS['bdd'];
    $num_tournoi = get_last_num_tournoi();
    $req = $bdd->prepare("select nom_tournoi from tournois where num='$num_tournoi'");
    $req->execute();
    $tournoi = $req->fetchAll();
    $nom_tournoi = $tournoi[0][0];
    $identite = get_prenom_nom($mail,"adherent");
    $message = "
        <html>
            <head>
                <title>Confirmation de votre inscription au tournoi WIImblEdon</title>
            </head>
            <body>
                <p>Bonjour ".$identite.",</p>
                <p>Votre inscription au tournoi ".$nom_tournoi." a bien été prise en compte. L'arbre des tournois sera bientôt accessible dans votre espace. Vous recevrez un mail vous précisant les détails de chaque rencontre.</p>
                <p>Cordialement,</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

function template_modification($mail, $type) {
    if ($type == "modif_arbitre") {
        $statut = "arbitre";
    }
    else if ($type == 'modif_admin') {
        $statut = "administrateur";
    }
    else {
        $statut = "adherent";
    }
    $identite = get_prenom_nom($mail, $statut);
    $message = "
        <html>
            <head>
                <title>Modification de l'adresse mail liée à votre compte WIImblEdon</title>
            </head>
            <body>
                <p>Bonjour ".$identite.",</p>
                <p>La modification de l'adresse mail liée à votre compte ".$statut." WIImblEdon a bien été prise en compte.</p>
                <p>Si vous n'êtes pas à l'origine de cette modification, veuillez nous le signaler.</p>
                <p>Cordialement,</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

function template_bannissement($mail) {
    $identite = get_prenom_nom($mail,"adherent");
    $message = "
        <html>
            <head>
                <title>Information - Perte de vos droits d'adhérent</title>
            </head>
            <body>
                <p>Bonjour ".$identite.",</p>
                <p>Nous vous informons que vous avez temporairement perdu vos droits d'adhérents. Veuillez contacter rapidement un membre de l'équipe.</p>
                <p>Cordialement,</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

//mail1 : email de celui qui crée, mail2 : email créé dans le cas d'une inscription
//mail1 : email de celui qui réserve, mail2 email de son adversaire dans le cas d'une reservation
//mail1 : email de celui qui s'inscrit, mail2 : idem dans le cas d'une inscription à un tournoi
//mail1 : email du joueur 1, mail2 : email du joueur 2 dans le cas d'un match de tournoi
function envoyer_mail_compte($mail, $type) {
    if ($type == "inscription") {
        $message = template_inscription($mail);
        $sujet = "Merci pour votre inscription sur WIImblEdon";
    }
    else if ($type == "ajout_arbitre") {
        $message = template_ajout($mail, "arbitre");
        $sujet = "Création d'un compte arbitre WIImblEdon à votre nom";
    }
    else if ($type == "ajout_admin") {
        $message = template_ajout($mail, "administrateur");
        $sujet = "Création d'un compte administrateur WIImblEdon à votre nom";
    }

    else if ($type == "inscription_tournoi") { 
        $message = template_inscription_tournoi($mail);
        $sujet = "Confirmation de votre inscription au tournoi WIImblEdon";
    }
    else if ($type == "bannissement") {
        $message= template_bannissement($mail);
        $sujet = "Information - Perte de vos droits d'adhérent";
    }
    else {//modification de l'adresse mail du compte
        $message = template_modification($mail, $type);
        $sujet = "Modification de l'adresse mail liée à votre compte WIImblEdon";
    }
    $message = wordwrap($message,70);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <no-reply@wiimbledon.org>' . "\r\n";
    $bool = mail($mail,$sujet,$message,$headers);
    return $bool;
}
//changement coord : si ce n'est pas vous...



function template_reservation1($identite1, $identite2, $date, $heure, $court) {
    $message = "
        <html>
            <head>
                <title>Réservation d'un court à votre nom</title>
            </head>
            <body>
                <p>Bonjour ".$identite2.",</p>
                <p>".$identite1." a réservé le court ".$court." le ".$date." à ".$heure."h. </p>
                <p>Bon match !</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

function template_reservation2($identite1, $identite2, $date, $heure, $court) {
    $message = "
        <html>
            <head>
                <title>Confirmation de votre réservation</title>
            </head>
            <body>
                <p>Bonjour ".$identite2.",</p>
                <p>Nous vous confirmons la réservation du court ".$court." le ".$date." à ".$heure."h avec ".$identite1.". </p>
                <p>Bon match !</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

function template_reservation_tournoi($identite1, $identite2, $date, $heure, $court) {
    $message = "
        <html>
            <head>
                <title>Rencontre tournoi WIImblEdon</title>
            </head>
            <body>
                <p>Bonjour ".$identite1.",</p>
                <p>vous jouerez contre ".$identite2." sur le court ".$court." ".$date." à ".$heure."h.</p>
                <p>Bon match !</p>
                <p>L'équipe WIImblEdon</p>
            </body>
        </html>
    ";
    return $message;
}

function envoyer_mail_reservation($mail1, $mail2, $jour, $heure, $court, $type) {
    $identite1 = get_prenom_nom($mail1,"adherent");

    $identite2 = get_prenom_nom($mail2,"adherent");

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <no-reply@wiimbledon.org>' . "\r\n";

    if ($type == "entrainement") {
        $message1 = template_reservation1($identite1, $identite2, $jour, $heure, $court);
        $message1 = wordwrap($message1,70);
        $message2 = template_reservation2($identite2, $identite1, $jour, $heure, $court);
        $message2 = wordwrap($message2,70);
        $sujet1 = "Réservation d'un court à votre nom";
        $sujet2 = "Confirmation de votre réservation";
        $bool1 = mail($mail2,$sujet1,$message1,$headers);
        $bool2 = mail($mail1,$sujet2,$message2,$headers);
    }
    else { //tournoi
        $message1 = template_reservation_tournoi($identite1, $identite2, $jour, $heure, $court);
        $message1 = wordwrap($message1,70);
        $message2 = template_reservation_tournoi($identite2, $identite1, $jour, $heure, $court);
        $message2 = wordwrap($message2,70);
        $sujet = "Rencontre tournoi WIImblEdon";
        $bool1 = mail($mail1,$sujet,$message1,$headers);
        $bool2 = mail($mail2,$sujet,$message2,$headers);
    }
    return ($bool1 && $bool2);
}


?>