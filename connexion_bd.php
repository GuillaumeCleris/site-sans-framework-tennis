<?php
//connexion à la base de données
function connect() {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	try
	{	
	  return new PDO("pgsql:host=pgsql2;dbname=projet_web_marine_guiraud;user=tpcurseurs;password=tpcurseurs");
	}
	catch (Exception $e)
	{
	  echo "<p>Impossible de se connecter: " . $e->getMessage() ."</p>";
	}
}
?>