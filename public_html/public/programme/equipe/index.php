<?php
/**
 * Index de la page Équipe
 *
 * Tous les enseignants y sont affichés avec leurs réseaux sociaux.
 *
 * LICENSE: Cégep de Sainte-Foy - Techniques d'intégration multimédia
 *
 * @copyright Copyright (c) 2017 Cégep de Sainte-Foy
 * @version 1.0
 * @link timunix.cegep-ste-foy.qc.ca/~hooli/tim2017/public_html/public/programme/equipe
 * @author wcharest <williamcharestpepin@gmail.com>
 */

$strNiveau = "../../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

try {

//Requête permettant d'aller chercher tout le texte de la page Équipe

    $strSQLTextePageEquipe = "SELECT titre_texte, texte FROM t_texte WHERE section_et_page = 'Programme - Équipe'";

    $objResultTexte = $objConnMySQLi->query($strSQLTextePageEquipe);

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

//Requête permettant d'aller chercher toutes les informations sur les enseignants (nom, prénom, courriel, twitter, linkedin, site web)

    $strSQLProfs = "SELECT nom_prof, prenom_prof, courriel_prof, pseudo_twitter_prof, linkedin_prof, site_web_prof
FROM t_prof ORDER BY nom_prof";

    if ($objResultProfs = $objConnMySQLi->query($strSQLProfs)) {

        while ($objLigneProfs = $objResultProfs->fetch_object()) {

            $arrProfs[] =

                array(
                    'nom' => $objLigneProfs->nom_prof,
                    'prenom' => $objLigneProfs->prenom_prof,
                    'courriel' => $objLigneProfs->courriel_prof,
                    'pseudo' => $objLigneProfs->pseudo_twitter_prof,
                    'linkedin' => $objLigneProfs->linkedin_prof,
                    'site' => $objLigneProfs->site_web_prof
                );

        }
        $objResultProfs->free_result();
    }


    $template = $twig->loadTemplate('pieces/head.html.twig');
    echo $template->render(array(
        'title' => "Techniques d'intégration multimédia | TIM",
        'page' => "Équipe | ",
        'niveau' => $strNiveau
    ));

    $template = $twig->loadTemplate('pieces/header.html.twig');
    echo $template->render(array(
        'arrMenuLiensActifs' => $arrMenuActif
    ));

    $template = $twig->loadTemplate('programme/equipe/index.html.twig');
    echo $template->render(array(
        'arrTextes' => $arrTextes,
        'arrProfs' => $arrProfs,
        'niveau' => $strNiveau
    ));

    $template = $twig->loadTemplate('pieces/footer.html.twig');
    echo $template->render(array(
        'texte_auteurs' => $strTexteAuteurs
    ));

} catch (Exception $e) {

    echo $e->getMessage();

}

$objConnMySQLi->close();