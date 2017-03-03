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

$erreur = false;
$pointage = 0;
if(isset($_GET['validerQuiz']))
{
    for($cpt = 0; $cpt <= 9; $cpt++)
    {
        if(isset($_GET['Q'.$cpt]))
        {
            $pointage += $_GET['Q'.$cpt];
        }
        else
        {
            $erreur = true;
        }
    }

    if($erreur == true)
    {
        /////////////////// RETOURNER SUR LA PAGE AVEC MESSAGE D'ERREUR ///////////////////
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

        $arrId = array("A", "B", "C", "D");

        ///////////// TWIG //////////////
        $template = $twig->loadTemplate('futur_etudiant/profil/index.html.twig');
        echo $template->render(array(
            'niveau' => $strNiveau,
            'page' => "As-tu le profil? | ",
            'xml' => $arrQuestions,
            'tId' => $arrId,
            'arrMenuLiensActifs' => $arrMenuActif,
            'erreur' => "Veuillez compléter toutes les questions.",
            'fichier_script' => 'quiz1.js'

        ));
    }
    $pointage = $pointage * 2;
    $bonneReponse = "";

    $quiz = simplexml_load_file($strNiveau . 'inc/xml/quiz1.xml');
    $cptR = 0;
    $arrReponses = array();
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

    if($pointage >= $arrReponses[0]['min'] &&  $pointage <= $arrReponses[0]['max'])
    {
        $bonneReponse = $arrReponses[0]['commentaire'];
    }
    else
    {
        if($pointage >= $arrReponses[1]['min'] &&  $pointage <= $arrReponses[1]['max'])
        {
            $bonneReponse = $arrReponses[1]['commentaire'];
        }
        else
        {
            if($pointage >= $arrReponses[2]['min'] &&  $pointage <= $arrReponses[2]['max'])
            {
                $bonneReponse = $arrReponses[2]['commentaire'];
            }
        }
    }

    ///////////// TWIG //////////////
    $template = $twig->loadTemplate('futur_etudiant/profil/resultat.html.twig');
    echo $template->render(array(
        'niveau' => $strNiveau,
        'page' => "As-tu le profil? | ",
        'arrMenuLiensActifs' => $arrMenuActif,
        'bonneReponse' => $bonneReponse,
    ));
}
else
{
    /////////////////// PREMIER CHARGEMENT DE PAGE ///////////////////
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

    $arrId = array("A", "B", "C", "D");

    ///////////// TWIG //////////////
    $template = $twig->loadTemplate('futur_etudiant/profil/index.html.twig');
    echo $template->render(array(
        'niveau' => $strNiveau,
        'page' => "As-tu le profil? | ",
        'xml' => $arrQuestions,
        'tId' => $arrId,
        'arrMenuLiensActifs' => $arrMenuActif,
        'fichier_script' => 'quiz1.js'
    ));
}