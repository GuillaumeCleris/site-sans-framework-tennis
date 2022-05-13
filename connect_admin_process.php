<?php 
    //récupération des entrées de la page de connexion
    $id = htmlspecialchars($_POST['identifiant']);
    $mdp = htmlspecialchars($_POST['motDePasse']);
    $message='';

    //requête sur la bd pour récupérer nom et prénom de l'utilisateur et vérifier qu'il est inscrit
    $result = $bdd->prepare("select * from administrateurs");
    $result ->execute();
    $row = $result->fetchAll();
    $c=count(array_column($row, 'adresse_mail'));

    $bool = true;
    $i = 0;
    while($i<$c && $bool){
        $resemail = $row[$i]['adresse_mail'];
        $resmdp = $row[$i]['mdp'];
        $resname = $row[$i]['prenom'];
        $resfname = $row[$i]['nom'];
        //if ($resemail==$id && $resmdp==$mdp) {
        if ($resemail==$id && password_verify($mdp, $resmdp)) {
            $bool=false;
            
        }
        $i++;
    }

    //redirection vers la page de connexion et pop-up en cas d'échec de la connexion
    if(!$bool){
        $_SESSION['id_mail_admin']=htmlspecialchars($_POST['identifiant']);
        $_SESSION["connecter_admin"]="oui";
        ?>
            <script> redirection('accueil_admin.php'); </script>
        <?php 
    }
    else{
        $_SESSION["connecter_admin"]="non";
        $message = 'Votre identifiant ou votre mot de passe est incorrect.';
    }

?>