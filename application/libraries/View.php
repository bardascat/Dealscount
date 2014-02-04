<?php

class View {

    private $css;
    private $js;
    private $logged_user=FALSE;
    private $page_name;
    private $page_description;
    
    function __construct() {
        
    }

    public function getCss($admin=false) {
         $cssFiles=($admin ? DLConstants::getADMIN_CSS_FILES() : DLConstants::getCSS_FILES());
         if($cssFiles){
            $scripts='';
            foreach($cssFiles as $css){
                $scripts.='<link rel="stylesheet" type="text/css" href="'.base_url($css).'"/>';
            }
        }
        return $scripts;
    }

    public function getJs($admin=false) {
        $jsFiles=$cssFiles=($admin ? DLConstants::getADMIN_JS_FILES() : DLConstants::getJS_FILES());
        if($jsFiles){
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



    public function getPage_name() {
        return $this->page_name;
    }

    public function setPage_name($page_name) {
        $this->page_name = $page_name;
        return $this;
    }

    public function getPage_description() {
        return $this->page_description;
    }

    public function setPage_description($page_description) {
        $this->page_description = $page_description;
        return $this;
    }




}
?>

