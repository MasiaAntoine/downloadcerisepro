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

    //récupère tout les utilisateurs du site
    $users = recupAllUserForAdmin();
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
      <?php include($_SERVER['DOCUMENT_ROOT']."/admin/partials/_sidebar.php"); ?>

      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <?php include($_SERVER['DOCUMENT_ROOT']."/admin/partials/_navbar.php"); ?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="row">
              
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Membres</h4>
                    <p class="card-description"> Affiche des informations sur les membres.
                    </p>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Profil </th>
                            <th> Utilisateur </th>
                            <th> Inscription </th>
                            <th> Email </th>
                            <th> Dépenses </th>
                            <th> Compte </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($users as $user): ?>
                          <tr>
                            <td class="py-1">
                              <img src="/images/profil/<?= htmlspecialchars(openssl_decrypt($user['Avatar'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])); ?>.png" onerror="this.src='/images/profil/unknown.png'" alt="image">
                            </td>
                            <td class="text-capitalize"><?= htmlspecialchars(openssl_decrypt($user['Nom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])); ?> <?= htmlspecialchars(openssl_decrypt($user['Prenom'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey'])); ?></td>
                            <td><?= MyDate($user['DateInscription']); ?></td>
                            <td><?= openssl_decrypt($user['Mail'], $GLOBALS['codeEncryptionKey'], $GLOBALS['encryptionKey']); ?></td>
                            <td><?= str_replace(".", ",", round($user['Depense'],2)); ?> €</td>
                            <?php
                                if($user['Confirmation']) {
                                    $statut = "Valider";
                                    $colorBadge = "success";
                                } else {
                                    $statut = "En attente";
                                    $colorBadge = "danger";
                                }
                            ?>
                            <td>
                                <label <?php if(!$user['Confirmation']) {echo 'onclick="location.href = \'/assets/extensions/admin/validAccount.php?id='.$user['IdUser'].'\';"';} ?> class="badge badge-<?= $colorBadge ?>"><?= $statut ?></label>
                            </td>
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
            <?php include($_SERVER['DOCUMENT_ROOT']."/admin/partials/_footer.php"); ?>
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
    <!-- End custom js for this page -->
  </body>
</html>