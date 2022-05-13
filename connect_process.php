<?php 
    //récupération des entrées de la page de connexion
    $mail = htmlspecialchars($_POST['adresse_mail']);
    $mdp = htmlspecialchars($_POST['motDePasse']);
    $typeConnexion = $_POST['typeConnexion'];
    $message='';
    
    $try="";
    if($typeConnexion=="adherent"){
        //requête sur la bd pour récupérer nom et prénom de l'utilisateur et vérifier qu'il est inscrit
        $result = $bdd->prepare("select * from adherents");
        $result ->execute();
        $row = $result->fetchAll();
        $c=count(array_column($row, 'adresse_mail'));
        
        $i=0;
        while($i<$c and $try=="") {
            $resemail = $row[$i]['adresse_mail'];
            $resmdp = $row[$i]['mdp'];
            $resname = $row[$i]['prenom'];
            $resfname = $row[$i]['nom'];
            //if ($resemail==$mail && $resmdp==$mdp) {
            if ($resemail==$mail && password_verify($mdp, $resmdp)) {
                $try="adherent";
            }
            $i++;
        }
    }
    if($typeConnexion=="arbitre"){
        $result = $bdd->prepare("select * from arbitres");
        $result ->execute();
        $row = $result->fetchAll();
        $c=count(array_column($row, 'adresse_mail'));
        
        $i=0;
        while($i<$c and $try=="") {
            $resemail = $row[$i]['adresse_mail'];
            $resmdp = $row[$i]['mdp'];
            $resname = $row[$i]['prenom'];
            $resfname = $row[$i]['nom'];
            //if ($resemail==$mail && $resmdp==$mdp) {
            if ($resemail==$mail && password_verify($mdp, $resmdp)) {
                $try="arbitre";
            }
            $i++;
        }
    }
?>

    <?php
         //redirection vers la page de connexion et pop-up en cas d'échec de la connexion
    if($try=="adherent"){
        if(is_adherent_banned($mail)){
            $_SESSION["connecter"]="non";
            

            $message='Vous n\'avez pas accès au site';


            
             /*
            
            <div class="Popup" id="adherent banni"> 
                <div class='Popupencart'><p> Vous n\'avez pas accès au site </p></div>
            </div>
            <script> popup_sans_redirection(document.getElementById('adherent banni')); 
            </script>

            <script> 
                popup_redirection('Vous n\'avez pas accès au site','connexion.php');
            </script>*/

        }
        else{
            $_SESSION['id_mail']=$mail;
            $_SESSION['id']=get_id($mail,'adherent');
            $_SESSION["connecter"]="oui";
            $_SESSION["typeConnexion"]="adherent";
            
            ?>
            <script> redirection('accueil.php'); </script>
            <?php 
            /*
            <div class="Popup" id="popup123"> 
                <div class='Popupencart'><p> <?php echo 'Bonjour '.' '.$resname.' '.$resfname;?> </p></div>
            </div>


            <script> popup_et_redirection(document.getElementById('popup123'),'planning.php'); 
            </script>

            
            <script>  popup_redirection("<?php echo 'Bonjour '.' '.$resname.' '.$resfname; ?>",'planning.php');
            </script>*/
        }
    }
    else if ($try=="arbitre"){
        $_SESSION['id_mail']=$mail;
        $_SESSION['id']=get_id($mail,'arbitre');
        $_SESSION["connecter"]="oui";
        $_SESSION["typeConnexion"]="arbitre";
        

         ?>
            <script> redirection('accueil.php'); </script>
        <?php 
        /*
        <script>  popup_redirection("<?php echo 'Bonjour '.' '.$resname.' '.$resfname; ?>",'accueil.php');
        </script>
        */
    }
    else{
        $_SESSION["connecter"]="non";
        $message='Votre identifiant ou votre mot de passe est incorrect.'.'<br/>'.'Veuillez egalement cocher la bonne case.';
       
        /*
         <div class="Popup" id="connexion raté"> 
                <div class='Popupencart'><p> Votre identifiant ou votre mot de passe est incorrect. <br/> Veuillez egalement cocher la bonne case. </p></div>
        </div>

        <script> popup_sans_redirection(document.getElementById('connexion raté')); 
        </script>

        */


          /*
        <script> popup_redirection('Votre identifiant ou votre mot de passe est incorrect. Veuillez egalement cocher la bonne case','connexion.php');
        </script>*/
       
    }?>
