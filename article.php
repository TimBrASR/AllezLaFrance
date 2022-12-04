<?php require 'config/init.conf.php'; ?>

<?php require 'config/check-connexion.conf.php'; ?>


<?php require_once 'config/init.conf.php'; ?>
<?php require_once 'vendor/autoload.php'; ?>



<!-- Page content-->



<?php if (!empty($_GET['id'])) {
    $articlesId = new articles($bdd);
    $articlesManagerId = new articlesManager($bdd);
    $getArticlesId = $articlesManagerId->get($_GET['id']);
    //print_r2($getArticlesId);
} else {
}
?>

<?php
    if(isset($_POST['submit'])){
        //print_r2($_POST);
        $articles = new articles();
        $articles->hydrate($_POST);
        $articles->setDate(date('Y-m-d'));
        //print_r2($articles);
        //print_r2($_FILES);

        //Insérer article en BDD
        $articlesManager = new articlesManager ($bdd);
        $articlesManager->add($articles);
        //print_r2($articlesManager);

        //Si articles inséré, traiter l'image
        if($articlesManager->get_result()== true){
            if($_FILES['image']['error'] == 0){
                $nomImage = $articlesManager->get_getLastInsertId();
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/img/".$nomImage.".jpg");
            }
        }

        $messageNotification = $articlesManager->get_result() == true ? "Votre article a été ajouté !" : "Une erreur est survenue";
        $resultNotification = $articlesManager->get_result() == true ? "success" : 'danger';

        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;

        header("Location: index.php");
        exit();
    
}

else {
    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    echo $twig->render('article.html.twig', []);
  }
?>







