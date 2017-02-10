<?php
/**
 * Index de la page Perspectives
 *
 * Toutes les technologies survolées pendant le programme y sont affichées, ainsi qu'une description de celles-ci
 *
 * LICENSE: Cégep de Sainte-Foy - Techniques d'intégration multimédia
 *
 * @copyright Copyright (c) 2017 Cégep de Sainte-Foy
 * @version 1.0
 * @link timunix.cegep-ste-foy.qc.ca/~hooli/tim2017/public_html/public/futur_etudiant/perspectives/
 * @author wcharest <williamcharestpepin@gmail.com>
 */
$strNiveau = "../../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

try {

//Requête permettant d'aller chercher tout le texte de la page Perspectives

    $strSQLTextePagePerspectives = "SELECT titre_texte, texte FROM t_texte WHERE section_et_page = 'Futur étudiant - Perspectives'";

    $objResultTexte = $objConnMySQLi->query($strSQLTextePagePerspectives);

    if ($objResultTexte == false) {

        $strMessage = "Les textes n'ont pu être affichés, réessayez plus tard";
        $except = new Exception($strMessage);

        throw $except;

    } else {
        while ($objLigneTexte = $objResultTexte->fetch_object()) {

            $arrTextes[] =

                array(
                    'titre' => $objLigneTexte->titre_texte,
                    'paragraphe' => $objLigneTexte->texte
                );

        }
        $objResultTexte->free_result();
    }

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
} catch (Exception $e) {

    echo $e->getMessage();

}

$objConnMySQLi->close();