<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:51
 */
$strNiveau = "../../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


$strSQLTextePagePerspectives = "SELECT titre_texte, texte FROM t_texte WHERE section_et_page = 'Futur étudiant - Perspectives'";

if ($objResultTexte = $objConnMySQLi->query($strSQLTextePagePerspectives)) {

    while ($objLigneTexte = $objResultTexte->fetch_object()) {

        $arrTextes[]=

            array(
                'titre'=>$objLigneTexte->titre_texte,
                'paragraphe'=>$objLigneTexte->texte
            );

    }
    $objResultTexte->free_result();
}

$objConnMySQLi->close();


$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Futur étudiant | ",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('futur_etudiant/perspectives/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'arrTextes' => $arrTextes
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());

