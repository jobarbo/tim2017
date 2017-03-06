<?php
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../";
$strNiveauAdmin = "../../public/";
$strSection = "Ajout d'évenement";

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');



if (isset($_GET['submit_actu'])) {
    try{
        $strSQLUpdateEvenement = "INSERT INTO t_evenement (titre_actualite, description_actualite, url_actualite) 
        VALUES (". "'".$_GET['titre_actu']."'"."," ."'".$_GET['desc_actu']."'".","."'".$_GET['url_actu']."'".");";
        //var_dump($strSQLUpdateEvenement);

        if($objConnMySQLi->query($strSQLUpdateEvenement) === TRUE){
            //$texteErreurUpdate = "";
            header('Location:'. $strNiveau);
        }
        else{
            //$strMsgErrUpdate= "<p>Les modifications n'ont pu être apportées, réessayez plus tard</p>";
            //$except = new Exception($strMsgErrUpdate);

            //throw $except;
        }
    }
    catch (Exception $e) {
        //$texteErreurUpdate = $e->getMessage();
    }
}









/*************** 8. TWIG ***********************/

$template = $twig->loadTemplate('evenement/index.html.twig');
echo $template->render(array(
    //HEAD
    'title' => "Section administrative | TIM",
    'page' => "",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin

));