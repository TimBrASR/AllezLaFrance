<?php

$isconnectsid = false;

if (isset($_COOKIE['sid'])){
    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getBySid($_COOKIE['sid']);
    $isconnectsid = true;
}

//var_dump($isconnectsid);
//var_dump($utilisateursEnBdd);

?>




