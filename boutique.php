<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();
   
    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

	//Vérifier si l'utilisateur est ban du site
	isBan();
    
	//Permet d'obtenir des statistiques de visite
	viewPage("boutique");

    $articles = recupAllArticles();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Boutique - Download Cerise Pro</title>
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
                                <h2>Obtenir des pièces cerises</h2>
                                <h3>
                                    Qu'est-ce que les pièces cerises ? Il s’agit d’une monnaie virtuelle à dépenser dans le site Download Cerise Pro.</br>
                                    Les pièces cerises achetées sur une plateforme peuvent ne pas être disponibles sur d’autres plateformes.
                                </h3>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<section>
                                        <h2 class="major">Offre Gratuite</h2>
                                        <div class="contenerBoutique">
                                            <div>
                                                <h1 class="major">échange de fiche</h1>
                                                <a class="image" href="/envoyer"><img src="images/cerise-echange.png"></a>
                                                <div class="sousContener">
                                                    <p><b><a href="/envoyer">100 à 300 Cerises</a></b></p>
                                                    <p><i>1 fiche</i></p>
                                                </div>
                                            </div>
                                        </div>
									</section>

									<section>
                                        <h2 class="major">Offres payantes</h2>
                                        <div class="contenerBoutique">
                                            <?php foreach($articles as $article): ?>
                                            <div>
                                                <h1 class="major"><?= htmlspecialchars($article['Titre']); ?></h1>
                                                <a class="image" href="/article-<?= $article['IdProduit']; ?>"><img src="images/<?= htmlspecialchars($article['LinkImg']); ?>"></a>
                                                <div class="sousContener">
                                                    <p><b><a href="/article-<?= $article['IdProduit']; ?>"><?= substr(number_format(htmlspecialchars($article['Cerise']),2,',', ' '), 0, -3); ?><?php if(htmlspecialchars($article['CeriseBonus']) > 0) {echo(" + ".substr(number_format(htmlspecialchars($article['CeriseBonus']),2,',', ' '), 0, -3));}; ?> Cerises</a></b></p>
                                                    <p><i><?= str_replace(".", ",", htmlspecialchars($article['Prix'])); ?> €</i></p>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>

                                        </div>
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