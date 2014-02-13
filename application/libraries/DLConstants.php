<?php

class DLConstants {

    private static $JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/global.js',
        'assets/js/noty-2.2.2/js/noty/packaged/jquery.noty.packaged.js'
    );
    private static $CSS_FILES = array(
        'assets/css/main.css'
    );
    private static $ADMIN_JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/jquery_ui/ui-1-10.js',
        'assets/js/admin.js',
        "assets/js/source_fancy/jquery.fancybox.js",
        "assets/js/custom_alert/customAlert.js",
        "assets/js/ckeditorScripts/ckeditor.js",
        "assets/js/timepicker/timepicker.js"
    );
    private static $ADMIN_CSS_FILES = array(
        'assets/css/admin.css',
        'assets/js/jquery_ui/ui-1-10.css',
        "assets/js/source_fancy/jquery.fancybox.css",
        "assets/js/custom_alert/customAlert.css"
    );
    
    public static $ADMIN_LEVEL = 1;
    public static $PARTNER_LEVEL = 2;
    public static $USER_LEVEL = 3;

    public static function pushCSS($css) {
        array_push(self::$CSS_FILES, $css);
    }

    public static function pushJS($js) {
        array_push(self::$JS_FILES, $js);
    }

    public static function getJS_FILES() {
        return self::$JS_FILES;
    }

    public static function getCSS_FILES() {
        return self::$CSS_FILES;
    }
    
    public static function getADMIN_JS_FILES() {
        return self::$ADMIN_JS_FILES;
    }

    public static function getADMIN_CSS_FILES() {
        return self::$ADMIN_CSS_FILES;
    }
    
    
    
    

}
