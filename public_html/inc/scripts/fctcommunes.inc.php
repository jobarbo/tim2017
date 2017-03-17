<?php
/**
 * Created by PhpStorm.
 * User: vincentbeland
 * Date: 17-01-25
 * Time: 08:19
 */

if(!session_id()) session_start();

/*************** INSTANCIATION CONFIG ***********************/
require_once($strNiveau . 'inc/scripts/config.inc.php');

/*************** HEADER ET FOOTER ***********************/
require_once($strNiveau . 'inc/pieces/header.php');
require_once($strNiveau . 'inc/pieces/footer.php');

/*************** TWIG ***********************/
include_once($strNiveau .'inc/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($strNiveau . 'templates'); //Nom du dossier qui contient nos templates
$flashesFonction = new Twig_SimpleFunction("showFlashes", function() {
    showFlashes();
});
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));
$twig->addFunction($flashesFonction);





//Message flash
function addFlash ($type, $message){
    if(!session_id()) session_start();
    //if (!isset($_SESSION) && !session_start() && !session_id()) session_start();
    if(!isset($_SESSION['flashes'])) $_SESSION['flashes'] = array();
    if(!isset($_SESSION['flashes'][$type])) $_SESSION['flashes'][$type] = array();
    array_push($_SESSION['flashes'][$type], $message);

}

function showFlashes() {
    if(!session_id()) session_start();
    $str = "";
    if(isset($_SESSION['flashes']) && count($_SESSION['flashes']) > 0) {
        foreach($_SESSION['flashes'] as $key => $value) {
            $str .= "<div class='alert alert-$key'>";
                $str .= "<ul>";
                        foreach($value as $message) {
                            $str .= "<li>$message</li>";
                        }
                $str .= "</ul>";
            $str .= "</div>";
            unset($_SESSION['flashes'][$key]);
        }
    }
    echo $str;
}



// Stock form data in _SESSION
function storeDataInSession() {
    if(!session_id()) session_start();
    $_SESSION["formValues"] = $_POST;
}



// Last Values for twig
function showLastValue($param) {
    $result = "";
    if (!session_id()) session_start();
    if (isset($_SESSION["formValues"][$param])){
        $result = $_SESSION["formValues"][$param];
    } else{
        $result = "";
    }
}