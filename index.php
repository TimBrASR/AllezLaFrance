<!-- Tout est ok sauf la pagination que n'est pas réussi à convertir en twig -->


<?php require 'config/init.conf.php'; ?>

<?php require 'config/check-connexion.conf.php'; ?>

<?php require_once './vendor/autoload.php'; ?>

<?php $loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug'=>true]); ?>
    
    <?php
    
    $articlesManager = new articlesManager ($bdd);

    $listeArticles = $articlesManager->getList() ;

    //print_r2($articles);//afficher le tableau récupéré dans ArticlesManager

    $page = !empty($_GET['page']) ? $_GET['page'] : 1;

    $articlesManager = new articlesManager($bdd);
    $nbArticlesTotalAPublie = $articlesManager->countArticles();

    $nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);

    $indexDepart = ($page - 1) * nb_articles_par_page;

    $listeArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);

    //print_r2($listeArticles);
    //var_dump($bdd);

    echo $twig->render('index.html.twig',
            ['session' => $_SESSION,
            'listeArticles' => $listeArticles]);
            unset($_SESSION['notification']);
    ?>

<?php 
    if(isset($_SESSION['notification'])) 
?>



<div class="row">
        <?php 
        foreach ($listeArticles as $articles)
            ?>

<nav aria-label="Page de navigation mt-5">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $nbPages; $i++ ): ?>
            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                <a Class="page-link" href="?page=<?= $i; ?>"> <?= $i; ?> </a>
           </li>
           <?php endfor; ?>
        </ul>
    </nav>












