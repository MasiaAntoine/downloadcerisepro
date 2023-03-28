<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();
    
    $idToken = $_GET["idToken"];
    $data = recupToken($idToken);
    // var_dump($data);

    //si le get token est défini
    if($idToken != "false") {
        if(!isset($idToken)) {
            redirectUrl("/");
        }
    }

    //Si le token existe en base de donnée
    if($data == null) {
        redirectUrl("/connexion");
    }

    $email = $data['Mail'];
    // var_dump($email);

    // var_dump($data['Date']);
    //vérifie si le token n'as pas expiréré à 15 minutes suppérieur
    if(time() > $data['Date']+900) {
        echo("Votre token a expiré, un nouveau vient d'être envoyé par email.<br/>");
        echo("Vérifier vos spams si l'email n'apparaît pas.<br/>");
        echo("Vous pouvez fermer cette page après l'avoir lu.<br/>");

        $date = time();
        $newIdT = rand(100000, 999999).time();
        updateExpireToken($date,$idToken,$newIdT);

        //envoyer un email avec le lien "token$newIdT"
        mailConfirmation($email,$newIdT);

    } else {
        validAccountToken($email);
        echo("Compte confirmé avec succès !<br/>");
        echo("Vous pouvez maintenant vous <a href='/connexion'>connectez</a> à votre compte.<br/>");
        echo("Vous pouvez fermer cette page après l'avoir lu.<br/>");
    }
?>