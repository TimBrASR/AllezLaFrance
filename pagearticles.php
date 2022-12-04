<?php 
?>
<?php require 'config/check-connexion.conf.php'; ?>
<?php require_once 'vendor/autoload.php'; ?>
<?php require_once 'config/init.conf.php'; ?>


<?php //Recup ID du commentaire et de l'article id
$articles = NULL;
$comment = NULL;

if (isset($_GET['id'])) {
    $articlesManager = new articlesManager($bdd);
    $commentairesManager = new commentairesManager($bdd);

    $utilisateurs = new utilisateurs;
    $utilisateursManager = new utilisateursManager($bdd);

    

    $articles = $articlesManager->get(htmlspecialchars($_GET['id']));
    $comment = $commentairesManager->getCommentairesById(htmlspecialchars($_GET['id']));
    $id_articles = $_GET["id"];
}

?>

<?php
if (isset($_POST['AddComment'])) {
    //print_r2($_POST);
    // print_r2($_FILES);
    // exit();
    $commentaires = new commentaires();
    $commentaires->hydrate($_POST);

    // Insertion ou mise à jour de l'article.
    $commentairesManager = new commentairesManager($bdd);
    $commentairesManager->addCommentaires($commentaires);

    //var_dump($articlesManager)
    // Traitement de l'image

    if ($commentairesManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre commentaire est ajouté';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = "une erreur est survenue pendant l'ajout du commentaire";
    }



    header("Location: index.php"); //Retour a l'index
    exit();
} else {


    $commentairesManager = new commentairesManager($bdd);
    $ListCommentaires = $commentairesManager->getListCommentaires2($id_articles);


    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    //  echo $twig->render('FormUtilisateurs.php', ['the' => 'variables', 'go' => 'here']);
    echo $twig->render('pagearticles.html.twig', ['articles' => $articles, 'ListCommentaires' => $ListCommentaires]);
}
?>

<?php

?>