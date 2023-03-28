<?php
	$home = true;
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

	//Vérifier si l'utilisateur est ban du site
	isBan();

	//Récupère l'identifiant de l'utilisateur
	$idUser = $_SESSION['idUser'];

	//Permet d'obtenir des statistiques de visite
	viewPage("profil-$idUser");

    //récupère les données de l'utilisateur
    $data = dataUser($idUser);
    $avatar = $data['Avatar'];
    $nom = $data['Nom'];
    $prenom = $data['Prenom'];
    (int) $cerise = $data['Cerise'];
    $admin = $data['Admin'];

	//Si l'utilisateur clique sur le bouton de déconnexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Deconnexion'])) {
			session_destroy();
            redirectUrl("connexion");
		}
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Profil - Download Cerise Pro</title>
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
                                <h2>Profil</h2>
								<h3></h3>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<section id="profil">
										<div class="center">
											<img src="/images/profil/<?= openssl_decrypt($avatar, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?>.png" onerror="this.src='/images/profil/unknown.png'">
											
											<?php if($admin):?>
											<div>
												<a href="/admin/" class="badge mini filiere">Admin</a>
											</div>
											<?php endif; ?>

											<h2><?= htmlspecialchars(openssl_decrypt($nom, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])); ?> <?= htmlspecialchars(openssl_decrypt($prenom, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])); ?></h2>
											<div class="cerise">
												<img src="/images/cerise.png">
												<div class="nbrCerise"><?= substr(number_format(htmlspecialchars($cerise),2,',', ' '), 0, -3); ?></div>
											</div>

											<form method="post">
												<button name="Deconnexion" class="button primary small">Déconnexion</button>
												<a href="/parametres" class="button icon small solid fa-gear">paramètres</a>
											</form>
										</div>
									</section>

									<?php $allFiche = recupAllFichesOfUser($idUser, false); ?>
									<?php if(count(recupAllFichesOfUser($idUser, false)) != 0):?>
									<section>
										<h2 class="major">Fiche en attente de correction</h2>
										<div class="contenerFiche">
											<?php foreach($allFiche as $fiche): ?>
											<div>
												<div class="hautmegaFiche">
													<div class="rond"></div>
													<div class="rond"></div>
													<div class="rond"></div>
												</div>
												<div class="megaFiche">
													<h1 class="major"><?= htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']));?></h1>
													<h3><?= writeCorrespondance(htmlspecialchars($fiche['Correspondance'])); ?></h3>
													<span class="badge mini premium">#<?= htmlspecialchars($fiche['IdFiche']); ?></span>
													<span class="badge mini filiere"><?= htmlspecialchars($fiche['Filiere']); ?></span>
													<span class="badge mini"><?= MyDate(htmlspecialchars($fiche['Date'])); ?></span>
													<p><?= nl2br(cutPhrase(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])), 10)); ?></p>
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</section>
									<?php endif; ?>

									<?php $allFiche = recupAllFichesUnlockOfUser($idUser); ?>
									<?php if(count(recupAllFichesUnlockOfUser($idUser)) != 0):?>
									<section>
										<h2 class="major">Fiches Débloquées</h2>

										<div class="contenerFiche">
											<?php foreach($allFiche as $fiche): ?>
											<div>
												<div class="hautmegaFiche">
													<div class="rond"></div>
													<div class="rond"></div>
													<div class="rond"></div>
												</div>
												<div class="megaFiche">
													<h1 class="major"><?=htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']));?></h1>
													<h3><?= writeCorrespondance(htmlspecialchars($fiche['Correspondance'])); ?></h3>
													<span class="badge mini premium">#<?= $fiche['IdFiche']; ?></span>
													<span class="badge mini filiere"><?= htmlspecialchars($fiche['Filiere']); ?></span>
													<span class="badge mini"><?= MyDate(htmlspecialchars($fiche['Date'])); ?></span>
													<span class="badge mini <?= writeQuality(htmlspecialchars($fiche['Quality'])); ?>"><?= writeQuality($fiche['Quality']); ?></span>
													<p><?= nl2br(cutPhrase(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])), 10)); ?></p>
													
													<?php $IdFiche = $fiche['IdFiche']; ?>
													<div class="contener-stat-fiche">
														<div class="stat-fiche" id="view">
															<span><?= viewNumberFiche("fiche-$IdFiche"); ?></span>
															<img src="/images/view.png">
														</div>

														<div class="stat-fiche">
															<span><?= unlockedNumberFiche($IdFiche); ?></span>
															<img src="/images/debloque.png">
														</div>
														
														<div class="stat-fiche">
															<span><?= likeNumberFiche($IdFiche); ?></span>
															<img src="/images/like.png">
														</div>
													</div>

													<div class="contenerDebloquer">
														<div class="gold badgeMega badge">
															<a href="/fiche-<?= $fiche['IdFiche']; ?>" target="_blank">
																Voir
															</a>
														</div>
													</div>
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</section>
									<?php endif; ?>

									<?php $allFiche = recupAllFichesOfUser($idUser, true); ?>
									<?php if(count(recupAllFichesOfUser($idUser, true)) != 0):?>
									<section>
										<h2 class="major">Vos Fiches acceptées</h2>
										<div class="contenerFiche">
											<?php foreach($allFiche as $fiche): ?>
											<div>
												<div class="hautmegaFiche">
													<div class="rond"></div>
													<div class="rond"></div>
													<div class="rond"></div>
												</div>
												<div class="megaFiche">
													<h1 class="major"><?=htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']));?></h1>
													<h3><?= writeCorrespondance(htmlspecialchars($fiche['Correspondance'])); ?></h3>
													<span class="badge mini premium">#<?= $fiche['IdFiche']; ?></span>
													<span class="badge mini filiere"><?= htmlspecialchars($fiche['Filiere']); ?></span>
													<span class="badge mini"><?= MyDate(htmlspecialchars($fiche['Date'])); ?></span>
													<span class="badge mini <?= writeQuality(htmlspecialchars($fiche['Quality'])); ?>"><?= writeQuality($fiche['Quality']); ?></span>
													<p><?= nl2br(cutPhrase(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])), 10)); ?></p>
													
													<?php $IdFiche = $fiche['IdFiche']; ?>
													<div class="contener-stat-fiche">
														<div class="stat-fiche" id="view">
															<span><?= viewNumberFiche("fiche-$IdFiche"); ?></span>
															<img src="/images/view.png">
														</div>

														<div class="stat-fiche">
															<span><?= unlockedNumberFiche($IdFiche); ?></span>
															<img src="/images/debloque.png">
														</div>
														
														<div class="stat-fiche">
															<span><?= likeNumberFiche($IdFiche); ?></span>
															<img src="/images/like.png">
														</div>
													</div>
													
													<div class="contenerDebloquer">
														<div class="gold badgeMega badge">
															<a href="/fiche-<?= $fiche['IdFiche']; ?>" target="_blank">
																Voir
															</a>
														</div>
													</div>
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</section>
									<?php endif; ?>
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

	</body>
</html>