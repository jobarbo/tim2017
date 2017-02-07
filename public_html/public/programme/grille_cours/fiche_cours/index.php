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
    'page' => $arrCour['nom']
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());
