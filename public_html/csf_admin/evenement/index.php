<?php
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../";
$strNiveauAdmin = "../../";
$strSection = "Ajout d'évenement";
setlocale(LC_TIME,"fr_CA");

$today_date = date("Y-m-d");
//var_dump("Today is " . date("Y-m-d") . "<br>");
$date_formater = strftime("%A %e %B", strtotime($today_date));

if (isset($_GET['errorDate'])){
    echo 'vous ne pouvez publié un evenement qui se produira dans plus de 15 jours.';
}

if (isset($_GET['submit_actu'])) {

function check_in_range($start_date, $end_date, $date_from_user)
{
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

    $exp_actu = strtotime($_GET['exp_actu']);
    $end_date = $_GET['exp_actu'];
    $start_date = date('Y-m-d', strtotime('-15 days', $exp_actu));
    $date_from_user =  $_GET['date_ajd'];



}





/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


if (isset($_GET['submit_actu'])) {
    if(check_in_range($start_date, $end_date, $date_from_user) == 1){
        try{
            $strSQLInsertEvenement = "INSERT INTO t_evenement (titre_actualite, description_actualite, url_actualite,date_publication,date_expiration)
            VALUES (". "'".$_GET['titre_actu']."'"."," ."'".$_GET['desc_actu']."'".","."'".$_GET['url_actu']."'".","."'".$_GET['date_ajd']."'".","."'".$_GET['exp_actu']."'".");";
            //var_dump($strSQLInsertEvenement);
            
            if($objConnMySQLi->query($strSQLInsertEvenement) === TRUE){
                $texteErreurInsert = "";
                header('Location:'. $strNiveau . 'administration.php');
            }
            else{
                $strMsgErrInsert= "<p>L'ajout n'a pu être éffectué, réessayez plus tard</p>";
                $except = new Exception($strMsgErrInsert);
                
                throw $except;
            }
        }
        catch (Exception $e) {
            $texteErreurInsert = $e->getMessage();
        }
    }
    else{
        header('Location:'. 'index.php?ajout&errorDate="true"');
    }
    
}


if (isset($_GET['modif_actu'])){
    
    try{
        $strSQLUpdateEvenement = ' UPDATE t_evenement SET 
        titre_actualite = "' . $_GET['titre_actu'] . '",
        description_actualite = "' . $_GET['desc_actu'] . '",
        date_publication = "' . $_GET['date_publication_actu'] . '",
        date_expiration = "' . $_GET['date_expiration_actu'] . '",
        url_actualite = "' . $_GET['url_actu'] . '"
        WHERE id_actualite = ' . $_GET['id_actu'] . '';
        if($objConnMySQLi->query($strSQLUpdateEvenement)=== TRUE){
            $texteErreurUpdate = "";
             header('Location:'. $strNiveau . 'administration.php');
        }
        else{
            $strMsgErrUpdate= "<p>Les modifications n'ont pu être apportées, réessayez plus tard</p>";
            $except = new Exception($strMsgErrUpdate);

            throw $except;
        }
    }catch (Exception $e) {
        $texteErreurUpdate = $e->getMessage();
    }
}


if (isset($_GET['edit'])){
    try{
        $strSQLFetchEvenement = "SELECT titre_actualite, description_actualite, date_publication, date_expiration, url_actualite, image_actualite from t_evenement WHERE id_actualite =" . $_GET['id_actu'];
        $objResultFetchEvenement = $objConnMySQLi->query($strSQLFetchEvenement);
        if ($objResultFetchEvenement == false){
            $strMsgErr = "<p>la nouvelle n'a pu être affichés, réessayez plus tard</p>";
            $except = new Exception($strMsgErr);
            $arrEditNouvelle = false;
            throw $except;
        }else{
            while ($objLigneFetchEvenement = $objResultFetchEvenement->fetch_object()){
                $arrEditNouvelle =
                array(
                'titre_actualite' => $objLigneFetchEvenement->titre_actualite,
                'description_actualite' => $objLigneFetchEvenement->description_actualite,
                'date_publication'=> $objLigneFetchEvenement->date_publication,
                'date_expiration'=> $objLigneFetchEvenement->date_expiration,
                'url_actualite'=>$objLigneFetchEvenement->url_actualite,
                'image_actualite'=> $objLigneFetchEvenement->image_actualite,
                'id'=> $_GET['id_actu']
                );
            }
            $strMsgErrNouvelle =false;
        }
        //En cas d'erreur de requête
        if ($objResultFetchEvenement->num_rows == 0) {
            $arrEditNouvelle = null;
        }
        $objResultFetchEvenement->free_result();
    }
    catch (Exception $e) {
        $strMsgErrNouvelle = $e->getMessage();
    }
    
}

/*********** Truc pour les dates *************/







/*************** 8. TWIG ***********************/
if (isset($_GET['ajout'])){
    $template = $twig->loadTemplate('evenement/ajout.html.twig');
    echo $template->render(array(
    //HEAD
    'title' => "Section administrative | TIM",
    'page' => "",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin,
    'date_ajd' => $today_date
    
    
    ));
}
if (isset($_GET['edit'])){
    $template = $twig->loadTemplate('evenement/edit.html.twig');
    echo $template->render(array(
    //HEAD
    'title' => "Section administrative | TIM",
    'page' => "",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin,
    'arrEditNouvelle' => $arrEditNouvelle

    
    ));
}