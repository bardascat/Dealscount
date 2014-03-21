<?php

class DLConstants {

    private static $JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/global.js',
        'assets/js/noty-2.2.2/js/noty/packaged/jquery.noty.packaged.js',
        "assets/js/source_fancy/jquery.fancybox.js"
    );
    private static $CSS_FILES = array(
        'assets/css/main.css',
        "assets/js/source_fancy/jquery.fancybox.css"
    );
    private static $ADMIN_JS_FILES = array(
        'assets/js/jquery.1.10.min.js',
        'assets/js/jquery_ui/ui-1-10.js',
        'assets/js/admin.js',
        "assets/js/source_fancy/jquery.fancybox.js",
        "assets/js/custom_alert/customAlert.js",
        "assets/js/ckeditorScripts/ckeditor.js",
        "assets/js/timepicker/timepicker.js",
        'assets/js/noty-2.2.2/js/noty/packaged/jquery.noty.packaged.js'
    );
    private static $ADMIN_CSS_FILES = array(
        'assets/css/admin.css',
        'assets/js/jquery_ui/ui-1-10.css',
        "assets/js/source_fancy/jquery.fancybox.css",
        "assets/js/custom_alert/customAlert.css"
    );
    private static $ADMIN_CSS_FILES_POPUP = array(
        'assets/css/popups.css',
        'assets/js/jquery_ui/ui-1-10.css',
        "assets/js/source_fancy/jquery.fancybox.css",
        "assets/js/custom_alert/customAlert.css"
    );
    public static $MASTER_PASSWORD = "MAST3Rpassword";
    public static $DEFAULT_ROLE = "guest";
    public static $PARTNER_ROLE = "partener";
    public static $OPERATOR_ROLE = "partener";
    public static $ADMIN_ROLE = "admin";
    public static $USER_ROLE = "user";
    public static $WEBSITE = "dev.getadeal.ro";
    public static $WEBSITE_COMMERCIAL_NAME = "getadeal.ro";
    public static $OFFICE_EMAIl = "office@getadeal.ro";
    //PAYMENT METHODS
    public static $PAYMENT_METHOD_CARD = 'CARD';
    public static $PAYMENT_METHOD_OP = 'OP';
    public static $PAYMENT_METHOD_FREE = 'FREE';
    public static $PAYMENT_METHOD_RAMBURS = 'RAMBURS';
    //PAYMENT STATUS
    public static $PAYMENT_STATUS_CONFIRMED = "F";
    public static $PAYMENT_STATUS_PENDING = "W";
    public static $PAYMENT_STATUS_CANCELED = "C";
    //ORDER STATUS
    public static $ORDER_STATUS_CONFIRMED = "F";
    public static $ORDER_STATUS_PENDING = "W";
    public static $ORDER_STATUS_CANCELED = "C";
    //PARTNER STATUS
    public static $PARTNER_ACTIVE = "F";
    public static $PARTNER_PENDING = "W";
    public static $PARTNER_SUSPENDED = "C";
    //NEWSLETTER STATUS
    public static $NEWSLETTER_SENT = "F";
    public static $NEWSLETTER_PENDING = "W";
    public static $NEWSLETTER_SUSPENDED = "C";
    //prefix
    public static $CODE_PREFIX = "GAD";
    //optiuni bonamente
    public static $OPTIUNE_VALABILITATE = "valabilitate";
    public static $OPTIUNE_OFERTA_PROMOVATA = "oferta_promovata";
    public static $OPTIUNE_OFERTA_PROMOVATA_CATEGORIE = "oferta_promovata_categorie";
    public static $OPTIUNE_OFERTA_PROMOVATA_SUBCATEGORIE = "oferta_promovata_subcategorie";
    public static $OPTIUNE_PROMOVARE_NEWSLETTER = "promovare_newsletter";
    public static $OPTIUNE_NEWSLETTER_PERSONAL = "newsletter_personal";
    public static $OPTIUNE_POSTARE_SUPLIMENTARA = "postare_suplimentara";

    public static $INVOICE_SERIES="GAD";
    
    //supplierr info
    public static $SUPPLIER_NAME="Get A deal";
    public static $SUPPLIER_REG_COM="REG COM";
    public static $SUPPLIER_CUI="CUI";
    public static $SUPPLIER_ADDRESS="bucuresti, dorotbanti";
    public static $SUPPLIER_IBAN="RO123";
    public static $SUPPLIER_BANK="TRANSILVANIA";
    
    public static $CRON_ACCESS="145839a025a99bda2e8f4f6a21ebbd5a4c893e91";
    
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

    public static function getADMIN_CSS_FILES_POPUP() {
        return self::$ADMIN_CSS_FILES_POPUP;
    }

}
