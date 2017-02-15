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
 *  FICHE ÉTUDIANT
 */


/*************** 1. VARIABLES LOCALES ***********************/
<<<<<<< HEAD
$strNiveau="../../";
=======
$strNiveau = "../../";
>>>>>>> 3d8ed281c0758d5209ed5d89ec47dedd3da9e55f
$strTriInterets = "";
$intIdEtudiant = null;

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** 3. REÇOIT ID DE L'ÉTUDIANT ***********************/
<<<<<<< HEAD
if(isset($_GET['id'])){
=======
if (isset($_GET['id'])) {
>>>>>>> 3d8ed281c0758d5209ed5d89ec47dedd3da9e55f
    $intIdEtudiant = $_GET['id'];
} else {
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

/*************** 4. REQUÊTES FICHE DIPLÔMÉ ***********************/
//----- 4.1 Requete pour aller chercher tous les infos du diplômé -----//
<<<<<<< HEAD
$strSQLInfosEtudiant = "SELECT * FROM t_diplome WHERE id_diplome = " . $intIdEtudiant;
if ($objResultInfosEtudiant = $objConnMySQLi->query($strSQLInfosEtudiant)) {
    while ($objLigneInfosEtudiant = $objResultInfosEtudiant->fetch_object()) {
        $arrInfosEtudiant =
            array(
                'id'=>$objLigneInfosEtudiant->id_diplome,
                'prenom'=>$objLigneInfosEtudiant->prenom_diplome,
                'nom'=>$objLigneInfosEtudiant->nom_diplome,
                'slug'=>$objLigneInfosEtudiant->slug,
                'profil'=>$objLigneInfosEtudiant->profil,
                'forces'=>$objLigneInfosEtudiant->forces,
                'interet_gestion'=>$objLigneInfosEtudiant->interet_gestion_projet,
                'interet_design'=>$objLigneInfosEtudiant->interet_design_interface,
                'interet_traitement'=>$objLigneInfosEtudiant->interet_traitement_medias,
                'interet_integration'=>$objLigneInfosEtudiant->interet_integration,
                'interet_programmation'=>$objLigneInfosEtudiant->interet_programmation,
                'courriel'=>$objLigneInfosEtudiant->courriel_diplome,
                'twitter'=>$objLigneInfosEtudiant->pseudo_twitter_diplome,
                'linkedin'=>$objLigneInfosEtudiant->linkedin_diplome,
                'site_web'=>$objLigneInfosEtudiant->site_web_diplome,
                'nom_usager_admin'=>$objLigneInfosEtudiant->nom_usager_admin
            );
=======
try {
    $strSQLInfosEtudiant = "SELECT * FROM t_diplome WHERE id_diplome = " . $intIdEtudiant;

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
>>>>>>> 3d8ed281c0758d5209ed5d89ec47dedd3da9e55f
    }


    //En cas d'erreur de requête
    if ($objResultInfosEtudiant->num_rows == 0) {
        header('Location: ' . $strNiveau . 'erreur/index.php');
    }

    $objResultInfosEtudiant->free_result();

    //----- 4.2 Requete pour aller chercher tous les projets du diplômé -----//
    try {
        $strSQLProjetsEtudiant = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $intIdEtudiant;

        $objResultProjetsEtudiant = $objConnMySQLi->query($strSQLProjetsEtudiant);

<<<<<<< HEAD
$objResultInfosEtudiant->free_result();

//----- 4.2 Requete pour aller chercher tous les projets du diplômé -----//
$strSQLProjetsEtudiant = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $intIdEtudiant;
if ($objResultProjetsEtudiant = $objConnMySQLi->query($strSQLProjetsEtudiant)) {
    while ($objLigneProjetsEtudiant = $objResultProjetsEtudiant->fetch_object()) {
        $arrProjetsEtudiant[] =
            array(
                'id'=>$objLigneProjetsEtudiant->id_projet,
                'titre'=>$objLigneProjetsEtudiant->titre_projet,
                'slug'=>$objLigneProjetsEtudiant->slug
            );
=======
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
            header('Location: ' . $strNiveau . 'erreur/index.php');
        }

        $objResultProjetsEtudiant->free_result();


    } catch (Exception $e) {
        $texteErreurProjets = $e->getMessage();
>>>>>>> 3d8ed281c0758d5209ed5d89ec47dedd3da9e55f
    }

} catch (Exception $e) {
    $texteErreurFiche = $e->getMessage();
}

// fermer la connexion
$objConnMySQLi->close();

/*************** 5. TWIG ***********************/
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => $arrInfosEtudiant['prenom'] . " " . $arrInfosEtudiant['nom'] . " | Diplômés | ",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('diplomes/fiche_etudiant/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => $arrInfosEtudiant['prenom'] . " <span>" . $arrInfosEtudiant['nom'] . "</span>",
    'arrInfos' => $arrInfosEtudiant,
    'arrProjets' => $arrProjetsEtudiant,
    'texteErreurFiche' => $texteErreurFiche,
    'texteErreurProjets' => $texteErreurProjets
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());