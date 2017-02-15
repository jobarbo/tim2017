<?php
$strNiveau = "../";
$section = "Nous joindre";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$stmt = $objConnMySQLi->prepare("SELECT * FROM t_texte WHERE t_texte.section_et_page = ?");
$stmt->bind_param("s", $section);
$stmt->execute();
$pages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


<<<<<<< HEAD
=======

//PHPMailer
require '../inc/lib/PHPMailer-master/PHPMailerAutoload.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer;
    $mail->CharSet = 'UTF-8';

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.sendgrid.net';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'apikey';                           // SMTP username
    $mail->Password = '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';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('tim@csf.ca', 'Cegep de Sainte-Foy');
    $mail->addAddress('erwann.letue@gmail.com', 'Destinataire');  // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = $_POST['subject'];
    $mail->Body    = 'Message de '.$_POST['name'].'<br>'.$_POST['email'].'<br><br>'.$_POST['message'];

    if(!$mail->send()) {
        echo 'Votre message n\'a pas pu être envoyé.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Votre message a bien été envoyé !';
    }

}



>>>>>>> 3d8ed281c0758d5209ed5d89ec47dedd3da9e55f
//Templates
$template = $twig->loadTemplate('pieces/head.html.twig');
echo $template->render(array(
    'title' => "Techniques d'intégration multimédia | TIM",
    'page' => "Les Stages en Techniques d'Intégration Multimédia",
    'niveau' => $strNiveau
));

$template = $twig->loadTemplate('pieces/header.html.twig');
echo $template->render(array(
    'arrMenuLiensActifs' => $arrMenuActif
));

$template = $twig->loadTemplate('nous_joindre/index.html.twig');
echo $template->render(array(
    'niveau' => "../",
    'pages' => $pages
));

$template = $twig->loadTemplate('pieces/footer.html.twig');
echo $template->render(array());