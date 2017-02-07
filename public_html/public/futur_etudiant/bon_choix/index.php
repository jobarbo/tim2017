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
$strNiveau="../../";


/*************** INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


/*************** CONNEXION ET ÉLÉMENTS XML ***********************/

$quiz = simplexml_load_file($strNiveau . 'inc/xml/quiz2.xml');

$arrQuestions = array();
$arrReponses = array();
$cptQ = 0;
foreach($quiz->questions->question as $questions)
{
    $arrQuestions[$cptQ] = array();
    $arrQuestions[$cptQ]['texteQuestion'] = $questions->texteQuestion;
    foreach($questions->reponses as $cle)
    {
        $cpt2 =0;
        foreach ($cle as $itteration)
        {
            $arrQuestions[$cptQ]['texteReponse'][$cpt2] = $itteration->texteReponse;
            $arrQuestions[$cptQ]['pointage'][$cpt2] = $itteration->pointage;
            $cpt2++;
        }
    }
    $cptQ++;
}

///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Fais-tu le bon choix? | ",
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('futur_etudiant/bon_choix/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'xml' => $arrQuestions
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());