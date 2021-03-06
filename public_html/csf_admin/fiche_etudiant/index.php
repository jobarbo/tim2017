<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
 * 1. VARIABLES LOCALES
 * 2. INSTANCIATION CONFIG ET TWIG
 * 3. REÇOIT MATRICULE DE L'ÉTUDIANT
 * 4. DÉFINITION CHEMIN ET FICHIER POUR TÉLÉVERSEMENT
 * 5. SOUMISSION DES MODIFICATIONS INFOS
 * 6. MESSAGE ERREUR UPDATE PHOTO
 * 7. REQUÊTE AFFICHER FICHE DIPLÔMÉ
 * 7.1 Requete pour aller chercher tous les infos du diplômé
 * 7.2 Requete pour aller chercher tous les projets du diplômé
 * 8. TWIG
 *
 *  ÉDITER FICHE ÉTUDIANT
 */

session_start();
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../";
$strNiveauAdmin = "../../";
$strNiveauCSS = "../";
$intMatriculeEtudiant = null;
$strSection = "Éditer fiche étudiant";
$strMessageErreurSauvegarde = false;
$strMessageErreurPhoto = false;
$boolErreurSauvegarde = false;
$boolErreurPhoto = false;

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

/*************** 3. REÇOIT MATRICULE DE L'ÉTUDIANT ***********************/
if (isset($_GET['id'])) {
    $intMatriculeEtudiant = $_GET['id'];
    if(isset($_SESSION['arrAuthentification'])){
    $arrAuthentification = unserialize($_SESSION['arrAuthentification']);
    if($arrAuthentification["nom_usager_admin"] != $intMatriculeEtudiant && $arrAuthentification["niveau_acces"] != 3){
        header('Location: index.php?id=' . $arrAuthentification["nom_usager_admin"]);
        var_dump($_SESSION['arrAuthentification']);
    }
}
}
else{
    header('Location: ' . $strNiveau . '404/');
}





/*************** 5. SOUMISSION DES MODIFICATIONS INFOS ***********************/
if (isset($_GET['submitInfosEtudiant'])) {
    try {
        $strSQLUpdateInfosEtudiant = "UPDATE t_diplome SET
                                      profil = '" . $_GET['profil'] . "', 
                                      forces = '" . $_GET['forces'] . "', 
                                      interet_gestion_projet = '" . $_GET['interet_gestion'] . "',
                                      interet_design_interface = '" . $_GET['interet_design'] . "',
                                      interet_traitement_medias = '" . $_GET['interet_traitement'] . "',
                                      interet_programmation = '" . $_GET['interet_programmation'] . "',
                                      interet_integration = '" . $_GET['interet_integration'] . "',
                                      courriel_diplome = '" . $_GET['courriel'] . "',
                                      pseudo_twitter_diplome = '" . $_GET['twitter'] . "',
                                      linkedin_diplome = '" . $_GET['linkedin'] . "',
                                      site_web_diplome = '" . $_GET['siteweb'] . "'
                                      WHERE nom_usager_admin = " . $intMatriculeEtudiant . " ";

        if($objConnMySQLi->query($strSQLUpdateInfosEtudiant) === TRUE){
            $strMessageErreurSauvegarde = $arrMsgErreurs["fiche_etudiant"]["sauvegarde"]["succes"];
            $boolErreurSauvegarde = false;
        }
        else{
            $strMsgErrUpdate= "<p>Les modifications n'ont pu être apportées, réessayez plus tard</p>";
            $except = new Exception($strMsgErrUpdate);

            throw $except;
        }

    } catch (Exception $e) {
        $strMessageErreurSauvegarde = $e->getMessage();
        $boolErreurSauvegarde = true;
    }
}else{
    $strMessageErreurSauvegarde = false;
}

/*************** 6. MESSAGE ERREUR UPDATE PHOTO ***********************/
if (isset($_GET['erreur'])) {
    $strMessageErreurPhoto = $arrMsgErreurs["fiche_etudiant"]["img"][$_GET['erreur']];
    $boolErreurPhoto = true;
}
elseif (isset($_GET['sauvegardePhoto'])) {
    $strMessageErreurPhoto = $arrMsgErreurs["fiche_etudiant"]["img"][$_GET['sauvegardePhoto']];
    $boolErreurPhoto = false;
}
else{
    $strMessageErreurPhoto = false;
}

/*************** 7. REQUÊTE AFFICHER FICHE DIPLÔMÉ ***********************/
//----- 7.1 Requete pour aller chercher tous les infos du diplômé -----//
try {
    $strSQLInfosEtudiant = "SELECT * FROM t_diplome WHERE nom_usager_admin = " . $intMatriculeEtudiant;

    $objResultInfosEtudiant = $objConnMySQLi->query($strSQLInfosEtudiant);

    if ($objResultInfosEtudiant == false) {
        $strMsgErrFiche = "<p>La fiche de l'étudiant n'a pu être affichée, réessayez plus tard</p>";
        $except = new Exception($strMsgErrFiche);

        $arrInfosEtudiant = false;

        throw $except;
    } else {
        while ($objLigneInfosEtudiant = $objResultInfosEtudiant->fetch_object()) {
            $arrInfosEtudiant =
                array(
                    'id' => $objLigneInfosEtudiant->id_diplome,
                    'prenom' => $objLigneInfosEtudiant->prenom_diplome,
                    'nom' => $objLigneInfosEtudiant->nom_diplome,
                    'slug' => $objLigneInfosEtudiant->slug,
                    'profil' => $objLigneInfosEtudiant->profil,
                    'forces' => $objLigneInfosEtudiant->forces,
                    'interet_gestion' => $objLigneInfosEtudiant->interet_gestion_projet,
                    'interet_design' => $objLigneInfosEtudiant->interet_design_interface,
                    'interet_traitement' => $objLigneInfosEtudiant->interet_traitement_medias,
                    'interet_integration' => $objLigneInfosEtudiant->interet_integration,
                    'interet_programmation' => $objLigneInfosEtudiant->interet_programmation,
                    'courriel' => $objLigneInfosEtudiant->courriel_diplome,
                    'twitter' => $objLigneInfosEtudiant->pseudo_twitter_diplome,
                    'linkedin' => $objLigneInfosEtudiant->linkedin_diplome,
                    'site_web' => $objLigneInfosEtudiant->site_web_diplome,
                    'nom_usager_admin' => $objLigneInfosEtudiant->nom_usager_admin
                );
        }

        $texteErreurFiche = false;
    }


    //En cas d'erreur de requête
    if ($objResultInfosEtudiant->num_rows == 0) {
        header('Location: ' . $strNiveau . '404/');
    }

    $objResultInfosEtudiant->free_result();

    //----- 7.2 Requete pour aller chercher tous les projets du diplômé -----//
    try {
        $strSQLProjetsEtudiant = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $arrInfosEtudiant['id'];

        $objResultProjetsEtudiant = $objConnMySQLi->query($strSQLProjetsEtudiant);

        if ($objResultProjetsEtudiant == false) {
            $strMsgErrProjets = "<p>Les projets de l'étudiant n'a pu être affichés, réessayez plus tard</p>";
            $except = new Exception($strMsgErrProjets);
            $arrProjetsEtudiant = false;

            throw $except;
        } else {
            while ($objLigneProjetsEtudiant = $objResultProjetsEtudiant->fetch_object()) {
                $arrProjetsEtudiant[] =
                    array(
                        'id' => $objLigneProjetsEtudiant->id_projet,
                        'titre' => $objLigneProjetsEtudiant->titre_projet,
                        'slug' => $objLigneProjetsEtudiant->slug
                    );
            }
            $texteErreurProjets = false;
        }

        //En cas d'erreur de requête
        if ($objResultProjetsEtudiant->num_rows == 0) {
            header('Location: ' . $strNiveau . '404/index.php');
        }

        $objResultProjetsEtudiant->free_result();


    } catch (Exception $e) {
        $texteErreurProjets = $e->getMessage();
    }

} catch (Exception $e) {
    $texteErreurFiche = $e->getMessage();
}

// fermer la connexion
$objConnMySQLi->close();

/*************** 8. TWIG ***********************/

$template = $twig->loadTemplate('fiche_etudiant/index.html.twig');
echo $template->render(array(
    //HEAD
    'section' => $strSection,
    'title' => "Section administrative | TIM",
    'page' => "Éditer la fiche du diplomé " . $arrInfosEtudiant['prenom'] . " " . $arrInfosEtudiant['nom'],
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin,
    'niveauCSS' => $strNiveauCSS,
    //PAGE
    'pageh1' => "Éditer la fiche du diplomé " . $arrInfosEtudiant['prenom'] . " <span>" . $arrInfosEtudiant['nom'] . "</span>",
    'arrInfos' => $arrInfosEtudiant,
    'arrProjets' => $arrProjetsEtudiant,
    'texteErreurFiche' => $texteErreurFiche,
    'texteErreurProjets' => $texteErreurProjets,
    'erreurSauvegarde' => $boolErreurSauvegarde,
    'texteErreurSauvegarde' => $strMessageErreurSauvegarde,
    'erreurPhoto' => $boolErreurPhoto,
    'texteErreurPhoto' => $strMessageErreurPhoto
));
