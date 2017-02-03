<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-01-25
 * Time: 08:48
 *
 *  DIPLÔMÉS 2017
 */


/*************** VARIABLES LOCALES ***********************/
$strNiveau="../";
$strTriInterets = "";


/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

/*************** REQUÊTES DIPLÔMÉS ***********************/

//-----Requete pour aller chercher les infos sur le livre-----//
$strSQLDiplomes = "SELECT nom_diplome, slug FROM t_diplome ORDER BY nom_diplome";
if ($objResultDiplome = $objConnMySQLi->query($strSQLDiplomes)) {
    while ($objLigneDiplome = $objResultDiplome->fetch_object()) {
        $arrDiplomes[] =
            array(
                'nom'=>$objLigneDiplome->nom_diplome,
                'slug'=>$objLigneDiplome->slug
            );
    }
}
//En cas d'erreur de requête
if($objResultDiplome->num_rows == 0){
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

$objResultDiplome->free_result();


///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => " | Nos diplômés 2017"
));
$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
));

$template = $twig->loadTemplate('diplomes/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'page' => "Nos diplômés 2017",
    'diplomes' => $arrDiplomes
));
print_r($arrDiplomes);

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());