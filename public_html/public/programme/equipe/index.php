<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:51
 */
$niveau = "../../";
include_once($niveau . 'inc/lib/Twig/Autoloader.php');
include_once($niveau . 'inc/scripts/config.inc.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($niveau . 'templates'); //Nom du dossier qui contient nos templates
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));

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
$template = $twig->loadTemplate('pieces/menu.html.twig');

///////////// EXEMPLE AVEC TWIG //////////////
$template = $twig->loadTemplate('pieces/header.html.twig');
>>>>>>> 3eaa7071bfe2081be0b5ba34dddfccc4e1f38888

$template = $twig->loadTemplate('programme/equipe/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'title' => "Techniques d'intégration multimédia | TIM",
    'arrProfs' => $arrProfs
));

$template = $twig->loadTemplate('pieces/footer.html.twig');

