<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
set_include_path("application/libraries");
require_once(APPPATH . '/libraries/Zend/Acl.php');
require_once(APPPATH . '/libraries/Zend/GenerateAclResources.php');
require_once(APPPATH . '/libraries/Zend/AnnotationReader.php');

class Zacl extends Zend_Acl {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    public function generateResource() {
        $resourceGenerator = new GenerateAclResources();
        $acl = $resourceGenerator->buildAllArrays();
        return $acl;
    }

}
