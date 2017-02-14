<?php
$strNiveau = "../";
$section = "Nous joindre";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$stmt = $objConnMySQLi->prepare("SELECT * FROM t_texte WHERE t_texte.section_et_page = ?");
$stmt->bind_param("s", $section);
$stmt->execute();
$pages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


//Templates
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Les Stages en Techniques d'Intégration Multimédia",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('stages/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'pages' => $pages
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());