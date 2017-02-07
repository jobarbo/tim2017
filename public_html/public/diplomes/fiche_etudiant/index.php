<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-01-25
 * Time: 08:48
 *
 *  FICHE DIPLÔMÉ
 */


/*************** VARIABLES LOCALES ***********************/
$strNiveau="../../";


/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

/*************** REQUÊTES FICHE DIPLÔMÉ ***********************/

//-----Requete pour aller chercher tous les infos du diplômé-----//
$strSQLDiplomes = "SELECT prenom_diplome, nom_diplome, slug FROM t_diplome ORDER BY nom_diplome";
if ($objResultDiplome = $objConnMySQLi->query($strSQLDiplomes)) {
    while ($objLigneDiplome = $objResultDiplome->fetch_object()) {
        $arrDiplomes[] =
            array(
                'prenom'=>$objLigneDiplome->prenom_diplome,
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

//-----Requete pour aller chercher le texte d'intro-----//
$strSQLTexte = "SELECT texte FROM t_texte WHERE section_et_page = 'Diplômés'";
if ($objResultTexte = $objConnMySQLi->query($strSQLTexte)) {
    while ($objLigneTexte = $objResultTexte->fetch_object()) {
        $texteIntro = $objLigneTexte->texte;
    }
}

//En cas d'erreur de requête
if($objResultTexte->num_rows == 0){
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

$objResultTexte->free_result();

// fermer la connexion
$objConnMySQLi->close();

///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Fiche étudiant | ",
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
));

$template = $twig->loadTemplate('diplomes/fiche_etudiant/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Fiche étudiant",
    'texteIntro' => $texteIntro
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());