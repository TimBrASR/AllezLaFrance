<?php require 'config/init.conf.php'; ?>

<?php require 'config/check-connexion.conf.php'; ?>

<?php require_once 'vendor/autoload.php'; ?>

<?php
$articles = new articles(); 
$articlesManager = new articlesManager($bdd);
        $listeArticles = $articlesManager->getList();
?>

    <?php
        if (!empty($_GET['search'])) {


            $articlesManager = new articlesManager($bdd);

            $listeArticles = $articlesManager->getListArticlesFromRecherche($_GET['search']);

            //print_r2($listeArticles);
            //var_dump($bdd);
        } else {
            $listeArticles = [];
        }
        ?>



<?php
    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

    echo $twig->render('recherche.html.twig', ['articles' => $articles, 'listeArticles' => $listeArticles])

?>








