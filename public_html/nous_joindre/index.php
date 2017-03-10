<?php
$strNiveau = "../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$arrContact = array();
$request = "SELECT * FROM t_texte WHERE section_et_page = 'Nous joindre'";

if ($objResult = $objConnMySQLi->query($request)) {
    while ($objLigne = $objResult->fetch_object()) {
        $arrContact[] = array(
            'titre_texte'=>$objLigne->titre_texte,
            'texte'=>$objLigne->texte
        );
    }
    $objResult->free_result();
}



//PHPMailer
require '../inc/lib/PHPMailer-master/PHPMailerAutoload.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer;
    $mail->CharSet = 'UTF-8';

    // Set mailer to use SMTP
    $mail->isSMTP();
    // Specify main and backup SMTP servers
    $mail->Host = 'smtp.sendgrid.net';
    // Enable SMTP authentication
    $mail->SMTPAuth = true;
    // SMTP username
    $mail->Username = 'apikey';
    // SMTP password
    $mail->Password = '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';
    // Enable TLS encryption, `ssl` also accepted
    $mail->SMTPSecure = 'tls';
    // TCP port to connect to
    $mail->Port = 587;

    // Sender
    $mail->setFrom('tim@csf.ca', 'Cegep de Sainte-Foy');

    // Recipient
    /*if (){

    } else{
        $recipient = $_GET['recipient'];
    }*/
    $recipient = isset($_GET['recipient']) ? $_GET['recipient'] : NULL;
    $mail->addAddress($recipient, 'Destinataire');

    $message = $_POST['message'];
    // Set email format to HTML
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body = 'Message de '.$_POST['name'].'<br>'.$_POST['email'].'<br><br>'.nl2br($message);

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
    'contacts' => $arrContact
));


$objConnMySQLi->close();