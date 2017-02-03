<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-01-25
 * Time: 08:48
 *
 *  DIPLÔMÉS 2017
 */


/*************** VARIABLES LOCALES ***********************/
$strNiveau="../";
$strTriInterets = "";


/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');




///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/menu.html.twig');

$template = $twig->loadTemplate('diplomes/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'will' => "the dog",
    'title' => "Techniques d'intégration multimédia | TIM"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');