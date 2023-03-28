<?php
	$home = true;
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

    //récupère toute les factures de l'utilisateur
    $factures = recupAllFacturesUser($_SESSION['idUser']);
?>

<!DOCTYPE HTML>
<html lang="fr">
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
                                <h2>Factures</h2>
								<h3></h3>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
                                <section>
										<h4>Vos factures</h4>
										<div class="table-wrapper">
											<table class="alt">
												<thead>
													<tr>
														<th>N° Facture</th>
														<th>Date</th>
														<th>Prix</th>
														<th>Article</th>
													</tr>
												</thead>
												<tbody>
                                                    <?php foreach($factures as $facture): ?>
													<tr>
														<td><a href="facture-<?= openssl_decrypt($facture['NumeroFacture'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?>" target="_blank"><?= openssl_decrypt($facture['NumeroFacture'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></a></td>
														<td><?= MyDate($facture['DateVente']); ?></td>
														<td><?= str_replace(".", ",", $facture['Prix']); ?> €</td>
														<td><?= substr(number_format($facture['Cerise'],2,',', ' '), 0, -3); ?> Pièces Cerises</td>
													</tr>
                                                    <?php endforeach; ?>
												</tbody>
											</table>
										</div>
                                        
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