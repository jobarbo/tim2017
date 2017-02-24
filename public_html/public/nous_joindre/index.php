<?php
$strNiveau = "../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$arrContact = array();
$request = "SELECT * FROM t_texte WHERE section_et_page = 'Nous joindre'";

if ($objResult = $objConnMySQLi->query($request)) {
    while ($objLigne = $objResult->fetch_object()) {
        $arrContact[] = array(
            'id'=>$objLigne->id_texte,
            'title'=>$objLigne->titre_texte,
            'text'=>$objLigne->texte,
            'section'=>$objLigne->section_et_page
        );
    }
    $objResult->free_result();
}



//PHPMailer
require '../inc/lib/PHPMailer-master/PHPMailerAutoload.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer;
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.sendgrid.net';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'apikey';                           // SMTP username
    $mail->Password = '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';   // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('tim@csf.ca', 'Cegep de Sainte-Foy');
    $mail->addAddress('erwann.letue@gmail.com', 'Destinataire');  // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = $_POST['subject'];
    $mail->Body    = 'Message de '.$_POST['name'].'<br>'.$_POST['email'].'<br><br>'.$_POST['message'];

    if(!$mail->send()) {
        addFlash("danger", "Erreur lors de l'envoi du mail");
    } else {
        addFlash("success", 'Votre message a bien été envoyé !');
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}



$template = $twig->loadTemplate('nous_joindre/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Nous joindre",
    'arrMenuLiensActifs' => $arrMenuActif,
    'contact' => $arrContact
));