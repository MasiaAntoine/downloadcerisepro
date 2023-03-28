<?php
	$home = true;
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();
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
                                <h2>Paramètres</h2>
								<h3></h3>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
                                    <section>
                                        <div class="row gtr-uniform">
                                            <div class="col-4 col-12-xsmall">
                                                <h4>Profil</h4>
                                                <ul>
                                                    <li>
                                                        <a href="/personelData">
                                                            Données personnelles
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/profil">
                                                            Profil personnel
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/deleteAccount">
                                                            Supprimer votre compte
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-4 col-12-xsmall">
                                                <h4>Finances</h4>
                                                <ul>
                                                    <li>
                                                        <a href="factures">
                                                            Vos factures
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="col-4 col-12-xsmall">
                                                <h4>Légal</h4>
                                                <ul>
                                                    <li>
                                                        <a href="#">
                                                            Conditions Générales
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            Confidentialité
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            Crédits
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/cookie">
                                                            Les cookies
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-4 col-12-xsmall">
                                                <h4>Autre</h4>
                                                <ul>
                                                    <li>
                                                        <a href="/contact">
                                                            Contact
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <h3></h3>
                                        <a href="/profil" class="button primary">Retour</a>
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