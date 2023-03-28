<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

    //Récupère l'id de session
    $IdUser = $_SESSION['idUser'];

    //récupérer l'id article
    $NumeroFacture = openssl_encrypt($_GET['IdFacture'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    

    //récupère les données de la facture
    $facture = recupFacture($NumeroFacture);

    //récupère les données de l'utilisateur
    $data = dataUser($IdUser);

    //Pass droit pour les admins 
    //(permet de consulter la facture qui ne lui appartient pas)
    if($data['Admin'] == false) {
        //Verifier si la facture appartient bien à l'utilisateur
        if($IdUser != $facture['IdUser']) {
            redirectUrl("/factures");
        }
    }
    
    //Récupère les données de la facture
    $Titre = htmlspecialchars($facture['Titre']);
    $Lien = htmlspecialchars($facture['LinkImg']);
    $PieceCerise = substr(number_format(htmlspecialchars($facture['Cerise']),2,',', ' '), 0, -3);
    $tauxTVA = $facture['TauxTVA'];
    $Date = MyDate($facture['DateVente']);
    
    $price = htmlspecialchars($facture['Prix']);
    $priceAffichage = str_replace(".", ",", $price);
    
    $priceHT = str_replace(".", ",", round($price-($price*$tauxTVA/100), 2));
    $TVA = round($tauxTVA/100*$price, 2);


    
    $Nom = openssl_decrypt($facture['Nom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    $Prenom = openssl_decrypt($facture['Prenom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);
    $Adresse = openssl_decrypt($facture['Adresse'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']);

    $Nom = strtoupper(htmlspecialchars($Nom));
    $Prenom = ucfirst(htmlspecialchars($Prenom));
    $Adresse = htmlspecialchars($Adresse);

    //Donnée du qrcode
    $QrCodeCvSize = "150x150";
    $QrCodeCvlink = getUrl();

    //Donnée de l'entreprise
    $NomEntreprise = "Download Cerise Pro";
    $Siret = "Error ...";
    $AdresseEntreprise = "Error ...";
    $MessageDeFin = "Qu'est-ce que les pièces cerises ? Il s’agit d’une monnaie virtuelle à dépenser dans le site download cerise pro. Les pièces cerises achetées sur une plateforme peuvent ne pas être disponibles sur d’autres plateformes.";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>Facture N° <?= openssl_decrypt($NumeroFacture, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?> - Download Cerise Pro</title>
    <meta charset="utf-8" />

    <link rel="icon" type="image/png" href="/images/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link media="print" href="/assets/css/facture.css" /> 
    <link rel="stylesheet" href="/assets/css/facture.css" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="container mt-5 mb-5">

        <div class="row d-flex justify-content-center">

            <div class="col-md-10">

                <div class="card" id="element">


                    <div class="text-left logo p-2 px-5">
                        <img class="mt-2 mb-2" src="/images/logo.png" width="60">
                    </div>

                    <div class="invoice p-5">

                        <h5>Facture N° <?= openssl_decrypt($NumeroFacture, $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></h5>

                        <span class="font-weight-bold d-block mt-4 text-right"><?=$NomEntreprise;?></span>
                        <span class="d-block text-right"><?=$AdresseEntreprise;?></span>
                        <span class="d-block text-right text-muted">Siret : <?=$Siret;?></span>

                        <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">

                            <table class="table table-borderless">
                                
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="py-2">

                                                <span class="d-block text-muted">Date d'achat</span>
                                            <span><?= $Date; ?></span>
                                                
                                            </div>
                                        </td>

                                        <td>
                                            <div class="py-2">

                                                <span class="d-block text-muted">Paiement</span>
                                                <span><img src="/images/modePaiement/paypal.png" width="35" /></span>
                                                
                                            </div>
                                        </td>

                                        <td>
                                            <div class="py-2">

                                                <span class="d-block text-muted">Adresse de livraison</span>
                                                <span class="d-block font-weight-bold"><?= $Nom; ?> <?= $Prenom; ?></span>
                                                <span><?= $Adresse; ?></span>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>




                        <div class="product border-bottom table-responsive">

                            <table class="table table-borderless">

                                <tbody>
                                    <tr>
                                        <td width="20%">
                                            
                                            <img src="/images/<?= $Lien; ?>" width="100">

                                        </td>
                                    
                                        <td width="60%">
                                            <span class="font-weight-bold"><?= $Titre; ?></span>
                                            <div class="product-qty">
                                                <span class="d-block">Quantité : 1</span>
                                                <span>Pièces cerises : <?= $PieceCerise; ?></span>
                                                
                                            </div>
                                        </td>
                                        <td width="20%">
                                            <div class="text-right">
                                                <span class="font-weight-bold"><?= $priceHT; ?> €</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody> 
                                
                            </table>
                            


                        </div>



                        <div class="row d-flex justify-content-end">

                            <div class="col-md-5">

                                <table class="table table-borderless">

                                    <tbody class="totals">

                                        <tr>
                                            <td>
                                                <div class="text-left">

                                                    <span class="text-muted">Sous total</span>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span><?= $priceHT; ?> €</span>
                                                </div>
                                            </td>
                                        </tr>


                                            <tr>
                                            <td>
                                                <div class="text-left">

                                                    <span class="text-muted">TVA - <?= str_replace(".", ",", $tauxTVA); ?> %</span>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span><?= str_replace(".", ",", $TVA); ?> €</span>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="text-left">

                                                    <span class="text-muted">Frais</span>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span>0,00 €</span>
                                                </div>
                                            </td>
                                        </tr>

                                            <tr>
                                            <td>
                                                <div class="text-left">

                                                    <span class="text-muted">Total</span>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span class="text-success"><?= str_replace(".", ",", $price); ?> €</span>
                                                </div>
                                            </td>
                                        </tr>


                                            <tr class="border-top border-bottom">
                                            <td>
                                                <div class="text-left">

                                                    <span class="font-weight-bold">Total TTC</span>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span class="font-weight-bold"><?= str_replace(".", ",", $price); ?> €</span>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                    
                                </table>
                                
                            </div>
                            


                        </div>
                        
                        <p><?=$MessageDeFin;?></p>
                        <p class="font-weight-bold mb-0">Merci d'avoir acheté chez nous !</p>
                        <span class="d-block">Équipe <?=$NomEntreprise;?></span>

                        <div class="text-right d-block">
                            <button class="btn btn-primary" onclick="pdf()" id="print">Imprimer</button>
                        </div>

                        <div class="text-right d-block">
                            <img id="qrcode" src="https://chart.googleapis.com/chart?chs=<?= $QrCodeCvSize; ?>&cht=qr&chl=<?= $QrCodeCvlink; ?>&choe=UTF-8" />
                        </div>
                        
                        
                        
                    </div>


                    <div class="d-flex justify-content-between footer p-3 px-5">
                        <span>Besoin d'aide ? visitez notre <a href="#">centre d'aide</a></span>
                        <span><?= $Date; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function pdf() {
        window.print();
    }
  </script>
</body>
</html>