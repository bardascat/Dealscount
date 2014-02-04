<?php

class DLConstants {

    private static $JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/global.js'
    );
    private static $CSS_FILES = array(
        'assets/css/main.css'
    );
    private static $ADMIN_JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/global.js'
    );
    private static $ADMIN_CSS_FILES = array(
        'assets/css/admin.css'
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
