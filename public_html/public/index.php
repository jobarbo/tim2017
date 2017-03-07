<?php


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau="";
$strSection = "Accueil";
$intIdEtudiant = null;
setlocale(LC_TIME,"fr_CA");

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
                'date_nouvelle'=> strftime("%A %e %B", strtotime($objLigneNouvelle->date_publication)), //$objLigneNouvelle->date_publication,
                'image_nouvelle'=> $objLigneNouvelle->image_actualite,
                'url_nouvelle'=>$objLigneNouvelle->url_actualite
            );
        }
        $strMsgErrNouvelle =false;
    }
     //En cas d'erreur de requête
    if ($objResultNouvelle->num_rows == 0) {
        header('Location: ' . $strNiveau . '404/index.php');
    }
    $objResultNouvelle->free_result();
}catch (Exception $e) {
    $strMsgErrNouvelle = $e->getMessage();
}


//----- 3.2 Requete pour aller chercher les projets et les afficher sur l'accueil' -----//

try {
    $strSQLProjetsEtudiant = "SELECT t_projet_diplome.id_diplome, id_projet, titre_projet, t_projet_diplome.slug, nom_diplome, prenom_diplome FROM t_projet_diplome INNER JOIN t_diplome ON t_projet_diplome.id_diplome = t_diplome.id_diplome ORDER BY RAND() LIMIT 4";
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
                        'prenom' => $objLigneProjetsEtudiant->prenom_diplome,
                        'nom' => $objLigneProjetsEtudiant->nom_diplome,
                        'id' => $objLigneProjetsEtudiant->id_projet,
                        'titre' => $objLigneProjetsEtudiant->titre_projet,
                        'slug' => $objLigneProjetsEtudiant->slug,
                        'id_diplome' => $objLigneProjetsEtudiant->id_diplome
                    );
            }
       
        $texteErreurProjets = false;
    }
    //en cas d'erreur de requete'
    if ($objResultProjetsEtudiant->num_rows == 0) {
        header('location: ' . $strNiveau . '404/index.php');
    }

    $objResultProjetsEtudiant->free_result();
     
} catch (Exception $e) {
    $texteErreurProjets = $e->getMessage();
}


// fermer la connexion
$objConnMySQLi->close();


/*************** 3. REQUÊTES Facebook Twitter ***********************/
//----- 3.1 Facebook -----//

//Actualités Facebook
$key = "618606544889881|Tze6Ov0h0QvOQQosKdn7ZR1_y3U";
$url = 'https://graph.facebook.com/timcsf?fields=posts.limit(1).fields(message,created_time,icon,name,id,link)&access_token='.$key;
$des = json_decode(file_get_contents($url));
$objPost = $des->posts->data;

//var_dump($objPost);

$strActualite = "";
foreach($objPost as $valeur)
{
    $id = $valeur->id;
    $leBonId = substr($id,16,17);

    $dateFb= rtrim(strftime('%e %B %G',strtotime($valeur->created_time)),'.');
    $bonneDate = utf8_encode($dateFb);
    $message = limit_text($valeur->message,140);

	$name = isset($valeur->name) ? $valeur->name : "Consultez la nouvelle";

    $strActualiteFb = $message ;
    $linkFb =  $valeur->link;
    //$strActualite .= "<div class='col'><p class='date icon-clock'>" . $bonneDate . "</p><p>" . $message . " <a target='_blank' href='" . $valeur->link . "'>" . $valeur->name . "</a></p>" .
   //     "</div>";
}

function limit_text($text, $len) {
    if (strlen($text) < $len) {
        return $text;
    }
    $text_words = explode(' ', $text);
    $out = null;


    foreach ($text_words as $word) {
        if ((strlen($word) > $len) && $out == null) {

            return substr($word, 0, $len) . "...";
        }
        if ((strlen($out) + strlen($word)) > $len) {
            return $out . "...";
        }
        $out.=" " . $word;
    }
    return $out;
}

//echo $strActualite;
//echo $date;

//echo $linkFb;

//----- 3.2 Twitter -----//

//Actualités Twitter

//1 - Configuration
$consumer_key='73ScsBGIJ25wK4YNA4guVQ'; //Provide your application consumer key
$consumer_secret='T4ffzc6J9BGCxPZh3vwRkiIv1ZLBUTZHbsqjD3ejRs'; //Provide your application consumer secret
$oauth_token = '516726609-8B75YPlPRuCI1PSjeJCxdjdgH8utelkSFmiKjNEf'; //Provide your oAuth Token
$oauth_token_secret = 'BOqw2kxT2RWfj6PvFdQHOrJaomlN6bVKHFR6I0zydx2jI'; //Provide your oAuth Token Secret


if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {

    //2 - Inclut la librairie twitterOAuth
    require_once 'inc/scripts/twitteroauth/twitteroauth.php';

    //3 - Authentification
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

    //4 - Start Querying
    $query = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=timcsf&count=1'; //Your Twitter API query
    $content = $connection->get($query);
    $arrTwitter = $content;

}

//Transform Tweet plain text into clickable text

function parseTweet($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '<br><a  target="_blank" href="$0">$0', $text); //Link
    $text = preg_replace('#@([a-z0-9_]+)#i', '<br>@<a  target="_blank" href="http://twitter.com/$1">$1', $text); //usernames
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '<br><a  target="_blank" href="$0">$0', $text); //Links
    return $text;
}

/*function parseTweet($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '', $text); //Link
    $text = preg_replace('#@([a-z0-9_]+)#i', '', $text); //usernames
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '', $text); //Links
    return $text;
}*/

$strActualiteTweet = "";


foreach($arrTwitter as $tweet){
    $dateTweet= rtrim(strftime('%e %B %G',strtotime($tweet->created_at)),'.');
    $bonneDateTweet = utf8_encode($dateTweet);

    $strActualiteTweet =  parseTweet($tweet->text);


}

$tPos=strpos($strActualiteTweet,">http");
$link_tweet=substr($strActualiteTweet,$tPos+1);

//echo $strActualiteTweet;
//echo $dateTweet;



/*************** 5 TWIG ***********************/

$template = $twig->loadTemplate('index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Techniques d'intégration multimédia",
    'lien_tweet' => $link_tweet,
    'texte_tweet' => $strActualiteTweet,
    'date_tweet' => $dateTweet,
    'lien_fb'=> $linkFb,
    'texte_fb'=>$strActualiteFb,
    'date_fb'=>$dateFb,
    'nouvelle' => $arrNouvelle,
    'arrProjets' => $arrProjetsEtudiant,
    'texteErreurNouvelle'=> $strMsgErrNouvelle,
    'texteErreurProjets' => $texteErreurProjets
));



