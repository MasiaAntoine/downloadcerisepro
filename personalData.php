<?php
	$home = true;
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

	//Récupère l'identifiant de l'utilisateur
	$idUser = $_SESSION['idUser'];

	//Permet d'obtenir des statistiques de visite
	viewPage("personalData");

    //Récupère les données de visite
    $pagesView = recupPageView($idUser);

    //récupère les données de l'utilisateur
    $data = dataUser($idUser);

    //récupère les fiches liké par l'utilisateur
    $likeFiche = likeFiche($idUser);

    //récupère les fiches débloqué par l'utilisateur
    $unlockedFiche = unlockedFiche($idUser);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Paramètres - Download Cerise Pro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="icon" type="image/png" href="/images/logo.png" />
		<link rel="stylesheet" href="/assets/css/main.css" />
		<noscript><link rel="stylesheet" href="/assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Menu -->
				<?php include_once($_SERVER['DOCUMENT_ROOT']."/menu.php"); ?>

				<!-- Wrapper -->
					<section id="wrapper">
                        <header>
							<div class="inner">
                                <h2>Données Personnelles</h2>
								<h3></h3>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
                                    <section>
                                        <h1>Personnel</h1>
                                        <div>Nom : <?= openssl_decrypt($data['Nom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></div>
                                        <div>Prénom : <?= openssl_decrypt($data['Prenom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></div>
                                        <div>Adresse mail : <?= openssl_decrypt($data['Mail'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></div>
                                        <div>Identifiant Avatar : <?= openssl_decrypt($data['Avatar'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></div>
                                        <div>Date d'inscription : <?= $data['DateInscription'] ?></div>
                                        <h3></h3>

                                        <h1>Fiche liké</h1>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Fiche</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($likeFiche as $data): ?>
                                                <tr>
                                                    <td><a href="/fiche-<?= $data['IdFiche']; ?>" target="_blank">fiche-<?= $data['IdFiche']; ?></a</td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <h3></h3>

                                        <h1>Fiche Débloqué</h1>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Fiche</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($unlockedFiche as $data): ?>
                                                <tr>
                                                    <td><a href="/fiche-<?= $data['IdFiche']; ?>" target="_blank">fiche-<?= $data['IdFiche']; ?></a</td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <h3></h3>

                                        <h1>Données de Navigation</h1>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Page</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($pagesView as $data): ?>
                                                <tr>
                                                    <td><?= $data['NamePage']; ?></td>
                                                    <td><?= $data['DateVisit']; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <h3></h3>
                                            
                                        <a href="/parametres" class="button primary">Retour</a>
                                        <h3></h3>
                                    </section>
								</div>
							</div>

					</section>

				<!-- Footer -->
				<?php include_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>

			</div>

		<!-- Scripts -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>

	</body>
</html>