<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

    //Récupère les données Paypal
    $json = json_decode($_POST['form'], true);
    //var_dump($json);

    //Si la transaction n'a pas eu lieu rediriger
    if(!isset($json)) {
        $outil->redirectUrl("/");
    }

    //Récupère les données qui m'interesse renvoyé par paypal
    $IdTransaction = $json['id'];
    $IdPaypalPayer = $json['payer']['payer_id'];
    $IdUser = $_SESSION['idUser'];

    //Récupère mes données perso
    $MyData = explode("|",$json['purchase_units'][0]['custom_id']);
    $IdArticle = $MyData[0];
    $TauxTVA = $MyData[1];

    $Status = $json['status'];

    $Prix = $json['purchase_units'][0]['amount']['value'];
    $Devise = $json['purchase_units'][0]['amount']['currency_code'];
    $Pays = $json['payer']['address']['country_code'];
    $DateVente = time();
    $Cerise = (int) filter_var($json['purchase_units'][0]['items'][0]['description'], FILTER_SANITIZE_NUMBER_INT);

    $AdresseRue = $json['purchase_units'][0]['shipping']['address']['address_line_1'];
    $CodePostal = $json['purchase_units'][0]['shipping']['address']['postal_code'];
    $Ville = $json['purchase_units'][0]['shipping']['address']['admin_area_2'];

    $Adresse = $AdresseRue.", ".$CodePostal." ".$Ville;

    $dataUser = dataUser($IdUser);
    $Nom = $dataUser['Nom'];
    $Prenom = $dataUser['Prenom'];
    $email = $dataUser['Mail'];

    //var_dump($Adresse);

    //Génére le numéro de facture
    $NumeroFacture = $Pays."-".date("d-m-Y", $DateVente)."-".$IdUser.date("His", $DateVente);

    //Ajoute les cerises au compte de l'utilisateur
    addCerise($Cerise,$IdUser);

    //ajoute la vente en bdd
    addVente($IdTransaction, $IdPaypalPayer, $IdUser, $Nom, $Prenom, $IdArticle, $Status, $Prix, $Devise, $Pays, $Cerise, $NumeroFacture, $TauxTVA, $Adresse);

    //mail pour le client
    mailAchat($email,$Prix,$NumeroFacture);
    //Envoi un mail à l'admin
    mailVenteNotification($Prix,$NumeroFacture);