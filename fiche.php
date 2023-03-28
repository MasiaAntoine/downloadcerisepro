<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

	//Vérifier si l'utilisateur est ban du site
	isBan();
    
	//récupère le GET
	$IdFiche = $_GET['IdFiche'];

	//Permet d'obtenir des statistiques de visite
	viewPage("fiche-$IdFiche");

    //Donnée sur la fiche
    $fiche = selectFicheOfId($IdFiche);

    //Sécurité
    if($fiche['Public'] == false) {
        redirectUrl("/");
    }

    //Si rien n'empeche le bloquement de la fiche alors l'afficher
    $ficheBlockOrUnblock = true;

    if(isset($_SESSION['idUser'])) {
        //Si l'utilisateur n'a pas débloqué la fiche pré afficher la fiche
        if(!verifFicheUnlocked($_SESSION['idUser'],$IdFiche)) {
            $ficheBlockOrUnblock = false;
        }
        //Si la fiche appartient à l'utilisateur l'afficher
        if($fiche['IdUser'] == $_SESSION['idUser']) {
            $ficheBlockOrUnblock = true;
        }
    }

    //Si l'utilisateur n'est pas connecter pré afficher la fiche
    if(!isset($_SESSION['idUser'])) {
        $ficheBlockOrUnblock = false;
    }

    //Ajouter le like
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Like'])) {
            //Vérifier si l'utilisateur à bien débloqué la fiche
            if($ficheBlockOrUnblock) {
                //Vérifier si l'utilisateur n'as pas encore liké la fiche
                if(!verifLikeFiche($_SESSION['idUser'],$IdFiche)) {
                    addLikeForFiche($_SESSION['idUser'],$IdFiche);
                }
            }
        }
    }

    $motClef = explode(" ", writeCorrespondance($fiche['Correspondance']));
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title><?= writeCorrespondance($fiche['Correspondance']); ?> - <?= htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])) ?> - Download Cerise Pro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="icon" type="image/png" href="/images/logo.png" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        
        <meta name="description" content="<?= nl2br(cutPhrase(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])), 30)); ?>"/>
        <meta name="keywords" content="download, cerise pro, download cerise pro, bac pro, agora, ga, gestion administration, <?php for($i=0;$i<count($motClef);$i++) {echo($motClef[$i].', ');} ?><?= writeCorrespondance($fiche['Correspondance']); ?>"/>
        <meta name="author" content="Download Cerise Pro" />
        <meta name="copyright" content="Download Cerise Pro" />
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
                                <h2><?= htmlspecialchars(openssl_decrypt($fiche['Titre'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])); ?></h2>
                                <h3><?= writeCorrespondance($fiche['Correspondance']); ?></h3>
                                <span class="badge mini premium">#<?= htmlspecialchars($fiche['IdFiche']); ?></span>
                                <span class="badge mini filiere"><?= htmlspecialchars($fiche['Filiere']); ?></span>
                                <span class="badge mini"><?= MyDate(htmlspecialchars($fiche['Date'])); ?></span>
                                <span class="badge mini <?= writeQuality(htmlspecialchars($fiche['Quality'])); ?>"><?= writeQuality(htmlspecialchars($fiche['Quality'])); ?></span>
							
                                <p></p>
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

                                <p></p>
                            
                            </div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
                                    <section>
                                    </section>

									<section>
                                        <h3 class="major">1 | Le contexte de réalisation de la situation professionnelle Description du cadre (l'organisation, le service) ; Description des tâches demandées, les résultats attendus</h3>
                                        <?php if($ficheBlockOrUnblock): ?>
                                        <p><?= nl2br(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']))); ?></p>
                                        <?php elseif(!$ficheBlockOrUnblock): ?>
                                        <p><?= nl2br(cutPhrase(htmlspecialchars(openssl_decrypt($fiche['Text1'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])), 30)); ?></p>
                                        <?php endif; ?>

                                        <!-- Badge débloquer -->
                                        <?php if(!$ficheBlockOrUnblock): ?>
                                        <div class="contenerDebloquer">
                                            <div class="badgeMega badge">
                                                <img src="images/cadenas.png">
                                                <a href="/debloquer-<?=$IdFiche;?>">Débloquer</a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <h3 class="major">2 | Les conditions de réalisation de la situation professionnelle Moyens à disposition, outils à disposition, délais, personnes ressources ; La réalisation : Démarche, choix, décisions, essais ; Traitement : Les éléments complexes, les aléas, incidents, imprévus</h3>
                                        <?php if($ficheBlockOrUnblock): ?>
                                        <p><?= nl2br(htmlspecialchars(openssl_decrypt($fiche['Text2'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']))); ?></p>
                                        <?php elseif(!$ficheBlockOrUnblock): ?>
                                        <div class="masque"></div>
                                        <?php endif; ?>
                                        
                                        <h3 class="major">3 | Les productions résultant de la situation professionnelle Résultats et productions obtenus</h3>
                                        <?php if($ficheBlockOrUnblock): ?>
                                        <p><?= nl2br(htmlspecialchars(openssl_decrypt($fiche['Text3'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']))); ?></p>
                                        <?php elseif(!$ficheBlockOrUnblock): ?>
                                        <div class="masque"></div>
                                        <?php endif; ?>
                                        
                                        <h3 class="major">4 | Analyse de l'action menée Réussites, difficultés</h3>
                                        <?php if($ficheBlockOrUnblock): ?>
                                        <p><?= nl2br(htmlspecialchars(openssl_decrypt($fiche['Text4'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']))); ?></p>
                                        <?php elseif(!$ficheBlockOrUnblock): ?>
                                        <div class="masque"></div>
                                        <?php endif; ?>
                                        
                                        <h3 class="major">5 | Décrivez votre compétence Ce dont vous êtes maintenant capable après avoir fait cette activité</h3>
                                        <?php if($ficheBlockOrUnblock): ?>
                                        <p><?= nl2br(htmlspecialchars(openssl_decrypt($fiche['Text5'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']))); ?></p>
                                        <?php elseif(!$ficheBlockOrUnblock): ?>
                                        <div class="masque"></div>
                                        <?php endif; ?>

                                        <h3 class="major">Pièce(s) Jointe(s)</h3>
                                        <div class="contenerPDF">
                                        <?php
                                            $pdf = scandir("assets/fichesPDF");
                                            for($i=0;$i<count($pdf);$i++) {
                                                $chemin = strstr($pdf[$i], $IdFiche."_");
                                                if(ucfirst(explode("_", $pdf[$i])[0]) == $fiche["IdFiche"]) {
                                                    if($chemin) {
                                                        $namePDF = ucfirst(explode("_", $pdf[$i])[2]);
                                                        $namePDF = htmlspecialchars($namePDF);
                                                        echo("<div>");

                                                        echo("<img class='pdf' src='images/pdf.png'>");

                                                        echo("<div>");

                                                        if($ficheBlockOrUnblock) {
                                                            echo("<a target='_blank' href='assets/fichesPDF/$chemin'>$namePDF</a>");
                                                        } else {
                                                            echo("<span>$namePDF</span>"); 
                                                        }

                                                        echo("</div>");

                                                        echo("</div>");
                                                    }
                                                }
                                            }
                                        ?>
                                        </div>
                                        
                                        <!-- Badge débloquer -->
                                        <?php if(!$ficheBlockOrUnblock): ?>
                                        <div class="contenerDebloquer">
                                            <div class="badgeMega badge">
                                                <img src="images/cadenas.png">
                                                <a href="/debloquer-<?=$IdFiche;?>">Débloquer</a>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <!-- Like la fiche -->
                                        <?php if($ficheBlockOrUnblock): ?>
                                        <?php if(!verifLikeFiche($_SESSION['idUser'],$IdFiche)): ?>
                                        <div class="contenerLikeFiche">
                                            <h1>Avez-vous trouvé cette fiche utile ?</h1>
                                            <form method="post">
                                                <button name="Like">
                                                    <img src="/images/like.png">
                                                </button>
                                            </form>
                                        </div>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        
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