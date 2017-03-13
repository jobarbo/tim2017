<?php
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "../";
$strNiveauAdmin = "../../";
$strSection = "Ajout d'évenement";
setlocale(LC_TIME,"fr_CA");

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


if (isset($_GET['submit_actu'])) {
    try{
        $strSQLInsertEvenement = "INSERT INTO t_evenement (titre_actualite, description_actualite, url_actualite)
        VALUES (". "'".$_GET['titre_actu']."'"."," ."'".$_GET['desc_actu']."'".","."'".$_GET['url_actu']."'".");";
        //var_dump($strSQLUpdateEvenement);
        
        if($objConnMySQLi->query($strSQLInsertEvenement) === TRUE){
            $texteErreurInsert = "";
            header('Location:'. $strNiveau);
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
             header('Location:'. $strNiveau);
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
                'image_actualite'=> $objLigneFetchEvenement->image_actualite
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








/*************** 8. TWIG ***********************/
if (isset($_GET['ajout'])){
    $template = $twig->loadTemplate('evenement/ajout.html.twig');
    echo $template->render(array(
    //HEAD
    'title' => "Section administrative | TIM",
    'page' => "",
    'niveau' => $strNiveau,
    'niveauAdmin' => $strNiveauAdmin
    
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