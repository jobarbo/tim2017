<?php


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau="";
$section = "Accueil";


/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');




/*************** 3. REQUÊTES DIPLÔMÉS ***********************/
//----- 3.1 Requete pour aller chercher la derniere nouvelle pour l'afficher a l'accueil -----//

try{
    $strSQLNouvelle = "SELECT description_actualite, date_publication, titre_actualite, image_actualite, url_actualite from t_evenement ORDER BY date_publication DESC LIMIT 1";
    $objResultNouvelle = $objConnMySQLi->query($strSQLNouvelle);
    if ($objResultNouvelle == false){
        $strMsgErr = "<p>la nouvelle n'a pu être affichés, réessayez plus tard</p>";
        $except = new Exception($strMsgErr);
        $arrNouvelle = false;
        throw $except;
    }else{
        while ($objLigneNouvelle = $objResultNouvelle->fetch_object()) {
            $arrNouvelle = 
            array(
                'titre_nouvelle' => $objLigneNouvelle->titre_actualite,
                'description_nouvelle' => $objLigneNouvelle->description_actualite,
                'date_nouvelle'=> $objLigneNouvelle->date_publication,
                'image_nouvelle'=> $objLigneNouvelle->image_actualite,
                'url_nouvelle'=>$objLigneNouvelle->url_actualite
            );
        }
        $strMsgErrNouvelle =false;
    }
     //En cas d'erreur de requête
    if ($objResultNouvelle->num_rows == 0) {
        header('Location: ' . $strNiveau . 'erreur/index.php');
    }
    $objResultNouvelle->free_result();
}catch (Exception $e) {
    $strMsgErrNouvelle = $e->getMessage();
}

//----- 3.2 Requete pour aller chercher la derniere nouvelle pour l'afficher a l'accueil -----//


// fermer la connexion
$objConnMySQLi->close();
/*************** 4 TWIG ***********************/
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "",
    'niveau' => $strNiveau
    
));


$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif,
    'niveau' => $strNiveau
));
$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Techniques d'intégration multimédia",
    'nouvelle' => $arrNouvelle,
    'erreur'=> $strMsgErrNouvelle
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau
));


