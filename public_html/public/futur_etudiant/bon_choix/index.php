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
            $arrQuestions[$cptQ]['libelleReponse'][$cpt2] = $itteration->libelleReponse;
            $arrQuestions[$cptQ]['texteReponse'][$cpt2] = $itteration->texteReponse;
            $cpt2++;
        }
    }
    $cptQ++;
}

$arrId = array("A", "B");

$erreur = false;
if(isset($_GET['validerQuiz']))
{
    //////////////////// QUIZ COMPLÉTÉ ////////////////////
    for($cpt = 0; $cpt <= 4; $cpt++)
    {
        if(isset($_GET['Q'.$cpt]))
        {
            $erreur = false;
        }
        else
        {
            $erreur = true;
        }
    }

    if($erreur == true)
    {
        ///////////// TWIG //////////////
        $template = $twig->loadTemplate('futur_etudiant/bon_choix/index.html.twig');
        echo $template->render(array(
            'niveau' => $strNiveau,
            'arrMenuLiensActifs' => $arrMenuActif,
            'page' => "Fais-tu le bon choix? | ",
            'xml' => $arrQuestions,
            'tId' => $arrId,
            'erreur' => "Veuillez compléter toutes les questions.",
            'fichier_script' => 'quiz2.js'
        ));
    }
    else
    {
        $arrReponses = array();
        for($cpt = 0; $cpt <= 4; $cpt++)
        {
            if($_GET['Q'.$cpt] == "Oui")
            {
                $arrReponses[$cpt]['libelleReponse']= $arrQuestions[$cpt]['libelleReponse'][0];
                $arrReponses[$cpt]['texteReponse'] = $arrQuestions[$cpt]['texteReponse'][0];
            }
            else
            {
                $arrReponses[$cpt]['libelleReponse'] = $arrQuestions[$cpt]['libelleReponse'][1];
                $arrReponses[$cpt]['texteReponse'] = $arrQuestions[$cpt]['texteReponse'][1];
            }
        }
        ///////////// TWIG //////////////
        $template = $twig->loadTemplate('futur_etudiant/bon_choix/resultat.html.twig');
        echo $template->render(array(
            'niveau' => $strNiveau,
            'arrMenuLiensActifs' => $arrMenuActif,
            'page' => "Fais-tu le bon choix? | ",
            'xml' => $arrQuestions,
            'reponses' => $arrReponses,
            'tId' => $arrId
        ));
    }
}
else
{
    ///////////// TWIG //////////////
    $template = $twig->loadTemplate('futur_etudiant/bon_choix/index.html.twig');
    echo $template->render(array(
        'niveau' => $strNiveau,
        'arrMenuLiensActifs' => $arrMenuActif,
        'page' => "Fais-tu le bon choix? | ",
        'xml' => $arrQuestions,
        'tId' => $arrId,
        'fichier_script' => 'quiz2.js'
    ));
}