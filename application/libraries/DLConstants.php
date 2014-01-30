<?php

class DLConstants {

    private static $JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/global.js'
    );
    private static $CSS_FILES = array(
        'assets/css/main.css'
    );

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

}
