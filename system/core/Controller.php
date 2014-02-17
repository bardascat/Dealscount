<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

    private static $instance;

    /**
     *
     * @var \Dealscount\Models\UserModel
     */
    protected $UserModel;

    /**
     *
     * @var \Dealscount\Models\CategoriesModel
     */
    protected $CategoriesModel = null;

    /**
     * Constructor
     */
    public function __construct() {

        self::$instance = & $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var = & load_class($class);
        }

        $this->load = & load_class('Loader', 'core');

        $this->load->initialize();
        $this->checkPermission();
        $this->initDependencies();
        
        log_message('debug', "Controller Class Initialized");
    }

    public static function &get_instance() {
        return self::$instance;
    }

    public function load_view($view, $vars = array()) {
        $this->load->view('header', $vars);
        $this->load->view($view, $vars);
        $this->load->view('footer');
    }

    public function load_view_admin($view, $vars = array()) {
        $this->load->view('admin/header', $vars);
        $this->load->view($view, $vars);
    }

    public function load_view_admin_popup($view, $vars = array()) {
        $this->load->view('admin/header_popup', $vars);
        $this->load->view($view, $vars);
    }

    //intoarce userul curent
    public function getLoggedUser($orm = false) {
        $user = get_cookie('dl_loggedin');
        if (!$user)
            return false;
        $user = unserialize($user);
        if ($orm)
            $user = $this->UserModel->getUserByPk($user['id_user']);

        return $user;
    }

    /**
     * Genereaza un un hash unic pentru cart
     * @return type
     */
    protected function setHash() {
        if (get_cookie('cart_id')) {
            $cookie_id = unserialize(get_cookie('cart_id'));
            return $cookie_id;
        } else {
            $cookie_id = $this->generateHash();
            $cookie = array(
                'name' => 'cart_id',
                'value' => serialize($cookie_id),
                'expire' => time() + 10 * 365 * 24 * 60 * 60,
                'path' => "/"
            );
            set_cookie($cookie);

            return $cookie_id;
        }
    }

    protected function getCartHash() {
        return $this->setHash();
    }

    private function generateHash() {
        return md5(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    public function setAccessLevel($level) {
        echo 'Access level';
    }

    protected function upload_images($upload_images, $path, $Entity = "Dealscount\Models\Entities\ItemImage", $resize = true) {

        $this->load->library('SimpleImage', false, 'SimpleImage');


        if (!is_dir('application_uploads'))
            mkdir('application_uploads', 0777);

        $image = $this->SimpleImage;

        $images = array();
        foreach ($upload_images['tmp_name'] as $tmp_file) {
            if ($Entity)
                $productImage = new $Entity;
            else
                $productImage = array();

            if ($tmp_file != "") {
                if (!is_dir($path))
                    mkdir($path, 0777);

                $photo_name = substr(md5(rand(100, 9999)), 0, 10) . '.jpg';
                if (!move_uploaded_file($tmp_file, $path . '/' . $photo_name)) {
                    exit('erroare');
                }

                //huge
                $image->load($path . '/' . $photo_name);
                $image->resizePerfect(1200, 1200);
                $image->save($path . '/huge_' . $photo_name);

                if ($resize) {
                    //big photo
                    $image->load($path . '/' . $photo_name);
                    $image->resizePerfect(550, 550);
                    $image->save($path . '/' . $photo_name);
                }

                if (is_object($productImage))
                    $productImage->setImage($path . '/' . $photo_name);
                else
                    $productImage['image'] = $path . '/' . $photo_name;

                //thumb
                $image->load($path . '/' . $photo_name);
                $image->resizePerfect(200, 200);
                $image->save($path . '/thumb_' . $photo_name);
                if (is_object($productImage)) {
                    $productImage->setThumb($path . '/thumb_' . $photo_name);
                } else {

                    $productImage['thumb'] = $path . '/thumb_' . $photo_name;
                }
                $images[] = $productImage;
            }
        }
        return $images;
    }

    protected function populate_form($object) {

        //repopulate fields
        $js = '<script type="text/javascript"> $(document).ready(function(){';
        $iteration = $object->getIterationArray();

        foreach ($iteration as $key => $value) {

            if (is_object($value)) {
                if (get_class($value) == "DateTime") {
                    if ($key == "start_date" || $key == "end_date")
                        $value = $value->format("d-m-Y H:i:s");
                    else
                        $value = $value->format("d-m-Y");
                }
            }
            //daca in DB e NULL in js apare tot null

            if (is_null($value))
                $value = "";
            $value = json_encode($value);
            $js.='$(":input[name= \'' . $key . '\']").val(' . $value . ');';
        }
        $js.='});</script>';

        $this->view->setPopulate_form($js);
    }

    private function initDependencies() {
        $this->UserModel = new \Dealscount\Models\UserModel();
        $this->CategoriesModel = new Dealscount\Models\CategoriesModel();
        $this->view->setUser($this->getLoggedUser());
        $this->view->setCategories($this->CategoriesModel->getRootCategories('offer', true));
        $this->view->setNotification($this->session->flashdata('notification'));
        $this->generateAclResources();
        $this->setHash();
    }

    private function checkPermission() {

        $user = $this->getLoggedUser();
        if (!$user)
            $role = DLConstants::$DEFAULT_ROLE;
        else
            $role = $user['role'];

        $controller = $this->router->class;
        $method = $this->router->method;

         
        if ($this->uri->segment(1) == "admin") {
            //validam daca are acces in admin
            if (!$this->zacl->check_acl('admin', $role)) {
                redirect(base_url('util/permission_denied'));
            }
            //verificam daca are acces pe metoda
            $resource = 'admin/' . $controller . '/' . $method;
            
            if (!$this->zacl->check_acl($resource, $role)) {
                redirect(base_url('util/permission_denied'));
            }
        } else {
            $resource = $controller . '/' . $method;
            if (!$this->zacl->check_acl($resource,$role)) {
                redirect(base_url('util/permission_denied'));
            }
        }
    }

    private function generateAclResources(){
        $aclModel=new Dealscount\Models\AclModel();
        //$aclModel->setAclResources($this->zacl->generateResource());
    }
}

// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */