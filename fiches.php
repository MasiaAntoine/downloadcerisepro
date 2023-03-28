<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

	//Permet d'obtenir des statistiques de visite
	viewPage("fiches");

	//Vérifier si l'utilisateur est ban du site
	isBan();
	
	//Si le get n'existe pas, rediriger vers le get BAC
    if(!isset($_GET['filiere']) or !isset($_GET['pole']) or !isset($_GET['classement']) or !isset($_GET['page'])) {
        redirectUrl("fiches-bac-p1-date-1");
    }

	//récupère le GET
	$filiere = htmlspecialchars($_GET['filiere']);
	$pole = (int) htmlspecialchars($_GET['pole']);
	$classement = htmlspecialchars($_GET['classement']);
	$page = (int) htmlspecialchars($_GET['page']);

	// -- Protection et vérification des filtres -- \\
	//
	// Vérifier si la filière existe.
	if($filiere != "bts" and $filiere != "bac") {
		redirectUrl("fiches-bac-p1-date-1");
	}

	// Vérifier si le mot clef du trie existe bien.
	if($classement != "date" and $classement != "quality" and $classement != "correspondance" and $classement != "titre") {
		redirectUrl("fiches-bac-p1-date-1");
	}

	// Vérifier si le pole est entre 1 et 4
	if($pole < 1 or $pole > 4) {
		redirectUrl("fiches-bac-p1-date-1");
	}
	// Vérifier que le pole soit bien un chiffre
	if(!is_int($pole)) {
		redirectUrl("fiches-bac-p1-date-1");
	}

	// Vérifier que la page ne soit pas un chiffre négatif
	if($page < 1) {
		redirectUrl("fiches-bac-p1-date-1");
	}
	// Vérifier que la page soit bien un chiffre
	if(!is_int($page)) {
		redirectUrl("fiches-bac-p1-date-1");
	}

	//Système de pagination
	$pagination['actual'] = (int) $page;
	$pagination['limit'] = 15;
	$pagination['ficheStart'] = ($pagination['actual']-1)*$pagination['limit'];
	$pagination['total'] = (int) selectAllFiches($filiere,$pole,$classement,$pagination['limit'],$pagination['ficheStart'],true)[0]['count(*)'];
	$pagination['page'] = (int) ceil($pagination['total']/$pagination['limit']);
	
	//filter les fiches
	$fiches = selectAllFiches($filiere,$pole,$classement,$pagination['limit'],$pagination['ficheStart']);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Fiches - Download Cerise Pro</title>
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
								<h2>Fiches cerise pro</h2>
                                <ul class="actions">
                                    <li><a href="fiches-bac-p<?= $pole ?>-<?= $classement ?>-1" class="button <?php if($filiere=="bac") {echo("primary");} ?>">BAC</a></li>
                                    <li><a href="fiches-bts-p<?= $pole ?>-<?= $classement ?>-1" class="button <?php if($filiere=="bts") {echo("primary");} ?>">BTS</a></li>
                                </ul>
                                <ul class="actions">
                                    <li><a href="fiches-<?= $filiere ?>-p1-<?= $classement ?>-1" class="button <?php if($pole=="1") {echo("primary");} ?>">pôle 1</a></li>
                                    <li><a href="fiches-<?= $filiere ?>-p2-<?= $classement ?>-1" class="button <?php if($pole=="2") {echo("primary");} ?>">pôle 2</a></li>
                                    <li><a href="fiches-<?= $filiere ?>-p3-<?= $classement ?>-1" class="button <?php if($pole=="3") {echo("primary");} ?>">pôle 3</a></li>
                                    <li><a href="fiches-<?= $filiere ?>-p4-<?= $classement ?>-1" class="button <?php if($pole=="4") {echo("primary");} ?>">pôle 4</a></li>
                                </ul>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper" id="fiche">
								<div class="inner">
									<section>
										<h3 class="major">Tier par</h3>
										<ul class="actions" id="classement">
											<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-quality-<?= $page ?>#fiche" class="button small <?php if($classement=="quality") {echo("primary");} ?>">qualité</a></li>
											<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-correspondance-<?= $page ?>#fiche" class="button small <?php if($classement=="correspondance") {echo("primary");} ?>">correspondance</a></li>
											<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-titre-<?= $page ?>#fiche" class="button small <?php if($classement=="titre") {echo("primary");} ?>">titre</a></li>
											<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-date-<?= $page ?>#fiche" class="button small <?php if($classement=="date") {echo("primary");} ?>">date</a></li>
										</ul>

										<div class="table-wrapper">
											<table class="alt">
												<thead>
													<tr>
														<th>Qualité</th>
														<th>Correspondance</th>
														<th>Titre</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($fiches as $fiche): ?>
														<?php 
															$badgeMe = false;
															if(isset($_SESSION['idUser'])) {
																if($fiche['IdUser'] == $_SESSION['idUser']) {
																	$badgeMe = true;
																}
															} 
														?>
													<tr>
														<td>
															<?php if($badgeMe) {echo('<div class="badge me mini">Me</div>');} ?>
															<div class="badge <?= writeQuality(htmlspecialchars($fiche['Quality'])); ?>">
															<?= writeQuality(htmlspecialchars($fiche['Quality'])); ?>
															</div>
														</td>
														<td><a href="fiche-<?= $fiche['IdFiche']; ?>"><?= writeCorrespondance(htmlspecialchars($fiche['Correspondance'])); ?></a></td>
														<td><a href="fiche-<?= $fiche['IdFiche']; ?>"><?= ucfirst(strtolower(htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])))); ?></a></td>
														<td><?= MyDate($fiche['Date']); ?></td>
													</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										</div>

										<h4>Page</h4>
										<ul class="pagination">
											<?php if($pagination['actual']-1 <= 0): ?>
												<li><span class="button small disabled">Prev</span></li>
											<?php else: ?>
												<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-<?= $classement ?>-<?= $pagination['actual']-1 ?>#classement" class="button small">Prev</a></li>
											<?php endif; ?>


											<?php for($i=-5;$i<6;$i++): ?>
												<?php if($i+$pagination['actual']>0 AND $i+$pagination['actual']<=$pagination['page']): ?>
												<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-<?= $classement ?>-<?= $i+$pagination['actual'] ?>#classement" class="page <?php if($i+$pagination['actual']==$pagination['actual']) {echo("active");} ?>"><?= $i+$pagination['actual']; ?></a></li>
												<?php endif; ?>
											<?php endfor; ?>

											<?php if($pagination['actual'] >= $pagination['page']): ?>
												<li><span class="button small disabled">Next</span></li>
											<?php else: ?>
												<li><a href="fiches-<?= $filiere ?>-p<?= $pole ?>-<?= $classement ?>-<?= $pagination['actual']+1 ?>#classement" class="button small">Next</a></li>
											<?php endif; ?>
										</ul>
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

	</body>
</html>