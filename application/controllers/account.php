<?php

use NeoMvc\Models as Models;
use NeoMvc\Models\UserModel;

class account extends \CI_Controller {

    private $UserModel;

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->UserModel = new \Dealscount\Models\UserModel();
    }

    public function index() {
        $t = new Dealscount\Models\LandingModel();
        $this->load_view('index/landing', array("test" => "pula"));
    }

    public function login_submit() {

        if(get_cookie('dl_loggedin')){
            
            redirect('/');
            exit();
        }
        
        $this->form_validation->set_rules('password', 'Parola', 'required|min_length[1]|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_message('min_length', '%s: Minim 1 caractere');

        if ($this->form_validation->run() == FALSE) {
            $this->load_view('index/landing');
        } else {
            $user = $this->login_user($this->input->post('email'), $this->input->post('password'));

            if (!$user) {
                $response = array("type" => "error", "action" => "login", "msg" => "Datele introduse sunt incorecte");
            } else {
                $response = array("type" => "success", "action" => "login", "data" => array("email" => $user->getEmail(), "nume" => $user->getLastname(), "prenume" => $user->getFirstname()));
            }

            print_r($_COOKIE);
            print_r(get_cookie('testACS'));
            exit('done');
        }
    }

    private function login_user($email, $password = false) {
        /* @var   $user User  */
        if (!$password)
            $user = $this->UserModel->checkEmail($email);
        else
            $user = $this->UserModel->find_user($email, sha1($password));

        if ($user) {
            $cookie = array('id_user' => $user->getId_user(), 'email' => $user->getEmail(), 'access_level' => $user->getAccessLevel());
            $cookie = array(
                'name' => 'dl_loggedin',
                'value' => serialize($cookie),
                'expire' => time()*3600*24*365,
                'path'=>"/"
            );
            set_cookie($cookie);
            return $user;
        }
        return false;
    }

}

?>
