<?php
    //FAKE PAYPAL ACCOUNT
    //email sb-wl47zx1457633@personal.example.com
    //password btU&oK2!

    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();
    
	//Vérifier si l'utilisateur est ban du site
	isBan();
    
    //récupérer l'id article
    $IdArticle = (int) $_GET['IdArticle'];
    
	//Permet d'obtenir des statistiques de visite
	viewPage("article-$IdArticle");

    //Vérifier si l'article existe
    if(!recupDataArticles($IdArticle)) {
        redirectUrl("/boutique");
    }

    //Taux TVA
    $tauxTVA = 5.5;

    //Appliquer les données de l'article
    $article = recupDataArticles($IdArticle);
    
    $name = htmlspecialchars($article['Titre']);
    $nameImage = htmlspecialchars($article['LinkImg']);
    $nbrPieceCerise = htmlspecialchars($article['Cerise']);
    $bonusPieceCerise = htmlspecialchars($article['CeriseBonus']);
    
    $totalPieceCerise = $bonusPieceCerise + $nbrPieceCerise;
    $price = $nbrPieceCerise/100-0.01;
    if($name == "TESTACHAT") {
        $price = 0.01;
    }
    $priceAffichage = str_replace(".", ",", $price);

    if($bonusPieceCerise > 0) {
        $description = "Vous obtiendrez ".substr(number_format($nbrPieceCerise,2,',', ' '), 0, -3)." pièces cerises sur votre compte pour une valeur de $priceAffichage €.<br>Offre bonus, par gratitude nous vous offrons ".substr(number_format($bonusPieceCerise,2,',', ' '), 0, -3)." pièces cerises sur votre compte.<br>Vous obtiendrez un total de <span id='totalPiece'>".substr(number_format($totalPieceCerise,2,',', ' '), 0, -3)."</span> pièces cerises.";
    } else {
        $description = "Vous obtiendrez <span id='totalPiece'>".substr(number_format($nbrPieceCerise,2,',', ' '), 0, -3)."</span> pièces cerises sur votre compte pour une valeur de $priceAffichage €.";
    }
    
    
    $priceHT = round($price-($price*$tauxTVA/100), 2);
    $TVA = round($tauxTVA/100*$price, 2);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Achat de l'article #<?= $IdArticle; ?> - Download Cerise Pro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="icon" type="image/png" href="/images/logo.png" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        
        <!-- Faux Paypal pour faire des tests avec l'API. -->
        <!-- <script src="https://www.paypal.com/sdk/js?client-id=AZdSSdqKHQU6acjcamT9569TUZIkE9Xb1FJ5P8orKqsqC2okW_IZACJBmx7Pvn1pNoPlRaDdeFdaq4aA&currency=EUR&buyer-country=FR"></script> -->
        
        <!-- Vrai Paypal pour vraiment recevoir les paiements. -->
        <script src="https://www.paypal.com/sdk/js?client-id=AXZzkt22VhPvkWJGLzzjaSYg5Ew27smu7dUjT9tPV0cPqCEiyN16inNVw-6wHjtXa1qb5_mHk91qaANT&currency=EUR"></script>
	</head>
	<body class="is-preload">
		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Menu -->
				<?php include_once("menu.php"); ?>

				<!-- Wrapper -->
                    <!-- Popup -->
                    <?php include_once($_SERVER['DOCUMENT_ROOT']."/assets/extensions/all/popup.html"); ?>

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
                                    <h2 class="major"><?= $name; ?></h2>

                                    <div class="box alt">
                                        <div class="row gtr-uniform">
                                            <div class="col-4 col-12-xsmall">
                                                <span class="image fit">
                                                    <img src="images/<?= $nameImage; ?>" alt="">
                                                </span>
                                            </div>
                                            <div class="col-8 col-12-xsmall">
                                                <?= $description; ?>
                                                <br><br>
                                                <div>Merci à vos achats, vous contribuez au bon fonctionnement de Download Cerise Pro et nous vous remercions !</div> 
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                
                                <section>
                                    <h2 class="major">Récapitulatif de votre commande</h2>
                                    <div class="table-wrapper">
                                        <table class="alt">
                                            <thead>
                                                <tr>
                                                    <th>Libellé</th>
                                                    <th>Prix</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pièces Cerises - HT</td>
                                                    <td><?= str_replace(".", ",", $priceHT); ?> €</td>
                                                </tr>
                                                <tr>
                                                    <td>TVA - <?= str_replace(".", ",", $tauxTVA); ?> %</td>
                                                    <td><?= str_replace(".", ",", $TVA); ?> €</td>
                                                </tr>
                                                <tr>
                                                    <td>Frais</td>
                                                    <td>0,00 €</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="1">Total - TTC</td>
                                                    <td><?= str_replace(".", ",", $priceHT+$TVA); ?> €</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </section>

                                <section>
                                    <h2 class="major">Mode paiement</h2>

                                    <div id="paypal-button-container"></div>
                                    <div id="return"></div>
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

            <script>
            paypal.Buttons({
                // Sets up the transaction when a payment button is clicked
                createOrder: (data, actions) => {
                return actions.order.create({
                    "purchase_units": [{
                        "custom_id": "<?= $IdArticle; ?>|<?= $tauxTVA; ?>",
                        "amount": {
                        "currency_code": "EUR",
                        "value": "<?= $price; ?>",
                        "breakdown": {
                            "item_total": {  /* Required when including the items array */
                                "currency_code": "EUR",
                                "value": "<?= $price; ?>"
                            }
                        },
                        },
                        "items": [
                        {
                            "name": "<?= $name; ?>", /* Shows within upper-right dropdown during payment approval */
                            "description": "<?= substr(number_format($totalPieceCerise,2,',', ' '), 0, -3).' pièces cerises'; ?>",
                            "unit_amount": {
                                "currency_code": "EUR",
                                "value": "<?= $price; ?>"
                            },
                            "quantity": "1"
                        },
                        ],
                    }],
                    
                    // "application_context": {
                    //     "shipping_preference": "NO_SHIPPING"
                    // },
                });
                },
                // Finalize the transaction after payer approval
                onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    var data = new FormData();

                    data.append( "form", JSON.stringify(orderData, null, 2) );
                    fetch('assets/extensions/boutique/recupDataValidAchat.php', {
                        method: 'POST',
                        body: data
                    }).then(function(response) {
                        if (response.status >= 200 && response.status < 300) {
                            return response.text()
                        }
                        throw new Error(response.statusText)
                    }).then(function(response) {
                        document.getElementById('return').innerHTML = response;
                    });
                    
                    popup(true, 3);
                    //console.log(JSON.stringify(orderData, null, 2));
                });
                }
                
            }).render('#paypal-button-container');
            </script>

	</body>
</html>