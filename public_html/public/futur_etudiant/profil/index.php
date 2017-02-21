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

        $arrId = ["A", "B", "C", "D"];

        ///////////// TWIG //////////////
        $template = $twig->loadTemplate('pieces/head.html.twig');
        echo $template->render(array(
            'title' => "Techniques d'intégration multimédia | TIM",
            'page' => "As-tu le profil? | ",
            'niveau' => $strNiveau
        ));
        $template = $twig->loadTemplate('pieces/header.html.twig');
        echo $template->render(array(
            'arrMenuLiensActifs' => $arrMenuActif
        ));

        $template = $twig->loadTemplate('futur_etudiant/profil/index.html.twig');
        echo $template->render(array(
            'niveau' => $strNiveau,
            'xml' => $arrQuestions,
            'tId' => $arrId,
            'erreur' => "Veuillez compléter à toutes les questions."
        ));

        $template = $twig->loadTemplate('pieces/footer.html.twig');
        echo $template->render(array());
    }
    $pointage = $pointage * 2;
    echo $pointage;
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
    $template = $twig->loadTemplate('pieces/head.html.twig');
    echo $template->render(array(
        'title' => "Techniques d'intégration multimédia | TIM",
        'page' => "As-tu le profil? | ",
        'niveau' => $strNiveau
    ));
    $template = $twig->loadTemplate('pieces/header.html.twig');
    echo $template->render(array(
        'arrMenuLiensActifs' => $arrMenuActif
    ));

    $template = $twig->loadTemplate('futur_etudiant/profil/resultat.html.twig');
    echo $template->render(array(
        'niveau' => $strNiveau,
        'bonneReponse' => $bonneReponse
    ));

    $template = $twig->loadTemplate('pieces/footer.html.twig');
    echo $template->render(array());

    $template = $twig->loadTemplate('pieces/scripts.html.twig');
    echo $template->render(array(
        'fichier_script' => 'quiz1.js'
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

    $arrId = ["A", "B", "C", "D"];

    ///////////// TWIG //////////////
    $template = $twig->loadTemplate('pieces/head.html.twig');
    echo $template->render(array(
        'title' => "Techniques d'intégration multimédia | TIM",
        'page' => "As-tu le profil? | ",
        'niveau' => $strNiveau
    ));
    $template = $twig->loadTemplate('pieces/header.html.twig');
    echo $template->render(array(
        'arrMenuLiensActifs' => $arrMenuActif
    ));

    $template = $twig->loadTemplate('futur_etudiant/profil/index.html.twig');
    echo $template->render(array(
        'niveau' => $strNiveau,
        'xml' => $arrQuestions,
        'tId' => $arrId
    ));

    $template = $twig->loadTemplate('pieces/footer.html.twig');
    echo $template->render(array());

    $template = $twig->loadTemplate('pieces/scripts.html.twig');
    echo $template->render(array(
        'fichier_script' => 'quiz1.js'
    ));
}