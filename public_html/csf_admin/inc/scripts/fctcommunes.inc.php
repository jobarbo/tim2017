<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:19
 */
/*************** INSTANCIATION CONFIG ***********************/
require_once($strNiveauAdmin . 'inc/scripts/config.inc.php');

/*************** HEADER ET FOOTER ***********************/
require_once($strNiveau . 'inc/pieces/header.php');
require_once($strNiveau . 'inc/pieces/footer.php');

/*************** GÉRER LA DÉCONNEXION ***********************/

    if(isset($_GET['btnDeconnecter'])){

        header('Location: index.php');
        session_destroy();

    }

/*************** MESSAGES JSON ***********************/
$strDonneesJSON = file_get_contents($strNiveau . "js/messages.json");
$arrMsgErreurs = json_decode($strDonneesJSON, true);

/*************** TWIG ***********************/
include_once($strNiveauAdmin .'inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($strNiveau . 'templates'); //Nom du dossier qui contient nos templates
$flashesFonction = new Twig_SimpleFunction("showFlashes", function() {
    showFlashes();
});
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));
$twig->addFunction($flashesFonction);