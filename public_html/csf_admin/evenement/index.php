<?php
 session_start();
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../";
$strNiveauAdmin = "../../";
$strNiveauCSS = "../";
$strSection = "Ajout d'évenement";
setlocale(LC_TIME,"fr_CA");

$today_date = date("Y-m-d");
//var_dump("Today is " . date("Y-m-d") . "<br>");
$date_formater = strftime("%A %e %B", strtotime($today_date));


/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

/**************** 3.  VÉRIFICATION ET DROITS D'ACCÈS **********************/

if(isset($_SESSION['arrAuthentification'])){
    $arrAuthentification = unserialize($_SESSION['arrAuthentification']);
    if($arrAuthentification["niveau_acces"] == 1){
        header('Location: ../fiche_etudiant/index.php?id=' . $arrAuthentification["nom_usager_admin"]);
    }
}

$errTitre="";
$errDate="";
$errDesc="";


$titreFill='';
$dateFill='';
$descFill='';



if (isset($_GET['submit_actu']) || isset($_GET['modif_actu'])){
    $titreFill = $_GET['titre_actu'];
    $dateFill = $_GET['exp_actu'];
    $descFill = $_GET['desc_actu'];
    if ($_GET['titre_actu']==''){
    $errTitre = $arrMsgErreurs["evenement"]["titre"];
}

if ($_GET['exp_actu']==''){
    $errDate = $arrMsgErreurs["evenement"]["date"];
}

if ($_GET['desc_actu']==''){
    $errDesc = $arrMsgErreurs["evenement"]["description"];
}
}



if (isset($_GET['errorDate'])){
    //echo 'vous ne pouvez publié un evenement qui se produira dans plus de 15 jours.';
   // $strMessageErreurAjoutDate = 'vous ne pouvez publié un evenement qui se produira dans plus de 15 jours.';
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
        //header('Location:'. 'index.php?ajout&errorDate="true"');
    }
    
}


if (isset($_GET['modif_actu'])){
    
    try{
        $strSQLUpdateEvenement = ' UPDATE t_evenement SET 
        titre_actualite = "' . $_GET['titre_actu'] . '",
        description_actualite = "' . $_GET['desc_actu'] . '",
        date_publication = "' . $_GET['date_publication_actu'] . '",
        date_expiration = "' . $_GET['exp_actu'] . '",
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
if (isset($_GET['ajout']) || isset($_GET['submit_actu'])){
    $template = $twig->loadTemplate('evenement/ajout.html.twig');
    echo $template->render(array(
    //HEAD
    'title' => "Section administrative | TIM",
    'page' => "Création d'un nouvel événement",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin,
        'niveauCSS' => $strNiveauCSS,
    'date_ajd' => $today_date,
    'erreur_titre' => $errTitre,
    'erreur_desc' => $errDesc,
    'erreur_date'=> $errDate,
    'titre_fill'=>$titreFill,
    'desc_fill'=>$descFill,
    'date_fill'=>$dateFill
    
    
    ));
}
if (isset($_GET['edit'])){
    $template = $twig->loadTemplate('evenement/edit.html.twig');
    echo $template->render(array(
    //HEAD
    'title' => "Section administrative | TIM",
    'page' => "Modification d'un événement",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin,
        'niveauCSS' => $strNiveauCSS,
    'arrEditNouvelle' => $arrEditNouvelle,
    'erreur_titre' => $errTitre,
    'erreur_desc' => $errDesc,
    'erreur_date'=> $errDate,
    'titre_fill'=>$titreFill,
    'desc_fill'=>$descFill,
    'date_fill'=>$dateFill

    
    ));
}