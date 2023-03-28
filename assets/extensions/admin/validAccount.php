<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

    //vérifier si l'utilisateur est admin
    isAdmin();

    //Vérifier si l'utilisateur est ban du site
    isBan();
    
    $id = $_GET['id'];

    if(!isset($id)) {
        redirectUrl('/admin/');
    } else {
        validAccount($id);
        redirectUrl('/admin/pages/user/utilisateur.php');
    }

?>