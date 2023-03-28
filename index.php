<?php 
	$home = true;
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

	//Permet d'obtenir des statistiques de visite
	viewPage("accueil");
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Download Cerise Pro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="icon" type="image/png" href="/images/logo.png" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>

        <meta name="description" content="Fiche cerise pro gratuite pour les bac pro agora. Le meilleur site pour télécharger vos fiches cerise."/>
        <meta name="keywords" content="download, cerise pro, download cerise pro, gratuit, free, fr, fiche, fiche cerise pro, fiche cerise"/>
        <meta name="author" content="Download Cerise Pro" />
        <meta name="copyright" content="Download Cerise Pro" />
	</head>
	<body class="is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->

				<!-- Menu -->
				<?php include_once("menu.php"); ?>

				<!-- Banner -->
				<section id="banner">
					<div class="inner">
						<h2>Download Cerise Pro</h2>
						<p>Le <span>meilleur site</span> pour Télécharger vos <span>fiches cerise</span> gratuitement !</p>
					</div>
				</section>

				<!-- Wrapper -->
					<section id="wrapper">

						<!-- One -->
							<section id="one" class="wrapper spotlight style1">
								<div class="inner">
									<a class="image"><img src="images/pic01.jpg" alt="" /></a>
									<div class="content">
										<h2 class="major">FIABILITÉ</h2>
										<p>Nous certifions que nos fiches sont fiables à 100% de réussite.</p>
									</div>
								</div>
							</section>

						<!-- Two -->
							<section id="two" class="wrapper alt spotlight style2">
								<div class="inner">
									<a class="image"><img src="images/pic02.jpg" alt="" /></a>
									<div class="content">
										<h2 class="major">PROFESSIONNALISME</h2>
										<p>Nos fiches sont écrites dans un langage professionnel pour apporter plus de réussite.</p>
									</div>
								</div>
							</section>

						<!-- Three -->
							<section id="three" class="wrapper spotlight style3">
								<div class="inner">
									<a class="image"><img src="images/pic03.jpg" alt="" /></a>
									<div class="content">
										<h2 class="major">RAPIDITÉ</h2>
										<p>Les fiches se télécharge en un éclair ! Aucun temps de chargement.</p>
									</div>
								</div>
							</section>

						<!-- Four -->
							<section id="four" class="wrapper alt style1">
								<div class="inner">
									<h2 class="major">Obtenir les fiches</h2>
									<p id="ancrePole">
									Cerise pro existe pour les filières de BAC PRO Gestion et Administion, BAC PRO AGORA et de BTS Comptabilité et Gestion. 
									<br/>Download Cerise Pro vous propose des fiches appartenant aux deux filières respectives.
									</p>

									<div id="refreshPole">
									<?php include_once("assets/extensions/index/allFiliere.php"); ?>
									</div>

								</div>
							</section>

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