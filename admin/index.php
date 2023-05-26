<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].'/assets/extensions/functions.php';
    session_start();

    //Si l'utilisateur n'est pas connecter envoyer à la page de connexion
    isConnect();

    //vérifier si l'utilisateur est admin
    isAdmin();

    //Vérifier si l'utilisateur est ban du site
    isBan();
    
    //Récupère l'identifiant de l'utilisateur
    $idUser = $_SESSION['idUser'];

    //Récupère les données de l'utilisateur
    $dataUser = dataUser($idUser);

    //Affichage des recettes
    $recetteDuMois = recupRecetteMois(date("m"), date('Y'));
    $recetteDuMoisDernier = recupRecetteMois(date("m", strtotime('-1 month')), date('Y'));
    
    if ($recetteDuMoisDernier != 0) {
        $pourcentageRecetteMois = round(($recetteDuMois - $recetteDuMoisDernier) / $recetteDuMoisDernier * 100, 0);
    } else {
        // Valeur par défaut si $recetteDuMoisDernier est égal à zéro
        $pourcentageRecetteMois = 0;
    }
    
    if ($pourcentageRecetteMois > 0) {
        $pourcentageRecetteMois = "+" . $pourcentageRecetteMois;
        $recetteColor = "success";
    } elseif ($pourcentageRecetteMois == 0) {
        $recetteColor = "muted";
        $pourcentageRecetteMois = "--";
    } else {
        $recetteColor = "danger";
    }
    

    //afficher nombre de ventes
    $venteDuMois = recupVenteMois(date("m"),date('Y'));
    $venteDuMoisDernier = recupVenteMois(date("m", strtotime('-1 month')),date('Y'));
    
    if ($venteDuMoisDernier != 0) {
      $pourcentageVenteMois = round(($venteDuMois-$venteDuMoisDernier)/$venteDuMoisDernier*100, 0);
    } else {
      $pourcentageVenteMois = 0;
    }

    if($pourcentageVenteMois > 0) {
      $pourcentageVenteMois = "+".$pourcentageVenteMois;
      $venteColor = "success";
    } elseif($pourcentageVenteMois == 0) {
      $venteColor = "muted";
      $pourcentageVenteMois = "-- ";
    } else {
      $venteColor = "danger";
    }

    //Récupère le nombre de visiteur du mois
    $visiteurDuMois = recupViewPage(date("m"),date('Y'));
    $visiteurDuMoisDernier = recupViewPage(date("m", strtotime('-1 month')),date('Y'));
    
    if ($visiteurDuMoisDernier != 0) {
      $pourcentageVisiteurMois = round(($visiteurDuMois-$visiteurDuMoisDernier)/$visiteurDuMoisDernier*100, 0);
    } else {
      $pourcentageVisiteurMois = 0;
    }
    
      if($pourcentageVisiteurMois > 0) {
      $pourcentageVisiteurMois = "+".$pourcentageVisiteurMois;
      $visiteurColor = "success";
    } elseif($pourcentageVisiteurMois == 0) {
      $visiteurColor = "muted";
      $pourcentageVisiteurMois = "-- ";
    } else {
      $visiteurColor = "danger";
    }

    //Récupère le nombre d'inscript du mois
    $inscriptionDuMois = recupInscriptionMois(date("m"),date('Y'));
    $inscriptionDuMoisDernier = recupInscriptionMois(date("m", strtotime('-1 month')),date('Y'));
    
    if ($inscriptionDuMoisDernier != 0) {
      $pourcentageInscriptionMois = round(($inscriptionDuMois-$inscriptionDuMoisDernier)/$inscriptionDuMoisDernier*100, 0);
    } else {
      $pourcentageInscriptionMois = 0;
    }
    
      if($pourcentageInscriptionMois > 0) {
      $pourcentageInscriptionMois = "+".$pourcentageInscriptionMois;
      $inscriptionColor = "success";
    } elseif($pourcentageInscriptionMois == 0) {
      $inscriptionColor = "muted";
      $pourcentageInscriptionMois = "-- ";
    } else {
      $inscriptionColor = "danger";
    }

    //Récupère le nombre total de fiche acheter
    $totalFicheAchete = recupAllFicheAchete();

    //récupère toute les factures
    $AllFActures = recupAllFactures();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/admin/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/admin/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/admin/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/admin/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/admin/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/admin/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/admin/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <?php include("partials/_sidebar.php"); ?>

      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <?php include("partials/_navbar.php"); ?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">

            <!-- Statistique -->
            <div class="row">

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Recette(s)</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= $recetteDuMois; ?> €</h2>
                          <p class="text-<?= $recetteColor; ?> ml-2 mb-0 font-weight-medium"><?= $pourcentageRecetteMois; ?>%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?= $recetteDuMoisDernier; ?> € Le mois dernier</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-2 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-bank text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Vente(s)</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= $venteDuMois; ?></h2>
                          <p class="text-<?= $venteColor; ?> ml-2 mb-0 font-weight-medium"><?= $pourcentageVenteMois; ?>%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?= $venteDuMoisDernier; ?> Le mois dernier</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-wallet-travel text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Visiteur(s)</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= $visiteurDuMois; ?></h2>
                          <p class="text-<?= $visiteurColor; ?> ml-2 mb-0 font-weight-medium"><?= $pourcentageVisiteurMois; ?>% </p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?= $visiteurDuMoisDernier; ?> Le mois dernier</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-eye text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Inscription(s)</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= $inscriptionDuMois; ?></h2>
                          <p class="text-<?= $inscriptionColor; ?> ml-2 mb-0 font-weight-medium"><?= $pourcentageInscriptionMois; ?>% </p>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?= $inscriptionDuMoisDernier; ?> Le mois dernier</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-account text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Fiche(s) débloquée(s)</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= $totalFicheAchete; ?></h2>
                          <p class="text-muted ml-2 mb-0 font-weight-medium">au total</p>
                        </div>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-file-document text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- GRAPHIQUE VENTE SUR L'ANNEE -->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Revenu de l'année</h4>
                    <canvas id="lineChart" style="height: 209px; display: block; width: 418px;" width="627" height="200" class="chartjs-render-monitor"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- DERNIERE VENTE -->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Dernière vente(s)</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Client</th>
                            <th>N° Facture</th>
                            <th>Date</th>
                            <th>Prix</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($AllFActures as $facture): ?>
                          <tr>
                            <td class="text-capitalize"><?= htmlspecialchars(openssl_decrypt($facture['Nom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])) ?> <?= htmlspecialchars(openssl_decrypt($facture['Prenom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])) ?></td>
                            <td><a href="/facture-<?= openssl_decrypt($facture['NumeroFacture'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']) ?>" target="_blank"><?= openssl_decrypt($facture['NumeroFacture'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']) ?></a></td>
                            <td><?= MyDate($facture['DateVente']) ?></td>
                            <td><?= str_replace(".", ",", $facture['Prix']); ?> €</td>
                            <td><label class="badge badge-success"><?= $facture['Status'] ?></label></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
            <?php include("partials/_footer.php"); ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/admin/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/admin/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/admin/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="/admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/admin/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/admin/assets/js/off-canvas.js"></script>
    <script src="/admin/assets/js/hoverable-collapse.js"></script>
    <script src="/admin/assets/js/misc.js"></script>
    <script src="/admin/assets/js/settings.js"></script>
    <script src="/admin/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/admin/assets/js/dashboard.js"></script>
    <script>
$(function() {
  /* ChartJS
   * -------
   * Data and config for chartjs
   */
  'use strict';
  var data = {
    labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
    datasets: [{
      label: '€',
      data: [
        <?= recupRecetteMois("01",date('Y')); ?>,
        <?= recupRecetteMois("02",date('Y')); ?>,
        <?= recupRecetteMois("03",date('Y')); ?>,
        <?= recupRecetteMois("04",date('Y')); ?>,
        <?= recupRecetteMois("05",date('Y')); ?>,
        <?= recupRecetteMois("06",date('Y')); ?>,
        <?= recupRecetteMois("07",date('Y')); ?>,
        <?= recupRecetteMois("08",date('Y')); ?>,
        <?= recupRecetteMois("09",date('Y')); ?>,
        <?= recupRecetteMois("10",date('Y')); ?>,
        <?= recupRecetteMois("11",date('Y')); ?>,
        <?= recupRecetteMois("12",date('Y')); ?>
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)',
        'rgba(255,99,132,1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };

  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        },
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }],
      xAxes: [{
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 1
      }
    }
  }

  // Get context with jQuery - using jQuery's .get() method.
  if ($("#lineChart").length) {
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: data,
      options: options
    });
  }
});
    </script>
    <!-- End custom js for this page -->
  </body>
</html>