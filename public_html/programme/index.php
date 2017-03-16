<?php
/**
 * Index de la page Programmation
 *
 * Des statistiques relatives au taux de placement et aux salaires y sont affichées ainsi q'une liste des programmes
 * universitaires pouvant suivre après les technique
 *
 * LICENSE: Cégep de Sainte-Foy - Techniques d'intégration multimédia
 *
 * @copyright Copyright (c) 2017 Cégep de Sainte-Foy
 * @version 1.0
 * @link timunix.cegep-ste-foy.qc.ca/~hooli/tim2017/public_html/public/futur_etudiant/perspectives
 * @author wcharest <williamcharestpepin@gmail.com>
 */

$strNiveau = "../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');
try {

//Requête permettant d'aller chercher tout le texte de la page Programme

    $strSQLTextePageProgramme = "SELECT titre_texte, texte FROM t_texte WHERE id_texte = 91";

    $objResultTexte = $objConnMySQLi->query($strSQLTextePageProgramme);

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

    $template = $twig->loadTemplate('programme/index.html.twig');
    echo $template->render(array(
        'niveau' => "../",
        'page' => "Programme ",
        'arrTextes' => $arrTextes,
        //HEADER
        'arrMenuLiensActifs' => $arrMenuActif
    ));

} catch (Exception $e) {

    echo $e->getMessage();

}

$objConnMySQLi->close();