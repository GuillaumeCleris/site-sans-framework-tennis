<?php 
    include("connexion_bd.php");
    $bdd = connect();
    include("situation_tournoi.php");


    if(isset($_POST['hashage'])){
        $select_AAA = $bdd -> prepare("select * from administrateurs");
        $select_AAA -> execute();
        $all_AAA = $select_AAA -> fetchAll();
        $compteur = count(array_column($all_AAA, 'adresse_mail'));

        $i = 0;
        while($i<$compteur){
            $id = $all_AAA[$i]['id'];
            $mdp = $all_AAA[$i]['mdp'];
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            $update = $bdd -> prepare("update administrateurs set mdp = '$mdp' where id = '$id' ");
            $update -> execute();
            $i++;
        }



        $select_AA = $bdd -> prepare("select * from arbitres");
        $select_AA -> execute();
        $all_AA = $select_AA -> fetchAll();
        $compteur = count(array_column($all_AA, 'adresse_mail'));

        $i = 0;
        while($i<$compteur){
            $id = $all_AA[$i]['id'];
            $mdp = $all_AA[$i]['mdp'];
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            $update = $bdd -> prepare("update arbitres set mdp = '$mdp' where id = '$id' ");
            $update -> execute();
            $i++;
        }


        $select_A = $bdd -> prepare("select * from adherents");
        $select_A -> execute();
        $all_A = $select_A -> fetchAll();
        $compteur = count(array_column($all_A, 'adresse_mail'));

        $i = 0;
        while($i<$compteur){
            $id = $all_A[$i]['id'];
            $mdp = $all_A[$i]['mdp'];
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            $update = $bdd -> prepare("update adherents set mdp = '$mdp' where id = '$id' ");
            $update -> execute();
            $i++;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Mini projet</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="fonction.js"></script>
    </head>
 
    <body>
        <nav class="menu-bar">
        <ul>
            <li>
            <h1>WIImblEdon</h1>
            </li>
        </ul>
        </nav>
    <?php
    
    include("pieds_de_page.php");
    ?>
        
        
        <article>
        <form action="" method="post">
            <section>
            <button type="submit" name="hashage" value="hashage">Cliquez ici pour hasher les mdp</button>
            </section>
        </form>
        </article>
        <?php
        if(isset($_POST['hashage'])){  
            ?>
            <script> 
                redirection('accueil.php'); 
            </script>
            <?php
        }
        ?>
          
        
        
    </body>
</html>
