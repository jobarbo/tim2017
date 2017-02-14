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
 * 5. TWIG
 *
 *  FICHE PROJET
 */


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../../";
$intIdProjet = null;
$intIdEtudiant = null;

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** 3. REÇOIT ID DU PROJET ***********************/
if (isset($_GET['id'])) {
    $intIdProjet = $_GET['id'];
} else {
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

/*************** 4. REQUÊTES FICHE PROJET ***********************/
//----- 4.1 Requete pour aller chercher tous les infos du projet -----//
try {
    $strSQLInfosProjet = "SELECT * FROM t_projet_diplome WHERE id_projet = " . $intIdProjet;

    $objResultInfosProjet = $objConnMySQLi->query($strSQLInfosProjet);

    if ($objResultInfosProjet == false) {
        $strMsgErr = "<p>Les informations du projet n'ont pu être affichés, réessayez plus tard</p>";
        $except = new Exception($strMsgErr);
        $arrInfosProjet = false;

        throw $except;
    } else {
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

            $intIdEtudiant = $objLigneInfosProjet->id_diplome;
        }
        $strMsgErrInfos = false;
    }

    //En cas d'erreur de requête
    if ($objResultInfosProjet->num_rows == 0) {
        header('Location: ' . $strNiveau . 'erreur/index.php');
    }

    $objResultInfosProjet->free_result();

    //----- 4.2 Requete pour aller chercher le nom de l'auteur du projet -----//
    try {
        $strSQLEtudiant = "SELECT prenom_diplome, nom_diplome, id_diplome, slug FROM t_diplome WHERE id_diplome = " . $intIdEtudiant;

        $objResultEtudiant = $objConnMySQLi->query($strSQLEtudiant);

        if ($objResultEtudiant == false) {
            $strMsgErr = "<p>L'auteur du projet n'a pu être affiché, réessayez plus tard</p>";
            $except = new Exception($strMsgErr);
            $arrEtudiant = false;

            throw $except;
        }else{
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
            header('Location: ' . $strNiveau . 'erreur/index.php');
        }

        $objResultEtudiant->free_result();

        //----- 4.3 Requete pour aller chercher les autres projets du diplômé -----//
        try {
            $strSQLAutresProjets = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $intIdEtudiant;

            $objResultAutresProjets = $objConnMySQLi->query($strSQLAutresProjets);

            if ($objResultAutresProjets == false) {
                $strMsgErr = "<p>Les autres projets n'ont pu être affichés, réessayez plus tard</p>";
                $except = new Exception($strMsgErr);
                $arrAutresProjets = false;

                throw $except;
            }
            else {
                while ($objLigneAutresProjets = $objResultAutresProjets->fetch_object()) {
                    if ($objLigneAutresProjets->id_projet != $intIdProjet) {
                        $arrAutresProjets[] =
                            array(
                                'id' => $objLigneAutresProjets->id_projet,
                                'titre' => $objLigneAutresProjets->titre_projet,
                                'slug' => $objLigneAutresProjets->slug
                            );
                    }
                }
                $strMsgErrProjets = false;
            }

            //En cas d'erreur de requête
            if ($objResultAutresProjets->num_rows == 0) {
                header('Location: ' . $strNiveau . 'erreur/index.php');
            }

            $objResultAutresProjets->free_result();

        } catch (Exception $e) {
            $strMsgErrProjets = $e->getMessage();
        }

    } catch (Exception $e) {
        $strMsgErrAuteur = $e->getMessage();
    }

} catch (Exception $e) {
    $strMsgErrInfos = $e->getMessage();
}


// fermer la connexion
$objConnMySQLi->close();

/*************** 5. TWIG ***********************/
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => $arrInfosProjet['titre'] . " | Fiche projet | Diplômés | ",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('diplomes/fiche_projet/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => $arrInfosProjet['titre'],
    'arrInfos' => $arrInfosProjet,
    'arrInfosEtudiant' => $arrEtudiant,
    'arrAutresProjets' => $arrAutresProjets,
    'texteErrInfos' => $strMsgErrProjets,
    'texteErrAuteur' => $strMsgErrAuteur,
    'texteErrProjets' => $strMsgErrProjets
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());