<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
 * 1. VARIABLES LOCALES
 * 2. INSTANCIATION CONFIG ET TWIG
 * 3. REQUÊTES DIPLÔMÉS
 * 3.1 Requete pour aller chercher tous les diplômés
 * 3.2 Requete pour aller chercher le texte d'intro
 * 4. TWIG
 *
 *  DIPLÔMÉS 2017
 */


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau="../";
$strTriInterets = "";

if(isset($_GET['tri_interets'])){
    $strTriInterets = 'interet_' . $_GET['tri_interets'];
}
echo $strTriInterets;


/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

/*************** 3. REQUÊTES DIPLÔMÉS ***********************/

//----- 3.1 Requete pour aller chercher tous les diplômés -----//
//----Requete par défaut, sans option de tri----//
if($strTriInterets == "") {
    $strSQLDiplomes = "SELECT prenom_diplome, nom_diplome, slug, id_diplome FROM t_diplome ORDER BY nom_diplome";
}else {
//----Requete selon option de tri sélectionné----//
    $strSQLDiplomes = "SELECT prenom_diplome, nom_diplome, slug, id_diplome FROM t_diplome ORDER BY " . $strTriInterets . " desc";
}

if ($objResultDiplome = $objConnMySQLi->query($strSQLDiplomes)) {
    while ($objLigneDiplome = $objResultDiplome->fetch_object()) {
        $arrDiplomes[] =
            array(
                'prenom'=>$objLigneDiplome->prenom_diplome,
                'nom'=>$objLigneDiplome->nom_diplome,
                'slug'=>$objLigneDiplome->slug,
                'id'=>$objLigneDiplome->id_diplome
            );
    }
}

//En cas d'erreur de requête
if($objResultDiplome->num_rows == 0){
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

$objResultDiplome->free_result();

//----- 3.2 Requete pour aller chercher le texte d'intro -----//
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

/*************** 4. TWIG ***********************/
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Nos diplômés 2017 | ",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('diplomes/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Nos diplômés 2017",
    'diplomes' => $arrDiplomes,
    'texteIntro' => $texteIntro
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());