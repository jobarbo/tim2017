<?php
/**
 * Created by PhpStorm.
 * User: AnnabelleViolette
 * Date: 17-02-28
 * Time: 10:58
 */

/**
Classe de téléversement PHP
 */

class Uploader
{
    // Dossier de destination
    private $destinationPath;
    // Message d'erreur
    private $errorMessage;
    // Extension du fichier
    private $extensions;
    private $allowAll;
    // Taille max en Mo
    private $maxSize;
    // Nom de fichier téléversé
    private $uploadName;
    // Nom initial du fichier de l'utilisateur
    public $name='Uploader';
    // Conserver le même nom de fichier - mettre à false pour plus de sécurité
    public $sameName= true ;
    // Ajout d'un préfixe de séquence au nom de fichier
    public $imageSeq ='';


    function setDir($path){
        $this->destinationPath = $path;
        $this->allowAll = false;
    }

    function allowAllFormats(){
        $this->allowAll = true;
    }

    function setMaxSize($sizeMB){
        $this->maxSize = $sizeMB * (800*360);
    }

    function setExtensions($options){
        $this->extensions = $options;
    }

    function setSameFileName(){
        $this->sameFileName = true;
        $this->sameName = true;
    }

    function getExtension($string){
        $ext = '';
        try{
            $parts  = explode(".",$string);
            $ext    = strtolower($parts[count($parts)-1]);
        }catch(Exception $c){
            $ext  = '';
        }
        return $ext;
    }

    function setMessage($message){
        $this->errorMessage = $message;
    }

    function getMessage(){
        return $this->errorMessage;
    }

    function getUploadName(){
        return $this->uploadName;
    }

    function setSequence($seq){
        $this->imageSeq =   $seq;
    }

    function getRandom(){
        return strtotime(date('Y-m-d H:i:s')).rand(1111,9999).rand(11,99).rand(111,999);
    }

    function sameName($true){
        $this->sameName =   $true;
    }

    function uploadFile($fileBrowse)
    {
        $result =   false;
        $size   =   $_FILES[$fileBrowse]["size"];
        $name   =   $_FILES[$fileBrowse]["name"];
        $ext    =   $this->getExtension($name);
        if(!is_dir($this->destinationPath)){
            //$this->setMessage("Dossier de destination invalide");
            $this->setMessage("dossier");
        }else if(!is_writable($this->destinationPath)){
            //$this->setMessage("Permission d'écriture non définie !");
            $this->setMessage("permissions");
        }else if(empty($name)){
            //$this->setMessage("Fichier non sélectionné ");
            $this->setMessage("vide");
        }else if($size>$this->maxSize){
            //$this->setMessage("Taille du fichier trop grande !");
            $this->setMessage("taille");
        }else if($this->allowAll || (!$this->allowAll && in_array($ext, $this->extensions))){

            if($this->sameName==false){
                $this->uploadName = $this->imageSeq."-".substr(md5(rand(1111,9999)),0,8).$this->getRandom().rand(1111,1000).rand(99,9999).".".$ext;
            }else{
                $this->uploadName = $name;
            }

            if(move_uploaded_file($_FILES[$fileBrowse]["tmp_name"],$this->destinationPath.$this->uploadName)){
                $this->setMessage("succes");
                $result = true;
            }else{
                //$this->setMessage("Échec du téléversement, essayez plus tard!");
                $this->setMessage("echec");
            }
        }else{
            //$this->setMessage("Format de fichier invalide !");
            $this->setMessage("type");
        }
        return $result;
    }

    function deleteUploaded(){
        unlink($this->destinationPath.$this->uploadName);
    }

}

?>