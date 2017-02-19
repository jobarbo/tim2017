<?php


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau="";
$strSection = "Accueil";
$intIdEtudiant = null;

//$intIdEtudiant = rand(482,506);
while( in_array(($intIdEtudiant = rand(482,506)), array(491,492)));



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


//----- 3.2 Requete pour aller chercher les projets et les afficher sur l'accueil' -----//

try {
    $strSQLProjetsEtudiant = "SELECT id_projet, titre_projet, slug FROM t_projet_diplome WHERE id_diplome = " . $intIdEtudiant;
    $objResultProjetsEtudiant = $objConnMySQLi->query($strSQLProjetsEtudiant);
    

    if ($objResultProjetsEtudiant == false){
        
        $strMsgErrProjets = "<p>Les projets de l'étudiant n'a pu être affichés, réessayez plus tard</p>";
        $except = new Exception($strMsgErrProjets);
        $arrProjetsEtudiant = false;

        throw $except;
    }
    else{    
         while ($objLigneProjetsEtudiant = $objResultProjetsEtudiant->fetch_object()) {
                $arrProjetsEtudiant[] =
                    array(
                        'id' => $objLigneProjetsEtudiant->id_projet,
                        'titre' => $objLigneProjetsEtudiant->titre_projet,
                        'slug' => $objLigneProjetsEtudiant->slug
                    );
            }
       
        $texteErreurProjets = false;
    }
    //en cas d'erreur de requete'
    if ($objResultProjetsEtudiant->num_rows == 0) {
        header('location: ' . $strNiveau . 'erreur/index.php');
    }

    $objResultProjetsEtudiant->free_result();
     
} catch (Exception $e) {
    $texteErreurProjets = $e->getMessage();
}

//----- 3.3 Requete pour aller chercher le nom de létudiant pour les projets -----//

try{
    $strSQLInfoEtudiant = "SELECT nom_diplome, prenom_diplome, slug FROM t_diplome WHERE id_diplome = " . $intIdEtudiant;
    $objResultInfosEtudiant =  $objConnMySQLi->query($strSQLInfoEtudiant);
    if($objResultInfosEtudiant == false){
        $strMsgErrFiche = "<p>La fiche de l'étudiant n'a pu être affichée, réessayez plus tard</p>";
        $except = new Exception($strMsgErrFiche);
        $arrInfosEtudiant = false;
        throw $except;
    }else{
        while ($objLigneInfosEtudiant = $objResultInfosEtudiant->fetch_object()){
            $arrInfosEtudiant =
            array(
                'prenom' => $objLigneInfosEtudiant->prenom_diplome,
                'nom' => $objLigneInfosEtudiant->nom_diplome,
                'slug' => $objLigneInfosEtudiant->slug,
            );
        }
        $texteErreurFiche = false;
    }

    if ($objResultInfosEtudiant->num_rows== 0){
        header('location: ' . $strNiveau . 'erreur/index.php');
    }
    $objResultInfosEtudiant->free_result();
} catch (Exception $e){
    $texteErreurFiche = $e->getMessage();
}

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
    'arrInfos' => $arrInfosEtudiant,
    'arrProjets' => $arrProjetsEtudiant,
    'texteErreurNouvelle'=> $strMsgErrNouvelle,
    'texteErreurProjets' => $texteErreurProjets
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau
));


