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


/* Définiton recipient */
$type = (isset($_GET['type']) && $_GET['type'] !== "") ? $_GET['type'] : null;
$slug = (isset($_GET['slug']) && $_GET['slug'] !== "") ? $_GET['slug'] : null;
$arrPerson = null;
if ($slug){
    if (!$type) $type = 'diplome';
    /* Request */
    $request_recipient = "SELECT id_$type, nom_$type, prenom_$type, courriel_$type FROM t_$type WHERE slug = ?";
    $stmt = $objConnMySQLi->prepare($request_recipient);
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $stmt->bind_result($id, $nom, $prenom, $recipient);
    $stmt->fetch();
    $arrPerson = array(
        'id' => $id,
        'slug' => $slug,
        'nom' => $nom,
        'prenom' => $prenom,
        'recipient' => $recipient
    );

    if ($arrPerson['id'] == null){
        $arrPerson = null;

        addFlash("danger", "Le destinataire n'a pas été trouvé.");
        addFlash("danger", "Veuillez en choisir un dans la liste présente ci-dessous.");
    }
}





//PHPMailer
require '../inc/lib/PHPMailer-master/PHPMailerAutoload.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Validation reCAPTCHA */
    if(isset($_POST['submit']) && !empty($_POST['submit'])){
        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
            //your site secret key
            $secret = '6LeHzxgUAAAAANJY459jOopZG7nE-WZySqxUYTdG';
            //get verify response data
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            if($responseData->success) {
                //contact form submission code
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
                $mail->setFrom('contact@timcsf.ca', 'Cegep de Sainte-Foy');


                // Recipient
                $mail->addAddress($_POST['recipient'], 'Destinataire');


                $message = $_POST['message'];
                // Set email format to HTML
                $mail->isHTML(true);
                $mail->Subject = $_POST['subject'];
                $mail->Body = 'Message de ' . $_POST['name'] . '<br>' . $_POST['email'] . '<br><br>' . nl2br($message);


                if (!$mail->send()) {
                    addFlash("danger", "Erreur lors de l'envoi du mail");
                } else {
                    addFlash("success", 'Votre message a bien été envoyé !');
                }
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;

            } else {
                addFlash('danger', 'Erreur lors de la vérification du captcha');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        } else{
            addFlash('danger', 'Cochez la case "Je ne suis pas un robot"');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}





$template = $twig->loadTemplate('nous_joindre/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Nous joindre",
    'arrMenuLiensActifs' => $arrMenuActif,
    'type' => $type,
    'contacts' => $arrContact,
    'person' => $arrPerson,
    'server' => $_SERVER
));



$objConnMySQLi->close();