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

$quiz = simplexml_load_file($strNiveau . 'inc/xml/quiz1.xml');

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

$cptR = 0;
foreach($quiz->résultats->resultat as $resultat)
{
    $arrReponses[$cptR] = array();
    $arrReponses[$cptR]['commentaire'] = $resultat->commentaire;
    foreach($resultat->parametres as $itteration)
    {
        $arrReponses[$cptR]['min'] = $itteration->min;
        $arrReponses[$cptR]['max'] = $itteration->max;
    }
    $cptR++;
}

///////////// TWIG //////////////
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => " | As-tu le profil?",
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array());

$template = $twig->loadTemplate('futur_etudiant/profil/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'will' => "the dog",
    'xml' => $arrQuestions,
    'xmlR' => $arrReponses
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());