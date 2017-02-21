<?php
/**
 * @author William Charest-Pépin <williamcharestpepin@gmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 *
/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "";
$strNiveauAdmin="../public/";
$strSection = "Connexion";

session_start();

/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');


if(isset($_POST["btnConnecter"])){

    $arrAuthentification = array();

    $strSQLConnexion = "SELECT nom_usager_admin, mot_de_passe, niveau_acces FROM t_usager_admin WHERE nom_usager_admin = ? AND mot_de_passe = ?";

    $nomUsager = $_POST["nomUsager"];
    $motDePasse = $_POST["motDePasse"];

    $objRequetePreparee = $objConnMySQLi->prepare($strSQLConnexion);
    $objRequetePreparee->bind_param('ss', $nomUsager, $motDePasse);
    $objRequetePreparee->execute();

    $objRequetePreparee->store_result();
    $objRequetePreparee->bind_result($nomUsager, $motDePasse, $niveauAcces);


    if($objRequetePreparee->fetch()){

        $arrResultats = array('nom_usager_admin'=>$nomUsager, 'mot_de_passe'=>$motDePasse, 'niveau_acces'=>$niveauAcces);

        $arrAuthentification = $arrResultats;
        $_SESSION['arrAuthentification'] = serialize($arrAuthentification);

        header("Location: routeur.php");
        exit;

    }else{

        echo "Le nom d'utilisateur ou le mot de passe est incorrect. Veuillez réessayer";
    }



    $objRequetePreparee->free_result();

}

$objConnMySQLi->close();

/*************** 4 TWIG ***********************/
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Section administrative | TIM",
    'page' => "",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array());

$template = $twig->loadTemplate('connexion.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Section administrative"
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());