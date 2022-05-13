<?php 
//Accès à la base de données via les fichiers qui l'appellent

//Fonctions qui permettent de générer un id : le max parmi ceux qui existent déjà + 1
function creerIdAdherent() {
    $bdd = connect();
    $req = $bdd->prepare("select id from adherents");
    $req->execute();
    $liste_id = $req->fetchAll();
    $c = count(array_column($liste_id, 'id'));
    $i = 0;
    $max = 0;
    for($i=0;$i<$c;$i++) {
        $id = $liste_id[$i];
        $sep = explode('-', $id[0]);
        $num = $sep[1];
        if ($max < $num) {
            $max = $num;
        }
    }
    return 'A-'.($max+1);
}

function creerIdArbitre() {
    $bdd = connect();
    $req = $bdd->prepare("select id from arbitres");
    $req->execute();
    $liste_id = $req->fetchAll();
    $c = count(array_column($liste_id, 'id'));
    $i = 0;
    $max = 0;
    for($i=0;$i<$c;$i++) {
        $id = $liste_id[$i];
        $sep = explode('-', $id[0]);
        $num = $sep[1];
        if ($max < $num) {
            $max = $num;
        }
    }
    return 'AA-'.($max+1);
}

function creerIdAdministrateur() {
    $bdd = connect();
    $req = $bdd->prepare("select id from administrateurs");
    $req->execute();
    $liste_id = $req->fetchAll();
    $c = count(array_column($liste_id, 'id'));
    $i = 0;
    $max = 0;
    for($i=0;$i<$c;$i++) {
        $id = $liste_id[$i];
        $sep = explode('-', $id[0]);
        $num = $sep[1];
        if ($max < $num) {
            $max = $num;
        }
    }
    return 'AAA-'.($max+1);
}

?>