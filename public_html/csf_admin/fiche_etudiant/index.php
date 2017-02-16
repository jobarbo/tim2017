<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
 * 1. VARIABLES LOCALES
 * 2. INSTANCIATION CONFIG ET TWIG
 * 3. REÇOIT ID DE L'ÉTUDIANT
 * 4. REQUÊTES FICHE DIPLÔMÉ
 * 4.1 Requete pour aller chercher tous les infos du diplômé
 * 4.2 Requete pour aller chercher tous les projets du diplômé
 * 5. TWIG
 *
 *  ADMIN - ÉDITER FICHE ÉTUDIANT
 */
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../../";
$strNiveauAdmin="../../../public/";
$strSection = "Éditer fiche étudiant";

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');
/*************** 3. REQUÊTES DIPLÔMÉS ***********************/
//----- 3.2 Requete pour aller chercher tous les diplômés -----//
try {
    $strSQLDiplomes = "SELECT prenom_diplome, nom_diplome, slug, id_diplome FROM t_diplome ORDER BY nom_diplome";

    $objResultDiplome = $objConnMySQLi->query($strSQLDiplomes);
    if ($objResultDiplome == false) {
        $strMsgErr = "<p>Les diplômés n'ont pu être affichés, réessayez plus tard</p>";
        $except = new Exception($strMsgErr);
        $arrDiplomes = false;
        throw $except;
    } else {
        while ($objLigneDiplome = $objResultDiplome->fetch_object()) {
            $arrDiplomes[] =
                array(
                    'prenom' => $objLigneDiplome->prenom_diplome,
                    'nom' => $objLigneDiplome->nom_diplome,
                    'id' => $objLigneDiplome->id_diplome
                );
        }
        $strMsgErrDiplomes = false;
    }
    //En cas d'erreur de requête
    if ($objResultDiplome->num_rows == 0) {
        header('Location: ' . $strNiveau . '404/index.php');
    }
    $objResultDiplome->free_result();
} catch (Exception $e) {
    $strMsgErrDiplomes = $e->getMessage();
}
// fermer la connexion
$objConnMySQLi->close();

/*************** 4 TWIG ***********************/
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Section administrative | TIM",
    'page' => "",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array());

$template = $twig->loadTemplate('diplomes/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin,
    'page' => "Section administrative",
    'diplomes' => $arrDiplomes,
    'erreurDiplomes' => $strMsgErrDiplomes
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());