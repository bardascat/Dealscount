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
        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            redirect(base_url());
        }

        //procesam requestul
        $this->form_validation->set_rules('password', 'parola', 'required|xss_clean');
        $this->form_validation->set_rules('username', 'utilizator', 'required');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');

        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/login', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
            )));
        } else {
            $user = $this->login_user($this->input->post('username'), $this->input->post('password'));
            if (!$user) {
                //datele introduse nu sunt corecte
                $this->load_view('user/login', array("notification" => array(
                        "type" => "form_notification",
                        "message" => "Datele introduse sunt incorecte",
                        "cssClass" => "error"
                )));
            } else {
                //userul a fost logat
                //$response = array("type" => "success", "action" => "login", "data" => array("email" => $user->getEmail(), "nume" => $user->getLastname(), "prenume" => $user->getFirstname()));
                redirect(base_url());
            }
        }
    }

    private function login_user($email, $password = false) {
        /* @var   $user User  */
        if (!$password)
            $user = $this->UserModel->checkEmail($email);
        else
            $user = $this->UserModel->find_user($email, md5($password));

        if ($user) {
            $cookie = array('id_user' => $user->getId_user(), 'email' => $user->getEmail(), 'access_level' => $user->getAccessLevel(), "gender" => $user->getGender());
            $cookie = array(
                'name' => 'dl_loggedin',
                'value' => serialize($cookie),
                'expire' => time() + 10 * 365 * 24 * 60 * 60,
                'path' => "/"
            );
            set_cookie($cookie);
            return $user;
        }
        return false;
    }

    public function logout() {
        $cookie = array(
            'name' => 'dl_loggedin',
            'value' => '',
            'expire' => time() - 365,
            'path' => "/"
        );
        set_cookie($cookie);
        redirect(base_url());
    }

}

?>
