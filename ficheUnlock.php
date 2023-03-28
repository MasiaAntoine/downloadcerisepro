<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

	//Vérifier si l'utilisateur est ban du site
	isBan();
    
	//récupère le GET
	$IdFiche = $_GET['IdFiche'];

    //Récupère les data du l'utilisateur
    $dataUser = dataUser($_SESSION['idUser']);

    //Donnée sur la fiche
    $fiche = selectFicheOfId($IdFiche);
    
    //Si l'utilisateur a déjà débloqué la fiche le faire partir
    if(verifFicheUnlocked($_SESSION['idUser'],$IdFiche)) {
        redirectUrl("/");
    }
    //Si la fiche appartient à l'utilisateur le faire partir
    if($fiche['IdUser'] == $_SESSION['idUser']) {
        redirectUrl("/");
    }
    
    //Sécurité
    if($fiche['Public'] == false) {
        redirectUrl("/");
    }

    //Fixe le prix de chaque fiche en fonction de la qualité
    if($fiche['Quality'] == 0) {
        $priceCerise = 100;
    }
    elseif($fiche['Quality'] == 1) {
        $priceCerise = 150;
    }
    elseif($fiche['Quality'] == 2) {
        $priceCerise = 200;
    }

    $message = "";
    $messageValid = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Débloquer'])) {
            $error = false;

            //Vérifier qu'il est bien que des carractères au prénom
            if(!$error) {
                if($dataUser['Cerise'] < $priceCerise) {
                    $error = true;
                    $message = "Vous n'avez pas $priceCerise pièces cerises, pour débloquer cette fiche.<br><a href='/boutique'>Clique pour obtenir des pièces cerises.</a>";
                }
            }

            //retour réponse
            if(!$error) {
                $messageValid = "Vous avez débloqué la fiche !";
                $calculFinalCerise = (int) $dataUser['Cerise']-$priceCerise;
                
                addFicheForUser($_SESSION['idUser'],$IdFiche,$calculFinalCerise);
                redirectUrl("/fiche-$IdFiche");
            }
        }
    }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Débloquer la fiche #<?= $IdFiche; ?> - Download Cerise Pro</title>
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
                                <h2>Débloquer la fiche</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<section>
                                        <form method="post">
                                            <div class="hautmegaFiche">
                                                <div class="rond"></div>
                                                <div class="rond"></div>
                                                <div class="rond"></div>
                                            </div>
                                            <div class="megaFiche">
                                                <div class="error"><?= $message ?></div>
                                                <span class="valid"><?= $messageValid ?></span>
                                                <h1 class="major"><?=htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']));?></h1>
                                                <h3><?= writeCorrespondance(htmlspecialchars($fiche['Correspondance'])); ?></h3>
                                                <span class="badge mini premium">#<?= $fiche['IdFiche']; ?></span>
                                                <span class="badge mini filiere"><?= htmlspecialchars($fiche['Filiere']); ?></span>
                                                <span class="badge mini"><?= MyDate($fiche['Date']); ?></span>
                                                <span class="badge mini <?= writeQuality(htmlspecialchars($fiche['Quality'])); ?>"><?= writeQuality($fiche['Quality']); ?></span>
                                                <p><?= nl2br(cutPhrase(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])), 30)); ?></p>
                                                <div class="contenerDebloquer">
                                                    <div class="gold badgeMega badge">
                                                        <img src="images/cerise.png">
                                                        <div>
                                                            <?=$priceCerise; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="contenerDebloquer">
                                                <div class="badgeMega badge">
                                                    <img src="images/cadenas.png">
                                                    <input type="submit" value="Débloquer" name="Débloquer">
                                                </div>
                                            </div>
                                        </form>
                                        
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