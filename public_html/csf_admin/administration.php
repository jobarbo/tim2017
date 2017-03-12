<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
 * 1. VARIABLES LOCALES
 * 2. INSTANCIATION CONFIG ET TWIG
 * 3. REQUÊTES DIPLÔMÉS
 * 3.2 Requete pour aller chercher tous les diplômés
 * 4. TWIG
 *
 *  ADMIN - ACCUEIL
 */
 session_start();
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "";
$strNiveauAdmin="../";
$strNiveauCSS="../";
$strSection = "Éditer fiche étudiant";

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

/**************** 3.  VÉRIFICATION ET DROITS D'ACCÈS **********************/

if(isset($_SESSION['arrAuthentification'])){
    $arrAuthentification = unserialize($_SESSION['arrAuthentification']);
    if($arrAuthentification["niveau_acces"] == 1){
        header('Location: fiche_etudiant/index.php?id=' . $arrAuthentification["nom_usager_admin"]);
    }
}

/*************** 4. REQUÊTES ÉVÉNEMENTS ***********************/
//----- 4.1 Requete pour aller chercher tous les événements -----//
try {
    $strSQLEvenements = "SELECT id_actualite, titre_actualite, description_actualite, date_publication, date_expiration FROM t_evenement";

    $objResultEvenement= $objConnMySQLi->query($strSQLEvenements);
    if ($objResultEvenement == false) {
        $strMsgErr = "<p>Les événements n'ont pu être affichés, réessayez plus tard</p>";
        $except = new Exception($strMsgErr);
        $arrEvenements = false;
        throw $except;
    } else {
        while ($objLigneEvenement = $objResultEvenement->fetch_object()) {
            $arrEvenements[] =
                array(
                    'id_actualite' => $objLigneEvenement->id_actualite,
                    'titre_actualite' => $objLigneEvenement->titre_actualite,
                    'description_actualite' => $objLigneEvenement->description_actualite,
                    'date_publication' => $objLigneEvenement->date_publication,
                    'date_expiration' => $objLigneEvenement->date_expiration
                );
        }
        $strMsgErrEvenement = false;
    }
    //En cas d'erreur de requête
    if ($objResultEvenement->num_rows == 0) {
        $arrEvenements = null;
    }
    $objResultEvenement->free_result();
} catch (Exception $e) {
    $strMsgErrEvenement = $e->getMessage();
}

/*************** 5. REQUÊTES DIPLÔMÉS ***********************/
//----- 5.1 Requete pour aller chercher tous les diplômés -----//
try {
    $strSQLDiplomes = "SELECT prenom_diplome, nom_diplome, slug, nom_usager_admin FROM t_diplome ORDER BY nom_diplome";

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
                    'matricule' => $objLigneDiplome->nom_usager_admin
                );
        }
        $strMsgErrDiplomes = false;
    }
    //En cas d'erreur de requête
    if ($objResultDiplome->num_rows == 0) {
        header('Location: ' . $strNiveau . '404/');
    }
    $objResultDiplome->free_result();
} catch (Exception $e) {
    $strMsgErrDiplomes = $e->getMessage();
}

/* SUPPRESION DES ACTUALITES */

if(isset($_POST['btnSupprimer'])){

        try{
            $SQLDeleteActualite = "DELETE FROM t_evenement WHERE id_actualite=". $_POST['btnSupprimer'];

            if($objConnMySQLi->query($SQLDeleteActualite) === TRUE){
                $texteErreurUpdate = "";
                header("Location: administration.php");
            }
            else{
                $strMsgErrUpdate= "<p>La suppression n'a pu être éffectué, réessayez plus tard</p>";
                $except = new Exception($strMsgErrUpdate);

                throw $except;
            }
        }
        catch (Exception $e) {
            $texteErreurUpdate = $e->getMessage();
        }

}
// fermer la connexion
$objConnMySQLi->close();

$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Section administrative",
    'title' => "Admin | TIM",
    'niveau' => $strNiveau,
    'niveauCSS' => $strNiveauCSS,
    'page' => "Administration",
    'diplomes' => $arrDiplomes,
    'evenements' => $arrEvenements,
    'erreurDiplomes' => $strMsgErrDiplomes,
    'erreurEvenements' => $strMsgErrEvenement
));
