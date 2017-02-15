<?php

$strNiveau="";
$section = "Accueil";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

///////////// EXEMPLE AVEC TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "",
    'niveau' => $strNiveau
    
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif,
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'will' => "the dog",
    'title' => "Techniques d'intégration multimédia | TIM"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau
));


