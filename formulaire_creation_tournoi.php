<div class="style-formulaire">
    <h1> Création de tournoi</h1>
    <form action="" method="post">
        <fieldset>
            <p>
            <label for="nom_tournoi">Nom du tournoi</label><br>
            <input type="text" id="nom_tournoi" name="nom_tournoi"><br>
            <label for="nb_participant_max">Nombre de participants maximum :</label><br/>
                <select name="nb_participant_max" id="nb_participant_max">
                    <option value="8"> 8 participants</option></br>
                </select>
            </br>
            <button type="submit" name="creation_tournoi">Confirmer</button>
            </p>
        </fieldset>
    </form>
</div>

<?php
if(isset($_POST['creation_tournoi'])){
  include("tournoi_creation_process.php");
  unset($_POST);
}
?>