<?php
/**
 * @author Annabelle Violette <anna.violette@hotmail.com>
 * @copyright Copyright (c)2017 – Cégep de sainte-Foy
 * Date: 2017-02
 * Ce fichier s'occupe de:
 * - appeler la BD selon ce qui est reçu en GET
 * - gérer les exceptions des requêtes
 * - retourne le résultat de la requête en html
 */
require_once('config.inc.php');

try {
    //Requete pour aller chercher les diplomés selom le tri
    $strSQL = "SELECT prenom_diplome, nom_diplome, slug, id_diplome FROM t_diplome ORDER BY " . $_GET["tri_interets"] . " desc";

    $objResultTri = $objConnMySQLi->query($strSQL);

    if ($objResultTri == false) {
        $strMsgErr = "<p>Les diplômés n'ont pu être affichés, réessayez plus tard</p>";
        $except = new Exception($strMsgErr);

        throw $except;
    }

    if ($objResultTri->num_rows == 0) {
        echo "<p>Aucun diplômé trouvé</p>";
    } else {
        while ($objLigneTri = $objResultTri->fetch_object()) {
            echo '<li>';
            echo "<a href='diplomes/fiche-etudiant/" . $objLigneTri->slug . "'>";
            echo "<img src='images/" . $objLigneTri->slug . ".jpg' alt='" . $objLigneTri->prenom_diplome . " " . $objLigneTri->nom_diplome . "'/>";
            echo "<p class='nom'>" . $objLigneTri->prenom_diplome . " <span>" . $objLigneTri->nom_diplome . "</span></p>";
            echo "<div><p>Voir la fiche</p></div>";
            echo '</a>';
            echo '</li>';
        }
    }
    $objResultTri->free_result();

} catch (Exception $e) {
    $strMsgErr = $e->getMessage();
    echo $strMsgErr;
}
// fermer la connexion seulement s'il n'y a plus de requêtes à faire
$objConnMySQLi->close();


$intTotalBoucle = 40;

for ($intCpt = 0; $intCpt <= $intTotalBoucle; $intCpt++) {
    usleep(4000);//temps gaspillé
}