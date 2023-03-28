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

    //Ajouter l'article depuis le formulaire
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['valid'])) {
            $error = false;
            // var_dump('');
            // var_dump($_POST);
            // var_dump($_FILES['img']);
    
            //Récupère les données dans des variables.
            $Titre = strtoupper(htmlspecialchars($_POST['Titre']));
            $Prix = htmlspecialchars($_POST['Prix']);
            $Cerise = htmlspecialchars($_POST['Cerise']);
            $CeriseBonus = htmlspecialchars($_POST['CeriseBonus']);
            $Available = htmlspecialchars($_POST['Available']);
            if($Available == "on") {
                $Available = 1;
            } elseif($Available == "off") {
                $Available = 0;
            } else {
              $Available = 0;
            }
            $ImageUrl = $_FILES['img']['tmp_name'][0];
            $ImageSize = $_FILES['img']['size'][0];
            $ImageError = $_FILES['img']['error'][0];
            $LinkImg = $_POST['LinkImg'];
    
            //Vérifier la limite du Titre
            if(!$error) {
                if(strlen($Titre) > 99) {
                    $error = true;
                    $message = "Le Titre est trop long.";
                }
            }
            //Vérifier le minimum du Titre
            if(!$error) {
                if(strlen($Titre) < 3) {
                    $error = true;
                    $message = "Le Titre est trop court.";
                }
            }
    
            //Vérifier le minimum du Prix
            if(!$error) {
                if($Prix <= 0) {
                    $error = true;
                    $message = "Le Prix doit être supérieur à 0 €.";
                }
            }
            //Vérifier le minimum du Prix
            if(!$error) {
                if($Prix >= 1000) {
                    $error = true;
                    $message = "Le Prix doit être inférieur à 1000 €.";
                }
            }
    
            //Vérifier le min de cerise
            if(!$error) {
                if($Cerise <= 0) {
                    $error = true;
                    $message = "Les Cerises doit être supérieur à 0.";
                }
            }
            //Vérifier le max de Cerise
            if(!$error) {
                if($Prix >= 1000000) {
                    $error = true;
                    $message = "Les Cerises doit être inférieur à 1 000 000.";
                }
            }
    
            //Vérifier le min de CeriseBonus
            if(!$error) {
                if($CeriseBonus < 0) {
                    $error = true;
                    $message = "Les Cerises Bonus ne doit pas être un chiffre négatif.";
                }
            }
            //Vérifier le max de CeriseBonus
            if(!$error) {
                if($CeriseBonus >= 1000000) {
                    $error = true;
                    $message = "Les Cerises Bonus doit être inférieur à 1 000 000.";
                }
            }
    
            //Vérifier la limite du LinkImg
            if(!$error) {
                if(strlen($LinkImg) > 99) {
                    $error = true;
                    $message = "Le LinkImg est trop long.";
                }
            }
            //Vérifier le minimum du LinkImg
            if(!$error) {
                if(strlen($LinkImg) < 3) {
                    $error = true;
                    $message = "Le LinkImg est trop court.";
                }
            }
    
            //Vérifier la taille de l'image (10 Mo max)
            if(!$error) {
                if($ImageSize > 10485760) {
                    $error = true;
                    $message = "L'image est trop grande (10 Mo, Max).";
                }
            }
    
            //Vérifier si l'image est envoyé
            if(!$error) {
                if($ImageError == 1) {
                    $error = true;
                    $message = "Il y a une erreur sur le chargement de la miniature.";
                }
            }
            
            //Vérifier si l'image a une erreur
            if(!$error) {
                if($ImageSize <= 0) {
                    $error = true;
                    $message = "Vous devez choisir une miniature.";
                }
            }
    
            //Si il y a une erreur la retourner
            if($error) {
                var_dump("");
                var_dump($message);
            }
    
            //retour réponse
            if(!$error) {
                //ajoute le type de véhicule en bdd.
                addArticle($Titre,$Prix,$Cerise,$CeriseBonus,$Available,$LinkImg);
    
                //Ajoute l'image
                move_uploaded_file($ImageUrl, $_SERVER['DOCUMENT_ROOT'].'/images/'.(string)$LinkImg.'.png');
    
                //redirection
                redirectUrl("/admin/pages/boutique/article.php");
    
                // var_dump('');
                // var_dump("réussi");
            }
        }

        if(isset($_POST['cancel'])) {
            //redirection
            redirectUrl("/admin/pages/boutique/article.php");
        }

    }
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

            <!-- Ajouter un article -->
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ajouter un article</h4>
                    <p class="card-description">Ce formulaire permet d'ajouter un article dans la boutique.</p>
                    <form method="post" enctype="multipart/form-data" class="forms-sample">
                      <div class="form-group">
                        <label for="Titre">Titre</label>
                        <input type="text" class="form-control" name="Titre" id="Titre" placeholder="Poignet de pièces cerises" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="Prix">Prix</label>
                        <p class="card-description">La virgule doit être remplacé par un point.</p>
                        <input type="number" step=0.01 class="form-control" name="Prix" id="Prix" placeholder="19.99">
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="Cerise">Cerises</label>
                            <p class="card-description">En général 1 euro est équivalant à 100 cerises.</p>
                            <input type="number" name="Cerise" id="Cerise" class="form-control" placeholder="2000">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="CeriseBonus">Bonus de cerises</label>
                            <p class="card-description">Si vous ne voulez pas ajouter de cerises bonus laissé 0.</p>
                            <input type="number"name="CeriseBonus" id="CeriseBonus" class="form-control" placeholder="200" value="0">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Miniature</label>
                                    <p class="card-description">Taille recommandé (2245x1587)</p>
                                <input type="file" name="img[]" accept="image/png, image/jpeg" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled="" placeholder="Image Télécharger">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Choisir</button>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="LinkImg">Nom de l'image</label>
                            <p class="card-description">Le nom choisi pour l'image.</p>
                            <input type="text" name="LinkImg" id="LinkImg" class="form-control" placeholder="cerise-poignet" autocomplete="off">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="Available">
                            <input type="checkbox" name="Available" id="Available" class="form-check-input" checked> Visible dans la Boutique <i class="input-helper"></i></label>
                        </div>
                      </div>
                      
                      <button type="submit" name="valid" class="btn btn-primary mr-2">Ajouter</button>
                      <button type="submit" name="cancel" class="btn btn-dark">Annuler</button>
                    </form>
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
    <script src="/admin/assets/js/file-upload.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>