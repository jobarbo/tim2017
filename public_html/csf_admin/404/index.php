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
$strNiveauAdmin="../../public/";

/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

// fermer la connexion
$objConnMySQLi->close();

/*************** INSTANCIATION CONFIG ET TWIG ***********************/

$template = $twig->loadTemplate('404/index.html.twig');
echo $template->render(array(
    //HEAD
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Page inexistante | ",
    'niveau' => $strNiveau,
    //PAGE
    'page' => "Page inexistante",
    //SCRIPTS
    'fichier_script' => 'nicEdit.js'
));