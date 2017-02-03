<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:19
 */
/*************** INSTANCIATION CONFIG ***********************/
require_once($strNiveau . 'inc/scripts/config.inc.php');

/*************** TWIG ***********************/
include_once($strNiveau .'inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($strNiveau . 'templates'); //Nom du dossier qui contient nos templates
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));