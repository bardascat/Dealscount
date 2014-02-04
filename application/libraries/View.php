<?php

class View {

    private $css;
    private $js;
    private $logged_user=FALSE;
    
    function __construct() {
        
    }

    public function getCss() {
         if(DLConstants::getCSS_FILES()){
            $cssFiles=DLConstants::getCSS_FILES();
            $scripts='';
            foreach($cssFiles as $css){
                $scripts.='<link rel="stylesheet" type="text/css" href="'.base_url($css).'"/>';
            }
        }
        return $scripts;
    }

    public function getJs() {
        if(DLConstants::getJS_FILES()){
            $jsFiles=DLConstants::getJS_FILES();
            $scripts='';
            foreach($jsFiles as $js){
                $scripts.='<script type="text/javascript" src="'.base_url($js).'"></script>';
            }
        }
        return $scripts;
    }

    public function getUser() {
        return $this->logged_user;
    }

    public function setUser($logged_user) {
        $this->logged_user = $logged_user;
        return $this;
    }
    
    public function show_message($notification){
        
        return "<div id='".$notification['type']."' class='".$notification['cssClass']."'>".$notification['message']."</div>";
        
    }





}
?>

