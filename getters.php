<?php
//connexion à la base de données

    function get_tournament_state() {
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from tournois ORDER by num DESC");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        $compteur =count(array_column($row, 'num'));
        if ($compteur>0){
            return $row[0]['situation'];
        }
        else{
            return '';
        }
    }

    function is_moderator($mail){
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from arbitres where adresse_mail = '$mail'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['moderateur'];
    }

    function get_classement($mail){
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from adherents where adresse_mail = '$mail'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['classement'];
    }

    function get_prenom_nom($mail,$type){
        $bdd = $GLOBALS['bdd'];
        if ($type == 'administrateur') {
            $reponse = $bdd->prepare("select * from administrateurs where adresse_mail = '$mail'");
        }
        else if($type=='arbitre'){
            $reponse = $bdd->prepare("select * from arbitres where adresse_mail = '$mail'");
        }
        else if($type=='adherent'){
            $reponse = $bdd->prepare("select * from adherents where adresse_mail = '$mail'");
        }
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['prenom'].' '.$row[0]['nom'];
    }

    function get_id($mail,$type){
        $bdd = $GLOBALS['bdd'];
        if($type=='adherent'){
            $reponse = $bdd->prepare("select * from adherents where adresse_mail = '$mail'");
        }
        else if($type=='arbitre'){
            $reponse = $bdd->prepare("select * from arbitres where adresse_mail = '$mail'");
        }
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['id'];

    }

    function is_adherent_banned($mail){
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from adherents where adresse_mail = '$mail'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['banni'];
    }

    function get_nombre_inscrit($num_tournoi){
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from inscrits where num = '$num_tournoi'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        $c=count(array_column($row, 'mail'));
        return $c;
    }

    function get_nombre_max_tournoi($num_tournoi){
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from tournois where num = '$num_tournoi'");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['nb_max'];
    }

    function get_last_num_tournoi(){
        $bdd = $GLOBALS['bdd'];
        $reponse = $bdd->prepare("select * from tournois ORDER by num DESC");
        $reponse -> execute();
        $row = $reponse->fetchAll();
        return $row[0]['num'];
    }

  function getIdById($id, $typeConnexion){
    $bdd = $GLOBALS['bdd'];
    if ($typeConnexion == "arbitre"){
      $req = $bdd->prepare("select id from arbitres where adresse_mail = '$id'");
    }
    else if($typeConnexion == "administrateur"){
      $req = $bdd->prepare("select id from administrateurs where adresse_mail = '$id'");
    }
    else {
      $req = $bdd->prepare("select id from adherents where adresse_mail = '$id'");
    }
    $req -> execute();
    $res = $req->fetchAll();/*normalement il n'y a qu'1 résultat car on a fait attention lors de l'inscription*/
    return $res[0][0];
  }

  function getNameById($id, $typeConnexion) {
    $bdd = $GLOBALS['bdd'];
    if ($typeConnexion == "arbitre"){
      $req = $bdd->prepare("select nom from arbitres where adresse_mail = '$id'");
    }
    else if($typeConnexion == "administrateur"){
      $req = $bdd->prepare("select nom from administrateurs where adresse_mail = '$id'");
    }
    else {
      $req = $bdd->prepare("select nom from adherents where adresse_mail = '$id'");
    }
    $req -> execute();
    $res = $req->fetchAll();/*normalement il n'y a qu'1 résultat car on a fait attention lors de l'inscription*/
    return $res[0][0];
  }

  function getFirstNameById($id, $typeConnexion) {
    $bdd = $GLOBALS['bdd'];
    if ($typeConnexion == "arbitre"){
      $req = $bdd->prepare("select prenom from arbitres where adresse_mail = '$id'");
    }
    else if($typeConnexion == "administrateur"){
      $req = $bdd->prepare("select prenom from administrateurs where adresse_mail = '$id'");
    }
    else {
      $req = $bdd->prepare("select prenom from adherents where adresse_mail = '$id'");
    }
    $req -> execute();
    $res = $req->fetchAll();
    return $res[0][0];/*normalement il n'y a qu'1 résultat car on a fait attention lors de l'inscription*/
  }

  function getBirthDateById($id, $typeConnexion) {
    $bdd = $GLOBALS['bdd'];
    if ($typeConnexion == "arbitre"){
      $req = $bdd->prepare("select date_naiss from arbitres where adresse_mail = '$id'");
    }
    else if($typeConnexion == "administrateur"){
      $req = $bdd->prepare("select date_naiss from administrateurs where adresse_mail = '$id'");
    }
    else {
      $req = $bdd->prepare("select date_naiss from adherents where adresse_mail = '$id'");
    }
    $req -> execute();
    $res = $req->fetchAll();
    $date = $res[0][0];/*normalement il n'y a qu'1 résultat car on a fait attention lors de l'inscription*/
    $date = strtotime($date);
    $date = date('d/m/Y', $date);
    return $date;
  }

  function getAddressById($id) {
    $bdd = $GLOBALS['bdd'];
    $req = $bdd->prepare("select adresse from adherents where adresse_mail = '$id'");
    $req -> execute();
    $res = $req->fetchAll();
    return $res[0][0];/*normalement il n'y a qu'1 résultat car on a fait attention lors de l'inscription*/
  }

?>