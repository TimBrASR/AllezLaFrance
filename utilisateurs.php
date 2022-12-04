<?php require 'config/init.conf.php'; ?>

<?php require 'config/check-connexion.conf.php'; ?>

<?php require_once 'config/init.conf.php'; ?>
<?php require_once 'vendor/autoload.php'; ?>

<?php
    if(!empty($_POST['submit'])){
        //print_r2($_POST);
        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($_POST);
        //print_r2($utilisateurs);
        //print_r2($_FILES);

        $utilisateurs->setMdp(password_hash($utilisateurs->getMdp(), PASSWORD_DEFAULT));

        //Insérer utilisateurs en BDD
        $utilisateursManager = new utilisateursManager ($bdd);
        $utilisateursManager->add($utilisateurs);
        //print_r2($utilisateursManager);

        $messageNotification = $utilisateursManager->get_result() == true ? "Votre utilisateur a été ajouté !" : "Une erreur est survenue";
        $resultNotification = $utilisateursManager->get_result() == true ? "success" : 'danger';

        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;

        header("Location: index.php");
        exit();
}



    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);

   
    echo $twig->render('utilisateurs.html.twig', [])


    ?>