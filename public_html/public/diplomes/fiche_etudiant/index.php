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
$strTriInterets = "";
$intIdEtudiant = null;

/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** REÇOIT ID DE L'ÉTUDIANT ***********************/
if(isset($_GET['id'])){
    $intIdEtudiant = $_GET['id'];
}
else{
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

/*************** REQUÊTES FICHE DIPLÔMÉ ***********************/
//-----Requete pour aller chercher tous les infos du diplômé-----//
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
    }
}


//En cas d'erreur de requête
if($objResultInfosEtudiant->num_rows == 0){
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

$objResultInfosEtudiant->free_result();

//-----Requete pour aller chercher tous les projets du diplômé-----//
$strSQLProjetsEtudiant = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $intIdEtudiant;
if ($objResultProjetsEtudiant = $objConnMySQLi->query($strSQLProjetsEtudiant)) {
    while ($objLigneProjetsEtudiant = $objResultProjetsEtudiant->fetch_object()) {
        $arrProjetsEtudiant[] =
            array(
                'id'=>$objLigneProjetsEtudiant->id_projet,
                'titre'=>$objLigneProjetsEtudiant->titre_projet,
                'slug'=>$objLigneProjetsEtudiant->slug
            );
    }
}

//En cas d'erreur de requête
if($objResultProjetsEtudiant->num_rows == 0){
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

$objResultProjetsEtudiant->free_result();

// fermer la connexion
$objConnMySQLi->close();

///////////// TWIG //////////////
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
    'arrProjets' => $arrProjetsEtudiant
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());