<?php
/**
 * Index de la page Futur étudiant
 *
 * Cette page décrit en quelques parapgraphes le programme et ce qui attend les futurs étudiants.
 * Une section étudiant d'un jour permet de contacter Benoît Frigon, par l'intermédiaire de la page contactez-nous
 *
 * LICENSE: Cégep de Sainte-Foy - Techniques d'intégration multimédia
 *
 * @copyright Copyright (c) 2017 Cégep de Sainte-Foy
 * @version 1.0
 * @link timunix.cegep-ste-foy.qc.ca/~hooli/tim2017/public_html/public/futur_etudiant/
 * @author wcharest <williamcharestpepin@gmail.com>
 */

$strNiveau = "../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

try {

//Requête permettant d'aller chercher tout le texte de la page Futur Étudiant

    $strSQLTexteFormationVivante = "SELECT titre_texte, texte FROM t_texte WHERE id_texte = 1";
    $strSQLTextePrealables = "SELECT titre_texte, texte FROM t_texte WHERE id_texte = 33";
    $strSQLTexteProcessus = "SELECT titre_texte, texte FROM t_texte WHERE id_texte = 40";
    $strSQLTexteEtudiantUnJour = "SELECT titre_texte, texte FROM t_texte WHERE id_texte = 64";

    $objResultTexte1 = $objConnMySQLi->query($strSQLTexteFormationVivante);

    if($objResultTexte1 == false) {

        $strMessage = "Les textes n'ont pu être affichés, réessayez plus tard";
        $except = new Exception($strMessage);

        throw $except;

    }else{

        while ($objLigneTexte1 = $objResultTexte1->fetch_object()) {

            $arrTexteFormationVivante[] =

                array(
                    'titre' => $objLigneTexte1->titre_texte,
                    'paragraphe' => $objLigneTexte1->texte
                );

        }
        $objResultTexte1->free_result();
    }

    $objResultTexte2 = $objConnMySQLi->query($strSQLTextePrealables);

    if($objResultTexte2 == false) {

        $strMessage = "Les textes n'ont pu être affichés, réessayez plus tard";
        $except = new Exception($strMessage);

        throw $except;

    }else{

        while ($objLigneTexte2 = $objResultTexte2->fetch_object()) {

            $arrTextePrealables[] =

                array(
                    'titre' => $objLigneTexte2->titre_texte,
                    'paragraphe' => $objLigneTexte2->texte
                );

        }
        $objResultTexte2->free_result();
    }

    $objResultTexte3 = $objConnMySQLi->query($strSQLTexteProcessus);

    if($objResultTexte3 == false) {

        $strMessage = "Les textes n'ont pu être affichés, réessayez plus tard";
        $except = new Exception($strMessage);

        throw $except;

    }else{

        while ($objLigneTexte3 = $objResultTexte3->fetch_object()) {

            $arrTexteProcessus[] =

                array(
                    'titre' => $objLigneTexte3->titre_texte,
                    'paragraphe' => $objLigneTexte3->texte
                );

        }
        $objResultTexte3->free_result();
    }

    $objResultTexte4 = $objConnMySQLi->query($strSQLTexteEtudiantUnJour);

    if($objResultTexte4 == false) {

        $strMessage = "Les textes n'ont pu être affichés, réessayez plus tard";
        $except = new Exception($strMessage);

        throw $except;

    }else{

        while ($objLigneTexte4 = $objResultTexte4->fetch_object()) {

            $arrTexteEtudiantUnJour[] =

                array(
                    'titre' => $objLigneTexte4->titre_texte,
                    'paragraphe' => $objLigneTexte4->texte
                );

        }
        $objResultTexte4->free_result();
    }

    $template = $twig->loadTemplate('futur_etudiant/index.html.twig');
    echo $template->render(array(
        'niveau' => "../",
        'page' => "Futur étudiant ",
        'arrTexteFormationVivante' => $arrTexteFormationVivante,
        'arrTextePrealables' => $arrTextePrealables,
        'arrTexteProcessus' => $arrTexteProcessus,
        'arrTexteEtudiantUnJour' => $arrTexteEtudiantUnJour,
        //HEADER
        'arrMenuLiensActifs' => $arrMenuActif
    ));

}

catch (Exception $e) {

    echo $e->getMessage();

}


$objConnMySQLi->close();


