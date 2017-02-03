<?php

include_once('inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates'); //Nom du dossier qui contient nos templates
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));



///////////// EXEMPLE AVEC TWIG //////////////
$template = $twig->loadTemplate('pieces/menu.html.twig');

$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'will' => "the dog",
    'title' => "Techniques d'intégration multimédia | TIM"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');

