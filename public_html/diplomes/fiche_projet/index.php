<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
 * 1. VARIABLES LOCALES
 * 2. INSTANCIATION CONFIG ET TWIG
 * 3. REÇOIT ID DU PROJET
 * 4. REQUÊTES FICHE PROJET
 * 4.1 Requete pour aller chercher tous les infos du projet
 * 4.2 Requete pour aller chercher le nom de l'auteur du projet
 * 4.3 Requete pour aller chercher les autres projets du diplômé
 * 5. IMAGES DU PROJET
 * 6. TWIG
 *
 *  FICHE PROJET
 */


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../../";
$strSlugProjet = "";
$strSection = "Fiche projet";
$intIdEtudiant = null;

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** 3. REÇOIT ID DU PROJET ***********************/
if (isset($_GET['slug'])) {
    $strSlugProjet = $_GET['slug'];
    $intIdEtudiant = $_GET['idEtudiant'];
} else {
    header('Location: ' . $strNiveau . '404/');
}

/*************** 4. REQUÊTES FICHE PROJET ***********************/
//----- 4.1 Requete pour aller chercher tous les infos du projet -----//
$strSQLInfosProjet = "SELECT * FROM t_projet_diplome WHERE slug = '" . $strSlugProjet . "' AND id_diplome = " . $intIdEtudiant;
if ($objResultInfosProjet = $objConnMySQLi->query($strSQLInfosProjet)) {
    while ($objLigneInfosProjet = $objResultInfosProjet->fetch_object()) {
        $arrInfosProjet =
            array(
                'id' => $objLigneInfosProjet->id_projet,
                'titre' => $objLigneInfosProjet->titre_projet,
                'slug' => $objLigneInfosProjet->slug,
                'technologies' => $objLigneInfosProjet->technologies,
                'description' => $objLigneInfosProjet->description,
                'participation' => $objLigneInfosProjet->participation,
                'cadre' => $objLigneInfosProjet->cadre,
                'url' => $objLigneInfosProjet->url_projet,
                'expose_galerie' => $objLigneInfosProjet->est_expose_galerie,
                'id_diplome' => $objLigneInfosProjet->id_diplome
            );
    }
}

//En cas d'erreur de requête
if ($objResultInfosProjet->num_rows == 0) {
    header('Location: ' . $strNiveau . '404/');
}

$objResultInfosProjet->free_result();

//----- 4.2 Requete pour aller chercher le nom de l'auteur du projet -----//
$strSQLEtudiant = "SELECT prenom_diplome, nom_diplome, id_diplome, slug FROM t_diplome WHERE id_diplome = " . $arrInfosProjet['id_diplome'];
if ($objResultEtudiant = $objConnMySQLi->query($strSQLEtudiant)) {
    while ($objLigneEtudiant = $objResultEtudiant->fetch_object()) {
        $arrEtudiant =
            array(
                'nom' => $objLigneEtudiant->nom_diplome,
                'prenom' => $objLigneEtudiant->prenom_diplome,
                'slug' => $objLigneEtudiant->slug,
                'id' => $objLigneEtudiant->id_diplome
            );
    }
}


//En cas d'erreur de requête
if ($objResultEtudiant->num_rows == 0) {
    header('Location: ' . $strNiveau . '404/');
}

$objResultEtudiant->free_result();

//----- 4.3 Requete pour aller chercher les autres projets du diplômé -----//
$strSQLAutresProjets = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $arrInfosProjet['id_diplome'];
if ($objResultAutresProjets = $objConnMySQLi->query($strSQLAutresProjets)) {
    while ($objLigneAutresProjets = $objResultAutresProjets->fetch_object()) {
        if ($objLigneAutresProjets->id_projet != $arrInfosProjet['id']) {
            $arrAutresProjets[] =
                array(
                    'id' => $objLigneAutresProjets->id_projet,
                    'titre' => $objLigneAutresProjets->titre_projet,
                    'slug' => $objLigneAutresProjets->slug
                );
        }
    }
}

//En cas d'erreur de requête
if ($objResultAutresProjets->num_rows == 0) {
    header('Location: ' . $strNiveau . '404/');
}

$objResultAutresProjets->free_result();

// fermer la connexion
$objConnMySQLi->close();

/*************** 5. IMAGES DU PROJET ***********************/
$intNoImg = 1;

while (file_exists($strNiveau . '/dist/images/projets/prj' . $arrInfosProjet['id'] . '_0' . $intNoImg . '-small.jpg')) {
    $arrProjetImg[] = array(
        'src' => 'prj' . $arrInfosProjet['id'] . '_0' . $intNoImg,
        'alt' => 'Image numéro ' . $intNoImg . ' du projet ' . $arrInfosProjet['titre'],
        'no' => $intNoImg,
        'prev' => $intNoImg - 1,
        'next' => $intNoImg + 1);
    $intNoImg++;
}

$intNbImages = count($arrProjetImg);


/*************** 6. TWIG ***********************/

$template = $twig->loadTemplate('diplomes/fiche_projet/index.html.twig');
echo $template->render(array(
    //HEAD
    'page' => $arrInfosProjet['titre'] . " | Fiche projet | Diplômés ",
    'niveau' => $strNiveau,
    'section' => $strSection,
    //HEADER
    'arrMenuLiensActifs' => $arrMenuActif,
    //PAGE
    'title' => $arrInfosProjet['titre'],
    'arrInfos' => $arrInfosProjet,
    'arrInfosEtudiant' => $arrEtudiant,
    'arrAutresProjets' => $arrAutresProjets,
    'arrImagesPrj' => $arrProjetImg,
    'nombreImages' => $intNbImages,
    //SCRIPTS
    'fichier_script' => 'visionneuse.js',
    //Librairies
    'librairie' => "<script type='text/javascript' src='dist/slick/slick.min.js'></script>
<script type='text/javascript' src='dist/scripts/slider.js'></script>"
));