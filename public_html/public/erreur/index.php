<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-01-25
 * Time: 08:48
 *
 *  PAGE ERREUR
 */


/*************** VARIABLES LOCALES ***********************/
$strNiveau="../";


/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Page inexistante | ",
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
));

$template = $twig->loadTemplate('erreur/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Page inexistante"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());