<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    if(isset($_SESSION['idUser'])) {
        redirectUrl("/");
    }

    //génère la vérification formulaire
    if(!isset($_SESSION['randomVerifForm'])) {
        $_SESSION['randomVerifForm'] = rand(1, 10);
    }
    $randomVerifForm = $_SESSION['randomVerifForm'];

    $message = "";
    $messageValid = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Inscription'])) {
            $email = htmlspecialchars(strtolower($_POST['email']));
            $error = false;

            //Vérifier qu'il est bien que des carractères au prénom
            if(!$error) {
                if(!preg_match('/^[\p{Latin}\s]+$/u',$_POST['prénom'])) {
                    $error = true;
                    $message = "Le prénom n'est pas valide.";
                }
            }
            //Vérifier la limite du prénom
            if(!$error) {
                if(strlen($_POST['prénom']) > 99) {
                    $error = true;
                    $message = "Le prénom est trop long.";
                }
            }
            //Vérifier le minimum du prénom
            if(!$error) {
                if(strlen($_POST['prénom']) < 1) {
                    $error = true;
                    $message = "Le prénom est trop court.";
                }
            }

            //Vérifier qu'il est bien que des carractères au nom
            if(!$error) {
                if(!preg_match('/^[\p{Latin}\s]+$/u',$_POST['nom'])) {
                    $error = true;
                    $message = "Le nom n'est pas valide.";
                }
            }
            //Vérifier la limite du nom
            if(!$error) {
                if(strlen($_POST['nom']) > 99) {
                    $error = true;
                    $message = "Le nom est trop long.";
                }
            }
            //Vérifier le minimum du nom
            if(!$error) {
                if(strlen($_POST['nom']) < 1) {
                    $error = true;
                    $message = "Le nom est trop court.";
                }
            }
            
            //Empêche les doublons email
            if(!$error) {
                if(count(emailDoublon(openssl_encrypt($_POST['email'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']))) >= 1) {
                    $error = true;
                    $message = "Cette adresse e-mail est déjà utilisée.";
                }
            }          

            //Verification si c'est une adresse email valide
            if(!$error) {
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $error = true;
                    $message = "L'adresse e-mail est invalide.";
                }
            }
            if(!$error) {
                if(strlen($_POST['email']) > 320) {
                    $error = true;
                    $message = "L'adresse e-mail est trop longue.";
                }
            }

            //vérification mot de passe
            if(!$error) {
                if(strlen($_POST['password']) < 8) {
                    $error = true;
                    $message = "Votre mot de passe doit faire un minimum de 8 caractères.";
                }
            }
            if(!$error) {
                if(strlen($_POST['password']) > 30) {
                    $error = true;
                    $message = "Votre mot de passe ne doit pas dépasser 30 caractères.";
                }
            }
            if(!$error) {
                if(verifInt($_POST['password']) < 2) {
                    $error = true;
                    $message = "Votre mot de passe doit contenir un minimum de 2 chiffres.";
                }
            }
            if(!$error) {
                if(verifInt($_POST['password']) === strlen($_POST['password'])) {
                    $error = true;
                    $message = "Votre mot de passe doit contenir des chiffres et des lettres.";
                }
            }
            if(!$error) {
                if(countSpecialChar($_POST['password']) <= 0) {
                    $error = true;
                    $message = "Votre mot de passe doit contenir au moins un caractère spécial.";
                }
            }

            //les mot de passe égaux
            if(!$error) {
                if($_POST['password'] !== $_POST['confirmpassword']) {
                    $error = true;
                    $message = "Votre mot de passe n'est pas identique à votre mot de passe de confirmation.";
                }
            }
            
            //Vérifier le resultat corresponde
            if(!$error) {
                if((int) $_POST['randomVerifForm'] != $randomVerifForm) {
                    $error = true;
                    $message = "Le résultat n'est pas bon.";
                }
            }

            //retour réponse
            if(!$error) {
                $messageValid = "Inscription réussite, vérifier votre boite e-mail pour confirmer votre compte. Si l'e-mail n'apparaît pas vérifier vos spams.";
                $prénom = htmlspecialchars(strtolower($_POST['prénom']));
                $nom = htmlspecialchars(strtolower($_POST['nom']));
                $email = htmlspecialchars(strtolower($_POST['email']));
                $password = hash('sha512', htmlspecialchars($_POST['confirmpassword']));
                $avatar = rand(1000, 9999).time().rand(1000, 9999);

                //Génère le token
                $date = time();
                $idToken = rand(100000, 999999).time();

                //envoyer un email avec le lien "idToken$idToken"
                mailConfirmation(openssl_encrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']),$idToken);

                //Ajoute l'utilisateur en base de donnée
                addUser($nom,$prénom,$email,$password,$avatar);

                //Ajoute le token
                addToken($email,$date,$idToken);

                //Remise à 0 des valeur du formulaire
                $_POST['prénom'] = "";
                $_POST['nom'] = "";
                $_POST['email'] = "";
                $_POST['password'] = ""; 
                $_POST['confirmpassword'] = ""; 
                unset($_SESSION['randomVerifForm']); 
            }
        }
    }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Inscription - Download Cerise Pro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="icon" type="image/png" href="/images/logo.png" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Menu -->
				<?php include_once("menu.php"); ?>

				<!-- Wrapper -->
					<section id="wrapper">
                        <header>
							<div class="inner">
                                <h2>Inscription</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<section>
                                        <span class="error"><?= $message ?></span>
                                        <span class="valid"><?= $messageValid ?></span>
                                        <form method="post">
                                            <div class="fields">
                                                <div class="field">
                                                    <label for="prénom">Prénom</label>
                                                    <input id="prénom" name="prénom" type="text" autocomplete="off" placeholder="Saisissez votre prénom" value="<?php if(isset($_POST['Inscription'])) { echo($_POST['prénom']); } ?>"/>
                                                </div>
                                                <div class="field">
                                                    <label for="nom">Nom</label>
                                                    <input id="nom" name="nom" type="text" autocomplete="off" placeholder="Saisissez votre nom" value="<?php if(isset($_POST['Inscription'])) { echo($_POST['nom']); } ?>"/>
                                                </div>
                                                <div class="field">
                                                    <label for="email">Email</label>
                                                    <input id="email" name="email" type="email" autocomplete="off" placeholder="Saisissez votre adresse e-mail" value="<?php if(isset($_POST['Inscription'])) { echo($_POST['email']); } ?>"/>
                                                </div>
                                                <div class="field">
                                                    <label for="password">Mot de passe</label>
                                                    <input id="password" name="password" type="password" placeholder="Saisissez votre mot de passe" value="<?php if(isset($_POST['Inscription'])) { echo($_POST['password']); } ?>"/>
                                                    <span>Le mot de passe doit être composé à la fois de lettres et de chiffres et contenir entre 8 et 30 caractères.</span>
                                                </div>
                                                <div class="field">
                                                    <label>Confirmation du mot de passe</label>
                                                    <input id="confirmpassword" name="confirmpassword" type="password" placeholder="Saisissez votre mot de passe" value="<?php if(isset($_POST['Inscription'])) { echo($_POST['confirmpassword']); } ?>" />
                                                </div>
                                                <div class="field">
                                                    <label>Vérification</label>
                                                    <img class="verif" src="/images/verifForm/<?= $randomVerifForm ?>.png">
                                                    <input id="randomVerifForm" name="randomVerifForm" type="text" autocomplete="off" placeholder="Saisissez le résultat" />
                                                </div>
                                            </div>
                                            <ul class="actions">
                                                <li><input type="submit" value="Inscription" name="Inscription" class="primary"></li>
                                            </ul>
                                        </form>
                                        <p>Vous avez déjà un compte ? <a href="/connexion">Connexion</a></p>
                                        
									</section>
								</div>
							</div>

					</section>

				<!-- Footer -->
				<?php include_once("footer.php"); ?>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="assets/js/app.js"></script>

	</body>
</html>