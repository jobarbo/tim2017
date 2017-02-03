<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:51
 */
$niveau = "../../";
include_once($niveau . 'inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($niveau . 'templates'); //Nom du dossier qui contient nos templates
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));


///////////// EXEMPLE AVEC TWIG //////////////
$template = $twig->loadTemplate('pieces/header.html.twig');

$template = $twig->loadTemplate('programme/equipe/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'title' => "Techniques d'intégration multimédia | TIM"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');

