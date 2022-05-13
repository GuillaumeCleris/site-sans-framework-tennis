<?php
//Récupération des informations du formulaire de création du tournoi
$nomTournoi = htmlspecialchars($_POST['nom_tournoi']);
$nbParticipantsMax = $_POST['nb_participant_max'];

//initialisation du numéro du nouveau tournoi
$result = $bdd->prepare("select * from tournois");
$result ->execute();
$row = $result->fetchAll();
$num=count(array_column($row, 'num'))+1;

//creation/insertion du tournoi dans la base de donnée
$insertion = $bdd->prepare("insert into tournois values('$num', :nomTournoi, '$nbParticipantsMax', 0, 'A definir','inscription')");
$insertion -> bindValue(':nomTournoi',$nomTournoi,PDO::PARAM_STR);
$insertion -> execute();

//on met le créateur du tournoi en tant que modérateur
$bool = true;
$id_mail = $_SESSION['id_mail'];
$update = $bdd->prepare("UPDATE arbitres SET moderateur = '$bool' WHERE adresse_mail = '$id_mail' ");
$update->execute();
?>

<?php
//affichage de la barre de menus et du pied de page
$typeConnexion = $_SESSION["typeConnexion"];
include('menu_bar.php');
include('pieds_de_page.php');

//pop_up de redirection
?>
<div class="Popup" id="creation_tournoi"> 
   <div class='Popupencart'>
       <p> <?php echo 'Le tournoi : '.$nomTournoi.' a été crée.'; ?> </p>
   </div>
</div>
<script> 
   popup_et_redirection(document.getElementById('creation_tournoi'),'tournoi.php'); 
</script>