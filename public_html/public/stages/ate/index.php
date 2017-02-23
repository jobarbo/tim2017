<?php
$strNiveau = "../../";
$section = "Stages - Alternance travail-études";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$stmt = $objConnMySQLi->prepare("SELECT * FROM t_texte WHERE t_texte.section_et_page = ?");
$stmt->bind_param("s", $section);
$stmt->execute();
$pages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];


$template = $twig->loadTemplate('stages/ate/index.html.twig');
echo $template->render(array(
    'pages' => $pages,
    'page' => "Alternance Travail-Etudes",
    'niveau' => $strNiveau,
    'arrMenuLiensActifs' => $arrMenuActif
));