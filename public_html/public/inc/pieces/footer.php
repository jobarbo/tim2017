<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-02-07
 */

/*************** REQUÊTES AUTEURS DU SITE ***********************/

//-----Requete pour aller chercher le texte-----//
$strSQLTexte = "SELECT texte FROM t_texte WHERE section_et_page = 'Toutes les pages'";
if ($objResultTexte = $objConnMySQLi->query($strSQLTexte)) {
    while ($objLigneTexte = $objResultTexte->fetch_object()) {
        $strTexteAuteurs = $objLigneTexte->texte;
    }
}

//En cas d'erreur de requête
if($objResultTexte->num_rows == 0){
    header('Location: ' . $strNiveau . 'erreur/index.php');
}

$objResultTexte->free_result();
