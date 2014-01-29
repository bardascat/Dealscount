<?php

class View {

    private $css;
    private $js;

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

}
?>

