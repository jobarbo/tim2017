<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-01-25
 * Time: 08:48
 *
 *  DIPLÔMÉS 2017
 */


/*************** VARIABLES LOCALES ***********************/
$strNiveau="../../../";


/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** REQUÊTES DATABASE + CODE ***********************/

$arrCour = array();
$strSQLCours = "SELECT * FROM t_cours WHERE id_cours = " . $_GET['id'];

if ($objResultCours = $objConnMySQLi->query($strSQLCours)) {

    while ($objLigneCours = $objResultCours->fetch_object()) {

        $arrCour = array(
            'id'=>$objLigneCours->id_cours,
            'slug'=>$objLigneCours->slug,
            'no'=>$objLigneCours->no_cours,
            'nom'=>$objLigneCours->nom_cours,
            'url'=>$objLigneCours->url_cours,
            'duree'=>$objLigneCours->duree,
            'ponderation'=>$objLigneCours->ponderation,
            'dscr'=>$objLigneCours->description_cours,
            'specifique'=>$objLigneCours->est_specifique,
            'session'=>$objLigneCours->session,
        );
    }
    $objResultCours->free_result();
}

$sessionLies = "";
$boucleTwig1 = 0;
$boucleTwig2 = 0;
switch ($arrCour['session'])
{
    case 1:
    case 2:
        $sessionLies = " WHERE session = " . 1 . " OR session = " . 2;
        $boucleTwig1 = 1;
        $boucleTwig2 = 2;
        break;
    case 3:
    case 4:
        $sessionLies = " WHERE session = " . 3 . " OR session = " . 4;
        $boucleTwig1 = 3;
        $boucleTwig2 = 4;
        break;
    case 5:
    case 6:
        $sessionLies = " WHERE session = " . 5 . " OR session = " . 6;
        $boucleTwig1 = 5;
        $boucleTwig2 = 6;
        break;
}

$arrCours = array();
$strSQLGrilleCours = "SELECT * FROM t_cours" . $sessionLies;

if ($objResultCours = $objConnMySQLi->query($strSQLGrilleCours)) {

    while ($objLigneCours = $objResultCours->fetch_object()) {

        $arrCours[]= array(
            'id'=>$objLigneCours->id_cours,
            'slug'=>$objLigneCours->slug,
            'no'=>$objLigneCours->no_cours,
            'nom'=>$objLigneCours->nom_cours,
            'url'=>$objLigneCours->url_cours,
            'duree'=>$objLigneCours->duree,
            'ponderation'=>$objLigneCours->ponderation,
            'dscr'=>$objLigneCours->description_cours,
            'specifique'=>$objLigneCours->est_specifique,
            'session'=>$objLigneCours->session,
        );
    }
    $objResultCours->free_result();
}


///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => $arrCour['nom'] . " | ",
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('programme/grille_cours/fiche_cours/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'cours' => $arrCour,
    'page' => $arrCour['nom'],
    'grille' => $arrCours,
    'boucle1' => $boucleTwig1,
    'boucle2' => $boucleTwig2
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());
