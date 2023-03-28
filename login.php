<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    if(isset($_SESSION['idUser'])) {
        redirectUrl("/profil");
    }

    $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Connexion'])) {
            $password = hash('sha512', htmlspecialchars($_POST['password']));
            $email = htmlspecialchars(strtolower($_POST['email']));
            $email = openssl_encrypt($email, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
            $error = false;

            $verifUser = verifValidUser($email);
            $checkPassword = checkPassword($email);
            // var_dump(' ');
            // var_dump(' ');
            // var_dump(' ');
            // var_dump(' ');
            // var_dump(' ');
            // var_dump($email);

            //Verifie si l'adresse e-mail existe 
            //(si ça retourne aucun mot de passe alors elle existe pas)
            if(!$error) {
                if(!$checkPassword) {
                    $error = true;
                    $message = "Mot de passe ou adresse e-mail incorrecte.";
                }
            }

            //Vérifie si le mot de passe écrit correspond au mot de passe en bdd.
            if(!$error) {
                if($checkPassword['password'] !== $password) {
                    $error = true;
                    $message = "Mot de passe ou adresse e-mail incorrecte.";
                }
            }

            //Vérifie si le compte est confirmé
            if(!$error) {
                if((int)$verifUser['confirmation'] == 0) {
                    $error = true;
                    $message = "Votre compte n'est pas confirmé.";
                }
            }

            //retour réponse
            if(!$error) {
                $id = recupId($email);
                session_start();
                $_SESSION["idUser"] = $id['idUser'];
                $_POST['email'] = "";
                $_POST['password'] = "";
                redirectUrl("/profil");
            }
        }
    }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Connexion - Download Cerise Pro</title>
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
                                <h2>Connexion</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<section>
                                        <span class="error"><?= $message ?></span>
                                        <form method="post">
                                            <div class="fields">
                                                <div class="field">
                                                    <label for="email">Email</label>
                                                    <input type="email" autocomplete="off" name="email" id="email" placeholder="Saisissez votre adresse e-mail" value="<?php if(isset($_POST['Connexion'])) { echo($_POST['email']); } ?>">
                                                </div>
                                                <div class="field">
                                                    <label for="password">Mot de passe</label>
                                                    <input type="password" autocomplete="off" name="password" id="password" placeholder="Saisissez votre mot de passe" value="<?php if(isset($_POST['Connexion'])) { echo($_POST['password']); } ?>">
                                                </div>
                                            </div>
                                            <ul class="actions">
                                                <li><input type="submit" value="Connexion" name="Connexion" class="primary"></li>
                                            </ul>
                                        </form>
                                        <p>Je n'ai pas de compte ? <a href="/inscription">Créer un compte</a></p>
                                        
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