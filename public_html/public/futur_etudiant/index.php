<?php
/**
 * Index de la page Futur étudiant
 *
 * Cette page décrit en quelques parapgraphes le programme et ce qui attend les futurs étudiants.
 * Une section étudiant d'un jour permet de contacter Benoît Frigon, par l'intermédiaire de la page contactez-nous
 *
 * LICENSE: Cégep de Sainte-Foy - Techniques d'intégration multimédia
 *
 * @copyright Copyright (c) 2017 Cégep de Sainte-Foy
 * @version 1.0
 * @link timunix.cegep-ste-foy.qc.ca/~hooli/tim2017/public_html/public/futur_etudiant/
 * @author wcharest <williamcharestpepin@gmail.com>
 */

$strNiveau = "../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Futur Étudiant

$strSQLTextePageFuturEtudiant = "SELECT titre_texte, texte FROM t_texte WHERE section_et_page = 'Futur étudiant'";

if ($objResultTexte = $objConnMySQLi->query($strSQLTextePageFuturEtudiant)) {

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
    'page' => "Perspectives | ",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array());

$template = $twig->loadTemplate('futur_etudiant/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'arrTextes' => $arrTextes
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());

