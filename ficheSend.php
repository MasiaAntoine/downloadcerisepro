<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

	//Vérifier si l'utilisateur est ban du site
	isBan();
    
	//Permet d'obtenir des statistiques de visite
	viewPage("envoyerfiche");

    //génère la vérification formulaire
    if(!isset($_SESSION['randomVerifForm'])) {
        $_SESSION['randomVerifForm'] = rand(1, 10);
    }
    $randomVerifForm = $_SESSION['randomVerifForm'];

    //Liste de toute les correspondances
    $correspondance = [
        "1.1.1", "1.1.2", "1.1.3", "1.1.4", "1.1.5", "1.2.1", "1.2.2", "1.2.3", "1.2.4", "1.2.5", "1.3.1", "1.3.2", "1.3.3", "1.3.4", 
        "2.1.1", "2.1.2", "2.1.3", "2.1.4", "2.2.1", "2.2.2", "2.2.3", "2.2.4", "2.2.1", "2.2.2", "2.2.3", "2.2.4", "2.3.1", "2.3.2", "2.3.3", "2.4.1", "2.4.2", "2.4.3", "2.4.4",
        "3.1.1", "3.1.2", "3.1.3", "3.2.1", "3.2.2", "3.2.3", "3.2.4", "3.3.1", "3.3.2", "3.3.3", "3.3.4", "3.3.5", "3.4.1", "3.4.2",
        "4.1.1", "4.1.2", "4.1.3", "4.1.4", "4.1.5", "4.1.6", "4.1.7", "4.1.8", "4.1.9", "4.2.1", "4.2.2", "4.2.3" 
    ];

    $message = "";
    $messageValid = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['Envoyer'])) {
            $error = false;
            $arrayPDF = $_FILES;
            
            //Vérifier si le ou la filière existe
            if(!$error) {
                if(($_POST['Filière'] != 'bts') && ($_POST['Filière'] != 'bac')) {
                    $error = true;
                    $message = "La filière ".htmlspecialchars($_POST['Filière'])." n'existe pas.";
                }
            }

            //Vérifier si la correspondance existe dans la liste
            if(!$error) {
                $error = true;
                foreach($correspondance as $c) {
                    if($_POST['Correspondance'] == $c) {
                        $error = false;
                    }
                }
                if($error) {
                    $message = "La correspondance ".htmlspecialchars($_POST['Correspondance'])." n'existe pas.";
                }
            }

            //Vérifier la limite du titre
            if(!$error) {
                if(strlen($_POST['Titre']) >= 100) {
                    $error = true;
                    $message = "Le titre est limité à 100 caractères";
                }
            }
            //Vérifier le minimum du titre
            if(!$error) {
                if(strlen($_POST['Titre']) < 1) {
                    $error = true;
                    $message = "Le titre est obligatoire.";
                }
            }

            //Vérifier la limite du text1
            if(!$error) {
                if(strlen($_POST['Text1']) >= 50000) {
                    $error = true;
                    $message = "Vous avez dépassé la limite de caractères dans la partie 'contexte'.";
                }
            }
            //Vérifier le minimum du text1
            if(!$error) {
                if(strlen($_POST['Text1']) < 1) {
                    $error = true;
                    $message = "La partie contexte est obligatoire.";
                }
            }

            //Vérifier la limite du text2
            if(!$error) {
                if(strlen($_POST['Text2']) >= 50000) {
                    $error = true;
                    $message = "Vous avez dépassé la limite de caractères dans la partie 'condition'.";
                }
            }
            //Vérifier le minimum du text2
            if(!$error) {
                if(strlen($_POST['Text2']) < 1) {
                    $error = true;
                    $message = "la partie contexte est obligatoire.";
                }
            }

            //Vérifier la limite du text3
            if(!$error) {
                if(strlen($_POST['Text3']) >= 50000) {
                    $error = true;
                    $message = "Vous avez dépassé la limite de caractères dans la partie 'production'.";
                }
            }
            //Vérifier le minimum du text3
            if(!$error) {
                if(strlen($_POST['Text3']) < 1) {
                    $error = true;
                    $message = "la partie production est obligatoire.";
                }
            }

            //Vérifier la limite du text4
            if(!$error) {
                if(strlen($_POST['Text4']) >= 50000) {
                    $error = true;
                    $message = "Vous avez dépassé la limite de caractères dans la partie 'analyse'.";
                }
            }
            //Vérifier le minimum du text4
            if(!$error) {
                if(strlen($_POST['Text4']) < 1) {
                    $error = true;
                    $message = "la partie analyse est obligatoire.";
                }
            }

            //Vérifier la limite du text5
            if(!$error) {
                if(strlen($_POST['Text5']) >= 50000) {
                    $error = true;
                    $message = "Vous avez dépassé la limite de caractères dans la partie 'description'.";
                }
            }
            //Vérifier le minimum du text5
            if(!$error) {
                if(strlen($_POST['Text5']) < 1) {
                    $error = true;
                    $message = "la partie description est obligatoire.";
                }
            }

            //Vérifier si au moins un PDF existe
            if(!$error) {
                for ($i=0; $i < count($arrayPDF['Fichier']['type']); $i++) {
                    if(($arrayPDF['Fichier']['size'][$i] <= 0) && ($arrayPDF['Fichier']['tmp_name'][$i] == "")) {
                        $error = true;
                        $message = "Une pièce jointe est obligatoire au minimum.";
                        break;
                    }
                }
            }

            //Limite de 6 PDF max
            if(!$error) {
                if(count($arrayPDF['Fichier']['type']) > 6) {
                    $error = true;
                    $message = "Vous êtes limité à 6 pièces jointes.";
                }
            }

            //Vérifier la taille de chaque pdf
            if(!$error) {
                for ($i=0; $i < count($arrayPDF['Fichier']['type']); $i++) {
                    if($arrayPDF['Fichier']['size'][$i] > 15728640) {
                        $error = true;
                        $message = "La pièce jointe ".$arrayPDF['Fichier']['name'][$i]." dépasse la limite des 15 Mo.";
                        break;
                    }
                }
            }

            //Vérifier le type de fichier
            if(!$error) {
                for ($i=0; $i < count($arrayPDF['Fichier']['type']); $i++) {
                    if($arrayPDF['Fichier']['type'][$i] != "application/pdf") {
                        $error = true;
                        $message = "La pièce jointe ".$arrayPDF['Fichier']['name'][$i]." n'est pas un fichier PDF.";
                        break;
                    }
                }
            }

            //Vérifier si l'envoi des fichiers n'as aucun problème
            if(!$error) {
                for ($i=0; $i < count($arrayPDF['Fichier']['type']); $i++) {
                    if($arrayPDF['Fichier']['error'][$i] != 0) {
                        $error = true;
                        $message = "Une erreur est survenu lors de l'envoi de la pièce jointe.";
                        break;
                    }
                }
            }

            //Vérifier si le ou la filière existe
            if(!$error) {
                if($_POST['checkCondition'] != 'on') {
                    $error = true;
                    $message = "Vous devez donner votre accord pour partager les données sur votre fiche.";
                }
            }
            
            //Vérifier le resultat corresponde
            if(!$error) {
                if((int) $_POST['randomVerifForm'] != $randomVerifForm) {
                    $error = true;
                    $message = "Le résultat n'est pas bon.";
                }
            }

            //retour réponse
            if(!$error) {
                $messageValid = "Votre fiche à bien été envoyé, vous recevrez un e-mail prochainement pour savoir si votre fiche à été accepté.";
                $Filière = htmlspecialchars($_POST['Filière']);
                $Correspondance = htmlspecialchars($_POST['Correspondance']);
                $Titre = htmlspecialchars($_POST['Titre']);
                $Text1 = htmlspecialchars($_POST['Text1']);
                $Text2 = htmlspecialchars($_POST['Text2']);
                $Text3 = htmlspecialchars($_POST['Text3']);
                $Text4 = htmlspecialchars($_POST['Text4']);
                $Text5 = htmlspecialchars($_POST['Text5']);
                $IdUser = $_SESSION['idUser'];

                //Envoie la fiche
                addFiche($Filière,$Correspondance,$Titre,$Text1,$Text2,$Text3,$Text4,$Text5,$IdUser);

                //Envoie l'email notif à l'admin
                mailNouvelleFicheNotification(writeCorrespondance($Correspondance));

                //renomme les fichier et les envoyer
                for ($i=0; $i < count($arrayPDF['Fichier']['type']); $i++) {
                    $file = $arrayPDF['Fichier']['name'][$i];
                    $editName = str_replace('_', ' ', $file);
                    $editName = str_replace('\'', ' ', $editName);
                    $editName = str_replace('"', ' ', $editName);
                    $idFicheForFile = recupLastIdFiche();
                    $endNameFile = $idFicheForFile."_".rand(100000, 999999)."_".$editName;

                    move_uploaded_file($_FILES['Fichier']['tmp_name'][$i], 'assets/fichesPDF/'.$endNameFile);
                }

                $_POST['Filière'] = "";
                $_POST['Correspondance'] = "";
                $_POST['Titre'] = "";
                $_POST['Text1'] = ""; 
                $_POST['Text2'] = ""; 
                $_POST['Text3'] = ""; 
                $_POST['Text4'] = ""; 
                $_POST['Text5'] = ""; 
                unset($_SESSION['randomVerifForm']);

                redirectUrl("/profil");
            }
        }
    }
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Envoyer une fiche - Download Cerise Pro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="icon" type="image/png" href="/images/logo.png" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
        
        <!-- Popup -->
        <?php include_once($_SERVER['DOCUMENT_ROOT']."/assets/extensions/all/popup.html"); ?>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Menu -->
				<?php include_once("menu.php"); ?>

				<!-- Wrapper -->
					<section id="wrapper">
                        <header>
							<div class="inner">
                                <h2>Envoyer votre fiche</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<section>
                                        <span class="error"><?= $message ?></span>
                                        <span class="valid"><?= $messageValid ?></span>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="fields">
                                                <div class="field">
                                                    <label for="Filière">Filière</label>
                                                    <select name="Filière" id="Filière">
														<option value="bac">Bac</option>
													</select>
                                                </div>
                                                <div class="field">
                                                    <label for="Correspondance">Correspondance</label>
                                                    <select name="Correspondance" id="Correspondance">
                                                        <?php foreach($correspondance as $c): ?>
														<option value="<?= $c; ?>"><?= writeCorrespondance($c); ?></option>
                                                        <?php endforeach; ?>
													</select>
                                                </div>
                                                <div class="field">
                                                    <label for="Titre">Titre</label>
                                                    <input id="Titre" name="Titre" type="text" autocomplete="off" minlength="1" maxlength="100" placeholder="Saisissez votre titre" value="<?php if(isset($_POST['Envoyer'])) { echo($_POST['Titre']); } ?>"/>
                                                </div>
                                                <div class="field">
                                                    <label for="Text1">1 | LE CONTEXTE DE RÉALISATION DE LA SITUATION PROFESSIONNELLE DESCRIPTION DU CADRE (L'ORGANISATION, LE SERVICE) ; DESCRIPTION DES TÂCHES DEMANDÉES, LES RÉSULTATS ATTENDUS</label>
                                                    <textarea id="Text1" name="Text1" type="text" autocomplete="off" minlength="1" maxlength="50000"><?php if(isset($_POST['Envoyer'])) { echo($_POST['Text1']); } ?></textarea>
                                                </div>
                                                <div class="field">
                                                    <label for="Text2">2 | LES CONDITIONS DE RÉALISATION DE LA SITUATION PROFESSIONNELLE MOYENS À DISPOSITION, OUTILS À DISPOSITION, DÉLAIS, PERSONNES RESSOURCES ; LA RÉALISATION : DÉMARCHE, CHOIX, DÉCISIONS, ESSAIS ; TRAITEMENT : LES ÉLÉMENTS COMPLEXES, LES ALÉAS, INCIDENTS, IMPRÉVUS</label>
                                                    <textarea id="Text2" name="Text2" type="text" autocomplete="off" minlength="1" maxlength="50000"><?php if(isset($_POST['Envoyer'])) { echo($_POST['Text2']); } ?></textarea>
                                                </div>
                                                <div class="field">
                                                    <label for="Text3">3 | LES PRODUCTIONS RÉSULTANT DE LA SITUATION PROFESSIONNELLE RÉSULTATS ET PRODUCTIONS OBTENUS</label>
                                                    <textarea id="Text3" name="Text3" type="text" autocomplete="off" minlength="1" maxlength="50000"><?php if(isset($_POST['Envoyer'])) { echo($_POST['Text3']); } ?></textarea>
                                                </div>
                                                <div class="field">
                                                    <label for="Text4">4 | ANALYSE DE L'ACTION MENÉE RÉUSSITES, DIFFICULTÉS</label>
                                                    <textarea id="Text4" name="Text4" type="text" autocomplete="off" minlength="1" maxlength="50000"><?php if(isset($_POST['Envoyer'])) { echo($_POST['Text4']); } ?></textarea>
                                                </div>
                                                <div class="field">
                                                    <label for="Text5">5 | DÉCRIVEZ VOTRE COMPÉTENCE CE DONT VOUS ÊTES MAINTENANT CAPABLE APRÈS AVOIR FAIT CETTE ACTIVITÉ</label>
                                                    <textarea id="Text5" name="Text5" type="text" autocomplete="off" minlength="1" maxlength="50000"><?php if(isset($_POST['Envoyer'])) { echo($_POST['Text5']); } ?></textarea>
                                                </div>
                                                <div class="field">
                                                    <h4>La / les pièces(s) jointe(s) correspondante(s)</h4>
                                                    <label id="FichierName" class="button primary icon solid fa-download" for="Fichier">Aucun fichier choisi</label>
                                                    <div>Conditions, 6 PDF maximum, 15 Mo maximum par PDF.</div>
                                                    <input onchange="file_changed()" id="Fichier" name="Fichier[]" type="file" accept="application/pdf" multiple/>
                                                </div>
                                                <div class="field check">
                                                    <input type="checkbox" id="checkCondition" name="checkCondition">
                                                    <label for="checkCondition">Je consens à ce que toutes les données de mon formulaire sont publiées, si valider sur le site download cerise pro, et accessible par quiconque. Une fois ma fiche envoyée je reconnais que toutes les données appartiendront au site Download Cerise Pro.</label>
                                                </div>
                                                <div class="field">
                                                    <label>Vérification</label>
                                                    <img class="verif" src="/images/verifForm/<?= $randomVerifForm ?>.png">
                                                    <input id="randomVerifForm" name="randomVerifForm" type="text" placeholder="Saisissez le résultat" />
                                                </div>
                                            </div>
                                            <ul class="actions">
                                                <li><input type="submit" value="Envoyer" name="Envoyer" class="primary"></li>
                                            </ul>
                                        </form>
                                        
									</section>
								</div>
							</div>

					</section>

				<!-- Footer -->
				<?php include_once("footer.php"); ?>

			</div>

		<!-- Scripts -->
			<script src="assets/js/app.js"></script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="assets/js/app.js"></script>
            <script>
                window.addEventListener('load', () => {
                    setTimeout("popup(true, 2)", 250);
                });

                function file_changed() {
                    lengthFiles = document.getElementById('Fichier').files.length
                    if(lengthFiles > 1) {
                        document.getElementById('FichierName').innerHTML = lengthFiles+" Fichiers sélectionnées";
                    } 
                    else if(lengthFiles = 1) {
                        document.getElementById('FichierName').innerHTML = document.getElementById('Fichier').files[0].name;
                    }
                    else if(lengthFiles < 0) {
                        document.getElementById('FichierName').innerHTML = "Aucun fichier choisi";
                    }
                }
            </script>

	</body>
</html>