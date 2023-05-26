<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/essentialFunction.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/mailFunction.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/encryptionKey.php';

    /**
     * Selectionne toute les données d'un utilisateur avec son identifiant de session.
     *
     * @param  int $id identifiant de session (Ex: 34)
     * @return array
     */
    function dataUser($id) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM users WHERE IdUser = :id");
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch();
    }
    
    /**
     * Passe une fiche en format publique avec la qualité choisi.
     *
     * @param  int $id identifiant de la fiche (Ex: 12)
     * @param  int $quality qualité de la fiche (Ex: 0,1 ou 2)
     * @return void
     */
    function updateFiche($id,$quality) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("UPDATE fiches SET Public = true, Quality = :quality WHERE IdFiche = :id");
        $stmt->execute([
            ':id' => $id,
            ':quality' => $quality
        ]);
        return $stmt->rowCount();
    }
   
    /**
     * Supprime une fiche en fonction de son identifiant 
     *
     * @param  int $id identifiant de la fiche (Ex: 12)
     * @return void
     */
    function deleteFiche($id) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("DELETE FROM fiches WHERE IdFiche = :id");
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->rowCount();

    }

    /**
     * Selectionne tout les fiche avec un filtrage, ou si $IsCount est sur true compte le nombre de fiche avec les filtres.
     *
     * @param  string $filiere
     * @param  int $pole
     * @param  string $classement
     * @param  int $fichesLimiteParPage
     * @param  int $ficheDeDepart
     * @param  boolean $IsCount
     * @return array
     */
    function selectAllFiches($filiere,$pole,$classement,$fichesLimiteParPage,$ficheDeDepart,$IsCount = false) {
        $bdd = connexion_db();

        //requete avec filtre
        if(!$IsCount) {
            $ordre = "DESC";
            if($classement == "titre" or $classement == "correspondance") {
                $ordre = "ASC";
            }
            $stmt = $bdd->prepare("SELECT * FROM fiches WHERE Filiere = :filiere AND LEFT(Correspondance, 1) = :pole AND public = true ORDER BY $classement $ordre LIMIT $ficheDeDepart,$fichesLimiteParPage");
            $stmt->execute([
                ':filiere' => $filiere,
                ':pole' => $pole
            ]);
        }

        //requete pour compter les fiche dispo avec les filtres
        elseif($IsCount) {
            $stmt = $bdd->prepare("SELECT count(*) FROM fiches WHERE Filiere = :filiere AND LEFT(Correspondance, 1) = :pole AND public = true");
            $stmt->execute([
                ':filiere' => $filiere,
                ':pole' => $pole
            ]);
        }

        return $stmt->fetchAll();
    }

    /**
     * Selectionne les données d'une fiche en fonction d'un identifiant.
     *
     * @param  int $IdFiche identifiant de la fiche (Ex: 12)
     * @return array
     */
    function selectFicheOfId($IdFiche) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM fiches WHERE IdFiche = :IdFiche AND public = true");
        $stmt->execute([
            ':IdFiche' => $IdFiche
        ]);
        return $stmt->fetch();
    }

    /**
     * Permet de selectionner la plus veille fiche non publique  
     *
     * @return array
     */
    function selectLastFicheSend() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM fiches WHERE Public = false ORDER BY Date LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    //   
    /**
     * Permet de convertir le code correspondance en correspondance de toute lettre.
     *
     * @param  string $arg correspondance (Ex: "1.1.1")
     * @return string "1.1.1 Tenue des dossiers fournisseurs et sous-traitants"
     */
    function writeCorrespondance($arg) {
        switch ($arg) {
            case "1.1.1":
                return "1.1.1 Tenue des dossiers fournisseurs et sous-traitants";
            case "1.1.2":
                return "1.1.2 Traitement des ordres d'achat, des commandes";
            case "1.1.3":
                return "1.1.3 Traitement des livraisons, des factures et suivi des anomalies";
            case "1.1.4":
                return "1.1.4 Évaluation et suivi des stocks";
            case "1.1.5":
                return "1.1.5 Gestion des règlements et traitement des litiges";
            case "1.2.1":
                return "1.2.1 Participation à la gestion administrative de la prospection";
            case "1.2.2":
                return "1.2.2 Tenue des dossiers clients, donneurs d'ordre et usagers";
            case "1.2.3":
                return "1.2.3 Traitement des devis, des commandes";
            case "1.2.4":
                return "1.2.4 Traitement des livraisons et de la facturation";
            case "1.2.5":
                return "1.2.5 Traitement des règlements et suivi des litiges";
            case "1.3.1":
                return "1.3.1 Suivi de la trésorerie et des relations avec les banques";
            case "1.3.2":
                return "1.3.2 Préparation des déclarations fiscales";
            case "1.3.3":
                return "1.3.3 Traitement des formalités administratives";
            case "1.3.4":
                return "1.3.4 Suivi des relations avec les partenaires-métiers";
            case "2.1.1":
                return "2.1.1 Tenue et suivi des dossiers des salariés";
            case "2.1.2":
                return "2.1.2 Gestion administrative des temps de travail";
            case "2.1.3":
                return "2.1.3 Préparation et suivi des déplacements du personnel";
            case "2.1.4":
                return "2.1.4 Transmission d'informations à destination du personnel";
            case "2.2.1":
                return "2.2.1 Participation au recrutement du personnel";
            case "2.2.2":
                return "2.2.2 Participation à la mise en œuvre d'un programme d'accueil";
            case "2.2.3":
                return "2.2.3 Suivi administratif des carrières";
            case "2.2.4":
                return "2.2.4 Préparation et suivi de la formation du personnel";
            case "2.3.1":
                return "2.3.1 Préparation des bulletins de salaires";
            case "2.3.2":
                return "2.3.2 Préparation des déclarations sociales";
            case "2.3.3":
                return "2.3.3 Participation à la préparation et au suivi budgétaire";
            case "2.4.1":
                return "2.4.1 Suivi administratif des obligations liées aux instances représentatives du personnel";
            case "2.4.2":
                return "2.4.2 Préparation des tableaux de bord, des indicateurs sociaux";
            case "2.4.3":
                return "2.4.3 Participation à la mise en œuvre de procédures relevant de la santé et de la sécurité";
            case "2.4.4":
                return "2.4.4 Participation à la mise en place d'activités sociales et culturelles";
            case "3.1.1":
                return "3.1.1 Collecte et recherche d'informations";
            case "3.1.2":
                return "3.1.2 Production d'informations structurées";
            case "3.1.3":
                return "3.1.3 Organisation et mise à disposition des informations";
            case "3.2.1":
                return "3.2.1 Organisation et suivi de réunions";
            case "3.2.2":
                return "3.2.2 Gestion des flux de courriers";
            case "3.2.3":
                return "3.2.3 Gestion des flux d'appels téléphoniques";
            case "3.2.4":
                return "3.2.4 Gestion d'espaces collaboratifs";
            case "3.3.1":
                return "3.3.1 Orientation et information des visiteurs";
            case "3.3.2":
                return "3.3.2 Maintien opérationnel des postes de travail et aménagement des espaces";
            case "3.3.3":
                return "3.3.3 Gestion des contrats de maintenance, abonnements, licences informatiques";
            case "3.3.4":
                return "3.3.4 Participation au suivi du budget de fonctionnement du service";
            case "3.3.5":
                return "3.3.5 Gestion des fournitures, consommables et petits équipements de bureau";
            case "3.4.1":
                return "3.4.1 Gestion des agendas";
            case "3.4.2":
                return "3.4.2 Planification et suivi des activités";
            case "4.1.1":
                return "4.1.1 Mise en forme et diffusion du descriptif du projet";
            case "4.1.2":
                return "4.1.2 Organisation de la base documentaire";
            case "4.1.3":
                return "4.1.3 Production d'états budgétaires liés au projet";
            case "4.1.4":
                return "4.1.4 Traitement des formalités et des autorisations";
            case "4.1.5":
                return "4.1.5 Suivi du planning de réalisation du projet";
            case "4.1.6":
                return "4.1.6 Mise en relation des acteurs du projet";
            case "4.1.7":
                return "4.1.7 Suivi des réunions liées au projet";
            case "4.1.8":
                return "4.1.8 Suivi logistique du projet";
            case "4.1.9":
                return "4.1.9 Signalement et suivi des dysfonctionnements du projet";
            case "4.2.1":
                return "4.2.1 Participation à l'élaboration des documents de synthèse";
            case "4.2.2":
                return "4.2.2 Participation au rapport d'évaluation";
            case "4.2.3":
                return "4.2.3 Clôture administrative du projet";
        }
    }
  
    /**
     * Permet de convertir le chiffre de la qualité en toute lettre.
     *
     * @param  int $quality qualité (Ex: 0)
     * @return string "classique"
     */
    function writeQuality($quality) {
        $quality = (int) $quality;
        switch ($quality) {
            case 0:
                return "classique";
            case 1:
                return "parfaite";
            case 2:
                return "premium";
        }
    }
    
    /**
     * compte toute les fiches publique ou en attente en fonction de la filière et du pole
     *
     * @param  boolean $public publique (Ex: true)
     * @param  string $filiere filière (Ex: "bac")
     * @param  int $pole pole (Ex: 1)
     * @return int 43
     */
    function selectAllFiche($public,$filiere=NULL,$pole=NULL) {

        $bdd = connexion_db();

        $stmt = $bdd->prepare("SELECT COUNT(*) FROM fiches WHERE Public = :public");
        $stmt->execute([
            ':public' => $public
        ]);

        if($filiere != NULL) {
            $stmt = $bdd->prepare("SELECT COUNT(*) FROM fiches WHERE Public = :public AND Filiere = :filiere");
            $stmt->execute([
                ':public' => $public,
                ':filiere' => $filiere
            ]);
        }

        if($pole != NULL) {
            $stmt = $bdd->prepare("SELECT COUNT(*) FROM fiches WHERE Public = :public AND Filiere = :filiere AND Correspondance LIKE :pole '%'");
            $stmt->execute([
                ':public' => $public,
                ':filiere' => $filiere,
                ':pole' => $pole
            ]);
        }

        $r = $stmt->fetch();
        return (int) $r['COUNT(*)'];
    }
  
    /**
     * Vérifier si le compte de l'utilisateur a été validé par mail.
     *
     * @param  string $email (Ex: "test@test.fr")
     * @return array
     */
    function verifValidUser($email) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT confirmation FROM users WHERE Mail = :email");
        $stmt->execute([
            ":email" => $email
        ]);
        return $stmt->fetch();
    }
  
    /**
     * Récupérer l'identifiant associé à l'adresse email
     *
     * @param  string $email (Ex: "test@test.fr")
     * @return array
     */
    function recupId($email) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT idUser FROM users WHERE Mail = :email");
        $stmt->execute([
            ":email" => $email
        ]);
        return $stmt->fetch();
    }
    
    /**
     * Récupère le mot de passe en fonction de l'adresse mail envoyé.
     *
     * @param  string $email (Ex: "test@test.fr")
     * @return void
     */
    function checkPassword($email) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT password FROM users WHERE Mail = :email");
        $stmt->execute([
            ":email" => $email
        ]);
        return $stmt->fetch();
    }
  
    /**
     * Vérifier si il n'y a pas d'adresse mail doublon
     *
     * @param  string $email (Ex: "test@test.fr")
     * @return array
     */
    function emailDoublon($email) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM users WHERE mail = :email");
        $stmt->execute([
            ":email" => $email
        ]);
        return $stmt->fetchAll();
    }
  
    /**
     * Ajoute un nouveau utilisateur avec les données envoyé depuis le formulaire
     *
     * @param  string $nom (Ex: "Dupon")
     * @param  string $prénom (Ex: "Pierre")
     * @param  string $email (Ex: "test@test.fr")
     * @param  string $password (Ex: "SHAlfpz3iLp6@dffz2")
     * @param  string $avatar (Ex: "1292837647291083")
     * @return void
     */
    function addUser($nom,$prénom,$email,$password,$avatar) {
        $prenom = $prénom;

        $nom = openssl_encrypt($nom, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $prenom = openssl_encrypt($prenom, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $avatar = openssl_encrypt($avatar, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $email = openssl_encrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);

        $bdd = connexion_db();
        $stmt = $bdd->prepare("INSERT INTO users(nom,prenom,mail,password,avatar) VALUES (:nom,:prenom,:email,:password,:avatar)");
        $stmt->execute([
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":email" => $email,
            ":password" => $password,
            ":avatar" => $avatar
        ]);
        $stmt->rowCount();
    }
   
    /**
     * Créer un jeton de validation envoyé par mail pour confirmer le compte.
     *
     * @param  string $email (Ex: "test@test.fr")
     * @param  int $date (Ex: 1111002983)
     * @param  string $idToken (Ex: "p2z03iLp6ff7z2")
     * @return void
     */
    function addToken($email,$date,$idToken) {
        $mail = $email;

        $mail = openssl_encrypt($mail, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);

        $bdd = connexion_db();
        $stmt = $bdd->prepare("INSERT INTO tokens(idToken,mail,date) VALUES (:idToken,:mail,:date)");
        $stmt->execute([
            ":idToken" => $idToken,
            ":mail" => $mail,
            ":date" => $date
        ]);
        $stmt->rowCount();
    }
 
    /**
     * Récupère les informations du token.
     *
     * @param  mixed $id id du token (Ex: "p2z03iLp6ff7z2")
     * @return array
     */
    function recupToken($id) {
        $idToken = $id;
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM tokens WHERE idToken = :idToken");
        $stmt->execute([
            ":idToken" => $idToken
        ]);
        return $stmt->fetch();
    }
   
    /**
     * Change le token et la date si expiré.
     *
     * @param  int $date (Ex: 1111002983)
     * @param  string $id identifiant du token (Ex: "p2z03iLp6ff7z2")
     * @param  string $newIdT identifiant du nouveau token (Ex: "md7pc5lsoz2uf")
     * @return void
     */
    function updateExpireToken($date,$id,$newIdT) {
        $idToken = $id;
        $bdd = connexion_db();
        $stmt = $bdd->prepare("UPDATE tokens SET idToken = :newIdT, date = :date WHERE idToken = :idToken");
        $stmt->execute([
            ":idToken" => $idToken,
            ":newIdT" => $newIdT,
            ":date" => $date
        ]);
        return $stmt->rowCount();
    }

    /**
     * Confirme le compte si le token est validé
     *
     * @param  string $email (Ex: "test@test.fr")
     * @return void
     */
    function validAccountToken($email) {
        $mail = $email;
        $bdd = connexion_db();

        //passe le compte sur confirmation
        $stmt = $bdd->prepare("UPDATE users SET confirmation = 1 WHERE mail = :mail");
        $stmt->execute([
            ":mail" => $mail
        ]);
        $stmt->rowCount();

        //supprime le token de la base de donnée
        $stmt = $bdd->prepare("DELETE FROM tokens WHERE mail = :mail");
        $stmt->execute([
            ":mail" => $mail
        ]);
        $stmt->rowCount();
    }
   
    /**
     * Ajoute des cerises sur le comptes d'un utilisateur 
     *
     * @param  int $nombreCerise (Ex: 100)
     * @param  int $idUser (Ex: 11)
     * @return void
     */
    function addCerise($nombreCerise,$idUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("UPDATE users SET Cerise = Cerise+:nombreCerise WHERE IdUser = :idUser");
        $stmt->execute([
            ":idUser" => $idUser,
            ":nombreCerise" => $nombreCerise
        ]);
        return $stmt->rowCount();
    }

    /**
     * Vérifie si la fiche est débloquer pour l'utilisateur
     *
     * @param  int $idUser (Ex: 11)
     * @param  int $idFiche (Ex : 3)
     * @return array
     */
    function verifFicheUnlocked($idUser,$idFiche) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT IdFiche FROM ficheunlocked WHERE IdUser = :idUser AND IdFiche = :idFiche");
        $stmt->execute([
            ':idUser' => $idUser,
            ':idFiche' => $idFiche
        ]);
        return $stmt->fetch();
    }
 
    /**
     * Récupère le dernière idéntifiant insérer en base de donnée de la table fiche
     *
     * @return int 34
     */
    function recupLastIdFiche() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT IdFiche as id FROM fiches ORDER BY IdFiche DESC LIMIT 0, 1");
        $stmt->execute();
        $r = $stmt->fetch();
        return (int) $r['id'];
    }

    /**
     * Envoyer une fiche depuis un formulaire, permet d'alimenté le site, et de récompensé les utilisateurs
     *
     * @param  string $Filière (Ex: "bac")
     * @param  string $Correspondance (Ex: "1.1.1")
     * @param  string $Titre (Ex: "illo nulla qui")
     * @param  string $Text1 (Ex: "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cupiditate aliquam iure assumenda beatae maxime ab inventore explicabo illo nulla qui? Maiores dicta consequatur tempore hic error similique voluptatibus nulla magni.")
     * @param  string $Text2 (Ex: "consectetur adipisicing elit. Cupiditate aliquam iure assumenda beatae maxime ab inventore explicabo illo nulla qui? Maiores dicta consequatur tempore hic error similique voluptatibus nulla magni.")
     * @param  string $Text3 (Ex: "Cupiditate aliquam iure assumenda beatae maxime ab inventore explicabo illo nulla qui? Maiores dicta consequatur tempore hic error similique voluptatibus nulla magni.")
     * @param  string $Text4 (Ex: "assumenda beatae maxime ab inventore explicabo illo nulla qui? Maiores dicta consequatur tempore hic error similique voluptatibus nulla magni.")
     * @param  string $Text5 (Ex: "sit amet consectetur adipisicing elit. Cupiditate aliquam iure assumenda beatae maxime ab inventore explicabo illo nulla qui? Maiores dicta consequatur tempore hic error similique voluptatibus nulla magni.")
     * @param  int $IdUser Identifiant de la session (Ex: 11)
     * @return void
     */
    function addFiche($Filière,$Correspondance,$Titre,$Text1,$Text2,$Text3,$Text4,$Text5,$IdUser) {
        $Filiere = $Filière;
        
        $Titre = openssl_encrypt($Titre, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $Text1 = openssl_encrypt($Text1, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $Text2 = openssl_encrypt($Text2, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $Text3 = openssl_encrypt($Text3, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $Text4 = openssl_encrypt($Text4, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $Text5 = openssl_encrypt($Text5, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);

        $bdd = connexion_db();
        $stmt = $bdd->prepare("INSERT INTO fiches(Filiere,Correspondance,Titre,Text1,Text2,Text3,Text4,Text5,IdUser) VALUES (:Filiere,:Correspondance,:Titre,:Text1,:Text2,:Text3,:Text4,:Text5,:IdUser)");
        $stmt->execute([
            ":Filiere" => $Filiere,
            ":Correspondance" => $Correspondance,
            ":Titre" => $Titre,
            ":Text1" => $Text1,
            ":Text2" => $Text2,
            ":Text3" => $Text3,
            ":Text4" => $Text4,
            ":Text5" => $Text5,
            ":IdUser" => $IdUser
        ]);
        $stmt->rowCount();
    }
  
    /**
     * Donnée l'accès à une fiche pour l'utilisateur, si il a suffisament de cerise pour la débloquer.
     *
     * @param  int $IdUser (Ex: 11)
     * @param  int $IdFiche (Ex: 2)
     * @param  int $price (Ex: 300)
     * @return void
     */
    function addFicheForUser($IdUser,$IdFiche,int $price) {
        $bdd = connexion_db();

        //débloque la fiche
        $stmt = $bdd->prepare("INSERT INTO ficheunlocked(IdUser,IdFiche) VALUES (:IdUser,:IdFiche)");
        $stmt->execute([
            ":IdUser" => $IdUser,
            ":IdFiche" => $IdFiche
        ]);
        $stmt->rowCount();

        //cerise à déduire du compte
        $stmt = $bdd->prepare("UPDATE users SET Cerise = :price WHERE IdUser = :IdUser");
        $stmt->execute([
            ":price" => $price,
            ":IdUser" => $IdUser
        ]);
        $stmt->rowCount();
    }

    /**
     * Récupère toute les fiches débloquée par l'utilsateur 
     *
     * @param  int $IdUser (Ex: 11)
     * @return array
     */
    function recupAllFichesUnlockOfUser($IdUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM ficheunlocked, fiches WHERE ficheunlocked.IdUser = :IdUser AND ficheunlocked.IdFiche = fiches.IdFiche ORDER BY ficheunlocked.IdFiche DESC");
        $stmt->execute([
            ":IdUser" => $IdUser
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère tout les fiches valider ou non de l'utilisateur 
     *
     * @param  int $IdUser (Ex: 11)
     * @param  boolean $public (Ex: true) 
     * @return void
     */
    function recupAllFichesOfUser($IdUser, $public) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM fiches WHERE IdUser = :IdUser AND Public = :public ORDER BY IdFiche DESC");
        $stmt->execute([
            ":IdUser" => $IdUser,
            ":public" => $public
        ]);
        return $stmt->fetchAll();
    }
   
    /**
     * Verifier si l'utilisateur est admin
     *
     * @return void
     */
    function isAdmin() {
        $data = dataUser($_SESSION['idUser']);
        if($data['Admin'] == false) {
            redirectUrl("/");
        }
    }

    /**
     * Verifier si l'utilisateur est ban de la plateform
     *
     * @return void
     */
    function isBan() {
        if(isset($_SESSION['idUser'])) {
            $data = dataUser($_SESSION['idUser']);
            if($data['Ban'] == true) {
                redirectUrl("/ban");
            }
        }
    }
 
    /**
     * Ajoute un vu sur la page pour faire des statistiques. cette fonction évite les doublons.
     *
     * @param  string $NamePage Nom de la page ("accueil")
     * @return void
     */
    function viewPage($NamePage) {
        $NamePage = strtolower($NamePage);

        $IdSession = session_id();

        $bdd = connexion_db();

        //Vérifier si l'utilisateur à déjà visiter la page en question aujoud'huit
        if(isset($_SESSION['idUser'])) {
            $IdUser = $_SESSION['idUser'];
            $stmt = $bdd->prepare("SELECT * FROM pagesview WHERE IdSession = :IdSession AND IdUser = :IdUser AND NamePage = :NamePage AND DATE(DateVisit) = DATE( NOW() )");
            $stmt->execute([
                ":NamePage" => $NamePage,
                ':IdSession' => $IdSession,
                ':IdUser' => $IdUser
            ]);
        } else {
            $stmt = $bdd->prepare("SELECT * FROM pagesview WHERE IdSession = :IdSession AND NamePage = :NamePage AND DATE(DateVisit) = DATE( NOW() )");
            $stmt->execute([
                ":NamePage" => $NamePage,
                ':IdSession' => $IdSession
            ]);
        }

        $verif = $stmt->fetch();

        //Si la page n'as pas été visité encore pas l'utilisateur
        if(!$verif) {
            //Ajouter à la table
            if(!isset($_SESSION['idUser'])) {
                $stmt = $bdd->prepare("INSERT INTO pagesview(NamePage,IdSession) VALUES (:NamePage,:IdSession)");
                $stmt->execute([
                    ":NamePage" => $NamePage,
                    ":IdSession" => $IdSession
                ]);
            } else {
                $IdUser = $_SESSION['idUser'];
                
                $stmt = $bdd->prepare("INSERT INTO pagesview(NamePage,IdSession,IdUser) VALUES (:NamePage,:IdSession,:IdUser)");
                $stmt->execute([
                    ":NamePage" => $NamePage,
                    ":IdSession" => $IdSession,
                    ":IdUser" => $IdUser
                ]);
            }
            $stmt->rowCount();
        }
    }

    /**
     * Récupère le nombre de fois que la fiche à été vu 
     *
     * @param  int $IdFiche (Ex: 11)
     * @return int 23
     */
    function viewNumberFiche($IdFiche) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT count(*) as total FROM pagesview WHERE NamePage = :IdFiche");    
        $stmt->execute([
            ':IdFiche' => $IdFiche
        ]);
        return $stmt->fetch()['total'];
    }
   
    /**
     * Récupère le nombre de fois que la fiche à été débloqué 
     *
     * @param  int $IdFiche (Ex: 11)
     * @return int 7
     */
    function unlockedNumberFiche($IdFiche) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT count(*) as total FROM ficheunlocked WHERE IdFiche = :IdFiche");    
        $stmt->execute([
            ':IdFiche' => $IdFiche
        ]);
        return $stmt->fetch()['total'];
    }

    //   
    /**
     * Ajoute la mention j'aime à une fiche 
     *
     * @param  int $IdUser (Ex: 11)
     * @param  int $IdFiche (Ex: 67)
     * @return void
     */
    function addLikeForFiche($IdUser,$IdFiche) {
        $bdd = connexion_db();

        //débloque la fiche
        $stmt = $bdd->prepare("INSERT INTO fichelike(IdUser,IdFiche) VALUES (:IdUser,:IdFiche)");
        $stmt->execute([
            ":IdUser" => $IdUser,
            ":IdFiche" => $IdFiche
        ]);
        $stmt->rowCount();
    }
    
    /**
     * Vérifie si la fiche est débloquer pour l'utilisateur
     *
     * @param  mixed $idUser (Ex: 11)
     * @param  mixed $idFiche (Ex: 45)
     * @return array
     */
    function verifLikeFiche($idUser,$idFiche) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT IdFiche FROM fichelike WHERE IdUser = :idUser AND IdFiche = :idFiche");
        $stmt->execute([
            ':idUser' => $idUser,
            ':idFiche' => $idFiche
        ]);
        return $stmt->fetch();
    }
  
    /**
     * Récupère le nombre total de mention j'aime de la fiche
     *
     * @param  int $IdFiche (Ex: 45)
     * @return int 443
     */
    function likeNumberFiche($IdFiche) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT count(*) as total FROM fichelike WHERE IdFiche = :IdFiche");    
        $stmt->execute([
            ':IdFiche' => $IdFiche
        ]);
        return $stmt->fetch()['total'];
    }
  
    /**
     * Récupérer tout les articles de la boutique publique. (Certain article peuvent être masqué depuis l'espace Admin)
     *
     * @return array
     */
    function recupAllArticles() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM produits WHERE Available = true");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les données d'un article si il est visible (cela est pour la boutique client)
     *
     * @param  int $IdProduit (Ex: 4)
     * @return array
     */
    function recupDataArticles($IdProduit) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM produits WHERE IdProduit = :IdProduit AND Available = true");
        $stmt->execute([
            ':IdProduit' => $IdProduit
        ]);
        return $stmt->fetch();
    }
 
    /**
     * Récupérer les données d'un article si il est visible ou non (cela est pour la vu admin)
     *
     * @param  int $IdProduit (Ex: 4)
     * @return array
     */
    function recupDataArticlesAdmin($IdProduit) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM produits WHERE IdProduit = :IdProduit");
        $stmt->execute([
            ':IdProduit' => $IdProduit
        ]);
        return $stmt->fetch();
    }
    
    /**
     * Ajoute une vente, cette fonction permet de fabriquer les factures client.
     *
     * @param  string $IdTransaction (Ex: "229842Q7918ZF53")
     * @param  string $IdPaypalPayer (Ex: "02093821")
     * @param  int $IdUser (Ex: 11)
     * @param  string $Nom (Ex: "Dupon")
     * @param  string $Prenom (Ex: "Pierre")
     * @param  int $IdArticle (Ex: 2)
     * @param  string $Status (Ex: "valid")
     * @param  float $Prix (Ex: 23.5)
     * @param  string $Devise (Ex: "EUR")
     * @param  string $Pays (Ex: "FR")
     * @param  int $Cerise (Ex: 200)
     * @param  string $NumeroFacture (Ex: "DCP292873829827492")
     * @param  float $TauxTVA (Ex: 5.5)
     * @param  string $Adresse (Ex: "7 rue des fours, 11000 Carcassonne")
     * @return void
     */
    function addVente($IdTransaction, $IdPaypalPayer, $IdUser, $Nom, $Prenom, $IdArticle, $Status, $Prix, $Devise, $Pays, $Cerise, $NumeroFacture, $TauxTVA, $Adresse) {
        
        $IdTransaction = openssl_encrypt($IdTransaction, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $IdPaypalPayer = openssl_encrypt($IdPaypalPayer, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $Adresse = openssl_encrypt($Adresse, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        $NumeroFacture = openssl_encrypt($NumeroFacture, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
        
        $bdd = connexion_db();
        $stmt = $bdd->prepare("INSERT INTO ventes(IdTransaction, IdPaypalPayer, IdUser, Nom, Prenom, IdArticle, Status, Prix, Devise, Pays, Cerise, NumeroFacture, TauxTVA, Adresse) VALUES (:IdTransaction, :IdPaypalPayer, :IdUser, :Nom, :Prenom, :IdArticle, :Status, :Prix, :Devise, :Pays, :Cerise, :NumeroFacture, :TauxTVA, :Adresse)");
        $stmt->execute([
            ":IdTransaction" => $IdTransaction, 
            ":IdPaypalPayer" => $IdPaypalPayer, 
            ":IdUser" => $IdUser,  
            ":Nom" => $Nom,  
            ":Prenom" => $Prenom, 
            ":IdArticle" => $IdArticle, 
            ":Status" => $Status, 
            ":Prix" => $Prix, 
            ":Devise" => $Devise, 
            ":Pays" => $Pays,
            ":Cerise" => $Cerise,
            ":NumeroFacture" => $NumeroFacture,
            ":TauxTVA" => $TauxTVA,
            ":Adresse" => $Adresse
        ]);
        return $stmt->rowCount();
    }

    /**
     * Récupérer toute les factures d'un utilisateur 
     *
     * @param  int $IdUser (Ex: 11)
     * @return array
     */
    function recupAllFacturesUser($IdUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM ventes WHERE IdUser = :IdUser ORDER BY DateVente DESC");
        $stmt->execute([
            "IdUser" => $IdUser
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Récupérer les données de la facture avec son numéro.
     *
     * @param  string $NumeroFacture (Ex: "DCP299278329042")
     * @return array
     */
    function recupFacture($NumeroFacture) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT v.NumeroFacture, v.IdUser, v.Prix, v.TauxTVA, v.DateVente, v.Cerise, v.Adresse, v.Nom, v.Prenom, u.Admin, p.Titre, p.LinkImg FROM ventes v, users u, produits p WHERE NumeroFacture = :NumeroFacture AND v.IdUser = u.IdUser AND p.IdProduit = v.IdArticle");
        $stmt->execute([
            "NumeroFacture" => $NumeroFacture
        ]);
        return $stmt->fetch();
    }
  
    /**
     * Récupérer le nombre de visite du mois
     *
     * @param  int $mois (Ex: 12)
     * @param  int $annee (Ex: 2022)
     * @return int 234
     */
    function recupViewPage($mois,$annee) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT COUNT(DISTINCT IdSession) as NombreVisit FROM pagesview WHERE MONTH(DateVisit) = :mois AND YEAR(DateVisit) = :annee");
        $stmt->execute([
            "mois" => $mois,
            "annee" => $annee
        ]);
        $visiteur = (int)$stmt->fetch()['NombreVisit'];
        return $visiteur;
    }

    /**
     * Récupère les recettes d'un mois choisi 
     *
     * @param  int $mois (Ex: 12)
     * @param  int $annee (Ex: 2022)
     * @return float 234.45
     */
    function recupRecetteMois($mois,$annee) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT sum(Prix) as recette FROM ventes WHERE MONTH(DateVente) = :mois AND YEAR(DateVente) = :annee");
        $stmt->execute([
            "mois" => $mois,
            "annee" => $annee
        ]);

        $recette = $stmt->fetch()['recette'];
        if(is_null($recette)) {
            $recette = 0;
        } else {
            $recette = round($recette, 0);
        }

        return $recette;
    }

    //   
    /**
     * Récupère le nomnbre de vente d'un mois choisi 
     *
     * @param  int $mois (Ex: 12)
     * @param  int $annee (Ex: 2022)
     * @return int 2
     */
    function recupVenteMois($mois,$annee) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT count(*) as vente FROM ventes WHERE MONTH(DateVente) = :mois AND YEAR(DateVente) = :annee");
        $stmt->execute([
            "mois" => $mois,
            "annee" => $annee
        ]);

        $recette = $stmt->fetch()['vente'];
        if(is_null($recette)) {
            $recette = 0;
        } else {
            $recette = round($recette, 2);
        }

        return $recette;
    }

    //   
    /**
     * Récupère le nombre d'inscript d'un mois choisi 
     *
     * @param  int $mois (Ex: 12)
     * @param  int $annee (Ex: 2022)
     * @return int 2
     */
    function recupInscriptionMois($mois,$annee) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT count(*) as inscription FROM users WHERE MONTH(DateInscription) = :mois AND YEAR(DateInscription) = :annee");
        $stmt->execute([
            "mois" => $mois,
            "annee" => $annee
        ]);

        $recette = $stmt->fetch()['inscription'];
        if(is_null($recette)) {
            $recette = 0;
        } else {
            $recette = round($recette, 2);
        }

        return $recette;
    }

    

    /**
     * Récupérer toute les factures (pour les admins)
     *
     * @return array
     */
    function recupAllFicheAchete() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT count(*) as total FROM ficheunlocked");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }


    /**
     * Récupérer toute les factures (pour les admins)
     *
     * @return array
     */
    function recupAllFactures() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT u.Prenom, u.Nom, v.NumeroFacture, v.DateVente, v.Prix, v.Status FROM ventes v, users u WHERE u.IdUser = v.IdUser ORDER BY DateVente DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupérer tout les articles de la boutique pour le menu admin  
     *
     * @return array
     */
    function recupAllArticlesForArmin() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM produits");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Ajoute un article dans la boutique depuis le pannel admin.
     *
     * @param  string $Titre (Ex: "Caisse de Cerise")
     * @param  float $Prix (Ex: 13.33)
     * @param  int $Cerise (Ex: 1000)
     * @param  int $CeriseBonus (Ex: 250)
     * @param  boolean $Available (Ex: true)
     * @param  string $LinkImg (Ex: "cerise-caisse.png")
     * @return void
     */
    function addArticle($Titre,$Prix,$Cerise,$CeriseBonus,$Available,$LinkImg) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("INSERT INTO produits(Titre, Prix, Cerise, CeriseBonus, Available, LinkImg) VALUES (:Titre, :Prix, :Cerise, :CeriseBonus, :Available, :LinkImg)");
        $stmt->execute([
            ":Titre" => $Titre, 
            ":Prix" => $Prix, 
            ":Cerise" => $Cerise, 
            ":CeriseBonus" => $CeriseBonus, 
            ":Available" => $Available, 
            ":LinkImg" => $LinkImg
        ]);
        return $stmt->rowCount();
    }

    /**
     * Modifie un article dans la boutique depuis le pannel admin
     *
     * @param  string $Titre (Ex: "Caisse de Cerise")
     * @param  float $Prix (Ex: 13.33)
     * @param  int $Cerise (Ex: 1000)
     * @param  int $CeriseBonus (Ex: 250)
     * @param  boolean $Available (Ex: true)
     * @param  string $LinkImg (Ex: "cerise-caisse.png")
     * @return void
     */
    function editArticle($Titre,$Prix,$Cerise,$CeriseBonus,$Available,$IdProduit) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("UPDATE produits SET Titre = :Titre, Prix = :Prix, Cerise = :Cerise, CeriseBonus = :CeriseBonus, Available = :Available WHERE IdProduit = :IdProduit");
        $stmt->execute([
            ":Titre" => $Titre, 
            ":Prix" => $Prix, 
            ":Cerise" => $Cerise, 
            ":CeriseBonus" => $CeriseBonus, 
            ":Available" => $Available, 
            ":IdProduit" => $IdProduit
        ]);
        return $stmt->rowCount();
    }

    /**
     * Récupère tout les utilisateurs du site avec leur dépenses totale en euro.
     *
     * @return array
     */
    function recupAllUserForAdmin() {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT u.IdUser,u.Nom,u.Prenom,u.Avatar,u.Confirmation,u.Mail,u.DateInscription,SUM(v.Prix) as Depense FROM users u LEFT JOIN ventes v ON u.IdUser = v.IdUser GROUP BY u.IdUser ORDER BY Depense DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
   
    /**
     * Récupère tout les pages visités de l'utilisateur pour la partie donnée personnelle.
     *
     * @param  int $IdUser (Ex: 11)
     * @return array
     */
    function recupPageView($IdUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM pagesview WHERE IdUser = :IdUser ORDER BY DateVisit DESC");
        $stmt->execute([
            ":IdUser" => $IdUser
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère tout les fiches avec la mention j'aime donnée par l'utilisateur pour la partie donnée personnelle.
     *
     * @param  int $IdUser (Ex: 11)
     * @return array
     */
    function likeFiche($IdUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM fichelike WHERE IdUser = :IdUser");    
        $stmt->execute([
            ':IdUser' => $IdUser
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère tout les fiches débloquées de l'utilisateur pour la partie donnée personnelle.
     *
     * @param  int $IdUser (Ex: 11)
     * @return array
     */
    function unlockedFiche($IdUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("SELECT * FROM ficheunlocked WHERE IdUser = :IdUser");    
        $stmt->execute([
            ':IdUser' => $IdUser
        ]);
        return $stmt->fetchAll();
    }
  
    /**
     * Supprime le compte de l'utilisateur, avec les fiches débloqué et les mentions j'aime.
     *
     * @param  int $IdUser (Ex: 11)
     * @return void
     */
    function deleteAccount($IdUser) {
        $bdd = connexion_db();

        $stmt = $bdd->prepare("DELETE FROM ficheunlocked WHERE IdUser = :IdUser;");
        $stmt->execute([
            ':IdUser' => $IdUser
        ]);
        $stmt->rowCount();

        $stmt = $bdd->prepare("DELETE FROM fichelike WHERE IdUser = :IdUser;");
        $stmt->execute([
            ':IdUser' => $IdUser
        ]);
        $stmt->rowCount();

        $stmt = $bdd->prepare("DELETE FROM users WHERE IdUser = :IdUser;");
        $stmt->execute([
            ':IdUser' => $IdUser
        ]);
        $stmt->rowCount();

        session_destroy();
        redirectUrl("/");
    }


    /**
     * valide le compte de l'utilisateur depuis le pannel admin.
     *
     * @param  int $id identifiant de la fiche (Ex: 12)
     * @return void
     */
    function validAccount($IdUser) {
        $bdd = connexion_db();
        $stmt = $bdd->prepare("UPDATE users SET Confirmation = true WHERE IdUser = :IdUser");
        $stmt->execute([
            ':IdUser' => $IdUser
        ]);
        return $stmt->rowCount();
    }