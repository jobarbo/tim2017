<?php

$strNiveau="";

require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');



///////////// EXEMPLE AVEC TWIG //////////////
$template = $twig->loadTemplate('pieces/header.html.twig');

$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'will' => "the dog",
    'title' => "Techniques d'intégration multimédia | TIM"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');

