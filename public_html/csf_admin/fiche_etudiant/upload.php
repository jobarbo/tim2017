<?php
/**
 * Created by PhpStorm.
 * User: AnnabelleViolette
 * Date: 17-02-28
 * Time: 11:56
 */
$intMatricule = $_POST['matricule'];
include("../inc/classes/uploader.php");


$uploader = new Uploader();
$uploader->setDir('../../dist/images/diplomes/');                       // Dossier de téléversement
$uploader->setExtensions(array('png'));                      // Extensions permises
$uploader->sameName = true;                                 // Conserve le même nom de fichier
$uploader->setMaxSize(5);                                  // Taille max en Mo




if($uploader->uploadFile('photoEtudiant'))                  // Attribut name du formulaire
{
    $imageName = $uploader->getUploadName();               // Retourne le nom du fichier téléversé
    $message = $uploader->getMessage();
    header('Location: index.php?id=' . $intMatricule . '&sauvegardePhoto=' . $message);
    exit;
}
else
{                                                      // Échec lors du téléversement
    $message = $uploader->getMessage();                // Message d'erreur
    header('Location: index.php?id=' . $intMatricule . '&erreur=' . $message);
    exit;
}
?>
