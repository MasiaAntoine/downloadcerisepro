<?php
	$home = true;
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

	//Récupère l'identifiant de l'utilisateur
	$idUser = $_SESSION['idUser'];

    //supprime le compte
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Supprimer'])) {
            deleteAccount($idUser);
        }
    }
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
                                        <h1>Confirmation de suppression de compte</h1>
                                        <div>Veuillez noter que cette action entraînera la suppression définitive de toutes les données associées à votre compte, y compris les Cerises et les fiches débloquées, qui ne pourront pas être remboursées.</div>
                                        <div>Avant de poursuivre, nous vous demandons de bien vouloir confirmer que vous souhaitez effectivement supprimer votre compte. Si vous changez d'avis, vous pourrez toujours vous réinscrire à tout moment.</div>

                                        <h3></h3>
                                        <form method="post">
                                            <input type="submit" value="Supprimer" name="Supprimer" class="primary">
                                        </form>
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