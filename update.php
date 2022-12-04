<!-- pas réussi le bouton modifier, quand je modifie mon article, cela me donne un erreur au niveau de la base de donnée avec le "where id", un problème de synthaxe -->




<?php require 'config/init.conf.php'; ?>

<?php require 'config/check-connexion.conf.php'; ?>


<?php require_once 'config/init.conf.php'; ?>
<?php require_once 'vendor/autoload.php'; ?>

<?php ////Recup ID du formualaire
$arctl = NULL;
if (isset($_GET['id'])) {
    $articlesManager = new articlesManager($bdd);
    $articles = $articlesManager->get(htmlspecialchars($_GET['id']));
}
?>
<!-- Page content-->

<?php
    if(isset($_POST['update'])){
        //print_r2($_POST);
        $articles = new articles();
        $articles->hydrate($_POST);
        $articles->setDate(date('Y-m-d'));
        //print_r2($articles);
        //print_r2($_FILES);

        //Insérer article en BDD
        $articlesManager = new articlesManager ($bdd);
        $articlesManager->update($articles);
        //print_r2($articlesManager);

        //Si articles inséré, traiter l'image
        if($articlesManager->get_result()== true){
            if($_FILES['image']['error'] == 0){
                $nomImage = $articles->getId();
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/img/".$nomImage.".jpg");
            }
        }

        $messageNotification = $articlesManager->get_result() == true ? "Votre article a été modifié !" : "Une erreur est survenue";
        $resultNotification = $articlesManager->get_result() == true ? "success" : 'danger';

        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;

        header("Location: index.php");
        exit();
    
}

else {
    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    echo $twig->render('update.html.twig', ['articles' => $articles]);
  }
?>







