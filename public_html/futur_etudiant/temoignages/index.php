<?php


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau="../../";
$strSection = "Témoignages";
$intIdEtudiant = null;
setlocale(LC_TIME,"fr_CA");

//$intIdEtudiant = rand(482,506);
while( in_array(($intIdEtudiant = rand(482,506)), array(491,492)));



/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');



try{

//Requête permettant d'aller chercher tout le texte de la page Perspectives

    $strSQLTemoignage = "SELECT  id_temoignage, temoin, titre_poste, entreprise, url_entreprise, temoignage, annee_diplomation FROM t_temoignage_professionnel ORDER BY temoin";

    $objResultTemoignage = $objConnMySQLi->query($strSQLTemoignage);

    if ($objResultTemoignage == false) {

        $strMessage = "Les textes n'ont pu être affichés, réessayez plus tard";
        $except = new Exception($strMessage);

        throw $except;

    } else {
        while ($objLigneTemoignage = $objResultTemoignage->fetch_object()) {

            $arrTemoignages[] =

                array(
                    'id_temoignage' => $objLigneTemoignage->id_temoignage,
                    'temoin' => $objLigneTemoignage->temoin,
                    'titre_poste' => $objLigneTemoignage->titre_poste,
                    'entreprise' => $objLigneTemoignage->entreprise,
                    'url_entreprise' => $objLigneTemoignage->url_entreprise,
                    'temoignage' => $objLigneTemoignage->temoignage,
                    'annee_diplomation' => $objLigneTemoignage->annee_diplomation
                );

        }
        $objResultTemoignage->free_result();
    }

    
} catch (Exception $e) {

    echo $e->getMessage();

}

/*************** 5 TWIG ***********************/

$template = $twig->loadTemplate('futur_etudiant/temoignages/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Témoignages",
    //HEADER
    'arrMenuLiensActifs' => $arrMenuActif,
    'arrTemoignages' => $arrTemoignages

));