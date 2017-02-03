<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:51
 */
$strNiveau = "../../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


$strSQLTextePageEquipe = "SELECT titre_texte, texte FROM t_texte WHERE section_et_page = 'Programme - Équipe'";

if ($objResultTexte = $objConnMySQLi->query($strSQLTextePageEquipe)) {

    while ($objLigneTexte = $objResultTexte->fetch_object()) {

        $arrTextes[]=

            array(
                'titre'=>$objLigneTexte->titre_texte,
                'paragraphe'=>$objLigneTexte->texte
            );

    }
    $objResultTexte->free_result();
}

$strSQLProfs = "SELECT nom_prof, prenom_prof, courriel_prof, pseudo_twitter_prof, linkedin_prof, site_web_prof
FROM t_prof";

if ($objResultProfs = $objConnMySQLi->query($strSQLProfs)) {

    while ($objLigneProfs = $objResultProfs->fetch_object()) {

        $arrProfs[]=

                array(
                    'nom'=>$objLigneProfs->nom_prof,
                    'prenom'=>$objLigneProfs->prenom_prof,
                    'courriel'=>$objLigneProfs->courriel_prof,
                    'pseudo'=>$objLigneProfs->pseudo_twitter_prof,
                    'linkedin'=>$objLigneProfs->linkedin_prof,
                    'site'=>$objLigneProfs->site_web_prof
                );

    }
    $objResultProfs->free_result();
}
$objConnMySQLi->close();


$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Équipe | "
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array());

$template = $twig->loadTemplate('programme/equipe/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'arrTextes' => $arrTextes,
    'arrProfs' => $arrProfs
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());

