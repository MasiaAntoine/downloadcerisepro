<?php

    //Mail pour la confirmation de compte
    function mailConfirmation($email,$idToken) {
        $toMail = openssl_decrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $subjectMail = "Confirmation de votre compte download cerise pro";
        $urlValidationMail = getUrl(false)."/verifToken.php?idToken=$idToken";
        
        // Créer le corps de l'email en HTML
        $messageMail = "<html>";
        $messageMail .= "<body>";
        $messageMail .= "<h1>Confirmation de votre compte download cerise pro</h1>";
        $messageMail .= "<p>Bonjour,</p>";
        $messageMail .= "<p>Nous avons récemment reçu votre demande de création de compte avec download cerise pro. Pour finaliser votre inscription, veuillez cliquer sur le lien de confirmation ci-dessous :</p>";
        $messageMail .= "<p>$urlValidationMail</p>";
        $messageMail .= "<p>Une fois que vous aurez cliqué sur ce lien, votre compte sera créé et vous pourrez accéder à tous nos services. Si vous rencontrez des problèmes ou si vous avez des questions, n'hésitez pas à nous contacter.</p>";
        $messageMail .= "<p>Nous espérons que vous apprécierez notre service et que vous en tirerez le meilleur parti.</p>";
        $messageMail .= "<p>Cordialement,</p>";
        $messageMail .= "<p>L'équipe download cerise pro</p>";
        $messageMail .= "</body>";
        $messageMail .= "</html>";
        
        // En-têtes supplémentaires pour envoyer un email en HTML
        $headersMail[] = 'MIME-Version: 1.0';
        $headersMail[] = 'Content-type: text/html; charset=utf-8';
        $headersMail[] = 'From: no-replay@downloadcerisepro.fr';
        $headersMail[] = 'Reply-To: no-replay@downloadcerisepro.fr';
        
        // Envoyer l'email
        mail($toMail, $subjectMail, $messageMail, implode("\r\n", $headersMail));
    }

    //Ce mail me permet de notifier l'adminisateur du site pour être informer des nouvelles fiches
    function mailNouvelleFicheNotification($correspondance) {
        $toMail = "pro.antoine.masia@gmail.com";
        $subjectMail = "Notification de fiche à corriger download cerise pro";
        $urlConnexionAdmin = getUrl(false)."/admin/pages/fiche/ficheAttente.php";
        
        // Créer le corps de l'email en HTML
        $messageMail = "<html>";
        $messageMail .= "<body>";
        $messageMail .= "<h1>Notification de fiche à corriger</h1>";
        $messageMail .= "<p>Une fiche vous a été envoyée à corriger sur votre site, correspondant $correspondance. Veuillez vous <a href='$urlConnexionAdmin'>connecter</a> à votre compte pour la consulter et suivre les instructions indiquées pour la traiter.</p>";
        $messageMail .= "</body>";
        $messageMail .= "</html>";
        
        // En-têtes supplémentaires pour envoyer un email en HTML
        $headersMail[] = 'MIME-Version: 1.0';
        $headersMail[] = 'Content-type: text/html; charset=utf-8';
        $headersMail[] = 'From: notif-admin@downloadcerisepro.fr';
        $headersMail[] = 'Reply-To: notif-admin@downloadcerisepro.fr';
        
        // Envoyer l'email
        mail($toMail, $subjectMail, $messageMail, implode("\r\n", $headersMail));
    }

    //Ce mail me permet de notifier l'utilisateur que ça fiche est refuser avec la raison.
    function mailRefuserFiche($email,$raison,$correspondance) {
        $toMail = openssl_decrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $subjectMail = "Fiche refusée download cerise pro";
        
        // Créer le corps de l'email en HTML
        $messageMail = "<html>";
        $messageMail .= "<body>";
        $messageMail .= "<h1>Fiche refusée</h1>";
        $messageMail .= "<p>Bonjour,</p>";

        $messageMail .= "<p>Je suis désolé de vous informer que j'ai dû refuser la fiche que vous m'avez envoyée pour validation, correspondant à $correspondance. ";
        if($raison == 0) {
            $messageMail .= "Malheureusement, le fichier PDF était incomplet et je ne pouvais pas poursuivre la validation.</p>";
            $messageMail .= "<p>Veuillez noter que cette fiche ne s'affichera pas sur le site tant qu'elle n'a pas été corrigée et validée. Cependant, vous pouvez toujours la renvoyer une fois corrigée en suivant les instructions indiquées sur votre compte.</p>";
        }
        if($raison == 1) {
            $messageMail .= "Malheureusement, il y avait trop de fautes d'orthographe récurrentes dans le document et je ne pouvais pas poursuivre la validation.</p>";
            $messageMail .= "<p>Veuillez vous assurer de vérifier attentivement votre document avant de le soumettre pour éviter ce genre de problème à l'avenir. Cette fiche ne s'affichera pas sur le site tant qu'elle n'a pas été corrigée et validée. Cependant, vous pouvez toujours la renvoyer une fois corrigée en suivant les instructions indiquées sur votre compte.</p>";
        }
        if($raison == 2) {
            $messageMail .= "Malheureusement, le langage utilisé dans le document était incorrect et je ne pouvais pas poursuivre la validation.</p>";
            $messageMail .= "<p>Veuillez vous assurer d'utiliser un langage professionnel et approprié dans vos documents pour éviter ce genre de problème à l'avenir. Cette fiche ne s'affichera pas sur le site tant qu'elle n'a pas été corrigée et validée. Cependant, vous pouvez toujours la renvoyer une fois corrigée en suivant les instructions indiquées sur votre compte.</p>";
        }
        if($raison == 3) {
            $messageMail .= "Malheureusement, le fichier PDF ne s'ouvre pas en raison d'un mauvais encodage et je ne peux pas poursuivre la validation.</p>";
            $messageMail .= "<p>Veuillez vous assurer de vérifier l'encodage de votre fichier PDF avant de le soumettre pour éviter ce genre de problème à l'avenir. Cette fiche ne s'affichera pas sur le site tant qu'elle n'a pas été corrigée et validée. Cependant, vous pouvez toujours la renvoyer une fois corrigée en suivant les instructions indiquées sur votre compte.</p>";
        }

        $messageMail .= "<p>Je vous remercie de votre compréhension et suis à votre disposition si vous avez des questions ou des besoins supplémentaires.</p>";
        $messageMail .= "<p>Download Cerise Pro</p>";

        $messageMail .= "</body>";
        $messageMail .= "</html>";
        
        // En-têtes supplémentaires pour envoyer un email en HTML
        $headersMail[] = 'MIME-Version: 1.0';
        $headersMail[] = 'Content-type: text/html; charset=utf-8';
        $headersMail[] = 'From: no-replay@downloadcerisepro.fr';
        $headersMail[] = 'Reply-To: no-replay@downloadcerisepro.fr';
        
        // Envoyer l'email
        mail($toMail, $subjectMail, $messageMail, implode("\r\n", $headersMail));
    }

    //Ce mail me permet de notifier l'utilisateur que ça fiche est accepter avec le nombre de cerise recu.
    function mailAccepterFiche($email,$cerise,$correspondance) {
        $toMail = openssl_decrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $subjectMail = "Fiche acceptée download cerise pro";
        
        // Créer le corps de l'email en HTML
        $messageMail = "<html>";
        $messageMail .= "<body>";
        $messageMail .= "<h1>Fiche acceptée</h1>";
        $messageMail .= "<p>Bonjour,</p>";
        $messageMail .= "<p>Je vous informe que votre fiche \"$correspondance\" a été acceptée. En reconnaissance de votre contribution, vous avez reçu $cerise cerises.</p>";
        $messageMail .= "<p>Les cerises sont la monnaie virtuelle du site qui vous permet d'acheter d'autres fiches. Vous pouvez utiliser vos cerises pour accéder à des fiches premium.</p>";
        $messageMail .= "<p>Nous vous remercions pour votre participation et espérons que vous continuerez à nous aider à améliorer notre site en partageant vos connaissances et en utilisant vos cerises de manière judicieuse.</p>";
        $messageMail .= "<p>Download Cerise Pro</p>";
        $messageMail .= "</body>";
        $messageMail .= "</html>";
        
        // En-têtes supplémentaires pour envoyer un email en HTML
        $headersMail[] = 'MIME-Version: 1.0';
        $headersMail[] = 'Content-type: text/html; charset=utf-8';
        $headersMail[] = 'From: no-replay@downloadcerisepro.fr';
        $headersMail[] = 'Reply-To: no-replay@downloadcerisepro.fr';
        
        // Envoyer l'email
        mail($toMail, $subjectMail, $messageMail, implode("\r\n", $headersMail));
    }


    //Ce mail me permet de notifier l'admin qu'il y a eu une vente
    function mailVenteNotification($montant,$numeroFacture) {
        $montant = str_replace(".", ",", round($montant, 2));

        $toMail = "pro.antoine.masia@gmail.com";
        $subjectMail = "Notification de vente - $montant €";
        $urlFacture = getUrl(false)."/facture-$numeroFacture";
        
        // Créer le corps de l'email en HTML
        $messageMail = "<html>";
        $messageMail .= "<body>";
        $messageMail .= "<h1>Notification de vente</h1>";
        $messageMail .= "<p>Bonjour,</p>";
        $messageMail .= "<p>Je vous informe qu'un utilisateur vient de réaliser un achat d'un montant de $montant €. Voici le lien de la facture :</p>";
        $messageMail .= "<p>$urlFacture</p>";
        $messageMail .= "</body>";
        $messageMail .= "</html>";
        
        // En-têtes supplémentaires pour envoyer un email en HTML
        $headersMail[] = 'MIME-Version: 1.0';
        $headersMail[] = 'Content-type: text/html; charset=utf-8';
        $headersMail[] = 'From: notif-admin@downloadcerisepro.fr';
        $headersMail[] = 'Reply-To: notif-admin@downloadcerisepro.fr';
        
        // Envoyer l'email
        mail($toMail, $subjectMail, $messageMail, implode("\r\n", $headersMail));
    }

    //Ce mail permet de remercier le client pour l'achat
    function mailAchat($email,$montant,$numeroFacture) {
        $montant = str_replace(".", ",", round($montant, 2));

        $toMail = openssl_decrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $subjectMail = "Votre Facture Download Cerise Pro";
        $urlFacture = getUrl(false)."/facture-$numeroFacture";
        
        // Créer le corps de l'email en HTML
        $messageMail = "<html>";
        $messageMail .= "<body>";
        $messageMail .= "<h1>Votre Facture Download Cerise Pro</h1>";
        $messageMail .= "<p>Cher client,</p>";
        $messageMail .= "<p>Nous vous remercions pour votre achat de Cerise, notre monnaie déchange sur le site download cerise pro. Nous espérons que vous apprécierez cette monnaie déchange et que vous aurez une excellente expérience de son utilisation sur notre site.</p>";
        $messageMail .= "<p>Le montant de votre facture s'élève à $montant €.</p>";
        $messageMail .= "<p>Voici le lien de votre facture pour votre référence : $urlFacture. Ce lien vous permet d'imprimer votre facture pour la conserver. Nous vous conseillons fortement de l'imprimer, car nous ne pourrons pas conserver votre facture au-delà du temps légal requis. Afin de pouvoir la conserver en cas de besoin, nous vous recommandons de l'imprimer et de la conserver en lieu sûr.</p>";
        $messageMail .= "<p>Cependant, vous pouvez également consulter vos factures à tout moment en vous connectant à votre compte utilisateur sur notre site.</p>";
        $messageMail .= "<p>N'hésitez pas à nous contacter si vous avez des questions ou des préoccupations.</p>";
        $messageMail .= "<p>Merci encore pour votre achat !</p>";
        $messageMail .= "<p>Cordialement,</p>";
        $messageMail .= "<p>Download Cerise Pro</p>";
        $messageMail .= "</body>";
        $messageMail .= "</html>";
        
        // En-têtes supplémentaires pour envoyer un email en HTML
        $headersMail[] = 'MIME-Version: 1.0';
        $headersMail[] = 'Content-type: text/html; charset=utf-8';
        $headersMail[] = 'From: no-replay@downloadcerisepro.fr';
        $headersMail[] = 'Reply-To: no-replay@downloadcerisepro.fr';
        
        // Envoyer l'email
        mail($toMail, $subjectMail, $messageMail, implode("\r\n", $headersMail));
    }