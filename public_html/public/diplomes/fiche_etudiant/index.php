<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
 * 1. VARIABLES LOCALES
 * 2. INSTANCIATION CONFIG ET TWIG
 * 3. REÇOIT ID DE L'ÉTUDIANT
 * 4. REÇOIT LE TRI PAR INTÉRÊTS
 * 5. REQUÊTES FICHE DIPLÔMÉ
 * 5.1 Requete pour aller chercher tous les infos du diplômé
 * 5.2 Requete pour aller chercher tous les projets du diplômé
 * 6. TWIG
 *
 *  FICHE ÉTUDIANT
 */


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../../";
$strTriInterets = "";
$strSlugEtudiant = "";
$strSection = "Fiche étudiant";

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** 3. REÇOIT ID DE L'ÉTUDIANT ***********************/
if (isset($_GET['slug'])) {
    $strSlugEtudiant = $_GET['slug'];
} else {
    header('Location: ' . $strNiveau . '404/index.php');
}

/*************** 4. REÇOIT LE TRI PAR INTÉRÊTS ***********************/
if (isset($_GET['tri_interets'])) {
    $strTriInterets = $_GET['tri_interets'];
}

/*************** 5. REQUÊTES FICHE DIPLÔMÉ ***********************/
//----- 5.1 Requete pour aller chercher tous les infos du diplômé -----//
try {
    $strSQLInfosEtudiant = "SELECT * FROM t_diplome WHERE slug = '" . $strSlugEtudiant . "'";

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
        header('Location: ' . $strNiveau . '404/index.php');
    }

    $objResultInfosEtudiant->free_result();

    //----- 5.2 Requete pour aller chercher tous les projets du diplômé -----//
    try {
        $strSQLProjetsEtudiant = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $arrInfosEtudiant['id'];

        $objResultProjetsEtudiant = $objConnMySQLi->query($strSQLProjetsEtudiant);

        if ($objResultProjetsEtudiant == false) {
            $strMsgErrProjets = "<p>Les projets de l'étudiant n'a pu être affichés, réessayez plus tard</p>";
            $except = new Exception($strMsgErrProjets);
            $arrProjetsEtudiant = false;

            throw $except;
        }
        else{
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

/*************** 6. TWIG ***********************/

$template = $twig->loadTemplate('diplomes/fiche_etudiant/index.html.twig');
echo $template->render(array(
    //HEAD
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => $arrInfosEtudiant['prenom'] . " " . $arrInfosEtudiant['nom'] . " | Diplômés | ",
    'niveau' => $strNiveau,
    //HEADER
    'arrMenuLiensActifs' => $arrMenuActif,
    //PAGE
    'niveau' => $strNiveau,
    'page' => $arrInfosEtudiant['prenom'] . " <span>" . $arrInfosEtudiant['nom'] . "</span>",
    'arrInfos' => $arrInfosEtudiant,
    'arrProjets' => $arrProjetsEtudiant,
    'texteErreurFiche' => $texteErreurFiche,
    'texteErreurProjets' => $texteErreurProjets,
    'tri_interets' => $strTriInterets,
    //SCRIPT
    'fichier_script' => 'skillbar.js'
));