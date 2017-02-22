<?php
$strNiveau = "../";
$section = "Stages";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$stmt = $objConnMySQLi->prepare("SELECT * FROM t_texte WHERE t_texte.section_et_page = ?");
$stmt->bind_param("s", $section);
$stmt->execute();
$pages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$template = $twig->loadTemplate('stages/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'pages' => $pages,
    'page' => "Les Stages en Techniques d'Intégration Multimédia",
    'arrMenuLiensActifs' => $arrMenuActif
));