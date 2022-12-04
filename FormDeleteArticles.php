<?php 
?>

<?php require_once 'config/init.conf.php'; ?>
<?php require 'config/check-connexion.conf.php'; ?>

<?php require_once 'vendor/autoload.php'; ?>



<?php ////Recup ID du formualire
$arctl = NULL;
if (isset($_GET['id'])) {
    $articlesManager = new articlesManager($bdd);
    $articles = $articlesManager->get(htmlspecialchars($_GET['id']));
}


?>


<?php
if (isset($_GET["id"])) {
    $id_articles = $_GET["id"];
    $articlesManager = new articlesManager($bdd);
    $a = $articlesManager->get($id_articles);

    if ($a->getPublie() == 0) {
        $publie = "";
    } else {
        $publie = "checked";
    }
}


?>

<?php
if (isset($_POST['delete'])) {
    //print_r2($_POST);
    // print_r2($_FILES);
    // exit();
    $articles = new articles();
    $articles->hydrate($_POST);

    $articles->setDate(date('Y-m-d'));


    $publie = $articles->getPublie() === 'on' ? 1 : 0; // Condition . Si $publie = on, publie vaut 1 sinon il vaut 0.
    $articles->setPublie($publie);

    // Insertion ou mise à jour de l'article.
    $articlesManager = new articlesManager($bdd);
    $articlesManager->Deletearticles($articles);

    //var_dump($articlesfilmsManager)

    // Traitement de l'image


    if ($articlesManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre article est supprimer';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant la supression';
    }



    header("Location: index.php");//Retour a l'index 
    exit();
} else {
    $commentairesManager = new commentairesManager($bdd);
    $ListCommentaires = $commentairesManager->getListCommentaires2($id_articles);


    $utilisateurs = new utilisateurs;
    $utilisateursManager = new utilisateursManager($bdd);

    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
    echo $twig->render('FormDeleteArticles.html.twig', ['articles' => $articles, 'ListCommentaires' => $ListCommentaires]);



?>


    <?php
}

    ?>