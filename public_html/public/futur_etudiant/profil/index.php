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
$cpt = 0;
foreach($quiz->questions->question as $questions)
{
    $arrQuestions[$cpt] = array();
    $arrQuestions[$cpt]['texteQuestion'] = $questions->texteQuestion;
    foreach($questions->reponses as $cle)
    {
        $cpt2 =0;
        foreach ($cle as $itteration)
        {
            $arrQuestions[$cpt]['texteReponse'][$cpt2] = $itteration->texteReponse;
            $arrQuestions[$cpt]['pointage'][$cpt2] = $itteration->pointage;
            $cpt2++;
        }
    }
    $cpt++;
}
//var_dump($arrQuestions);


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
    'xml' => $arrQuestions
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());