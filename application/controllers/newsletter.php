<?php

class newsletter extends \CI_Controller {

    private $OffersModel;
    private $User;

    function __construct() {
        parent::__construct();
        $this->OffersModel = new \Dealscount\Models\OffersModel();
        $this->load->library('user_agent');
        $this->User = $this->getLoggedUser(true);
        $this->load->library('form_validation');
    }

    public function index() {
        $offers = $this->OffersModel->getNewsletterOffers();
        $this->load->view('newsletter/general', array("offers" => $offers));
    }

    public function send_newsletter() {
        $email = 'bardas.catalin@yahoo.com';

        $body = file_get_contents(base_url('newsletter'));
        $subject = "Test newsletter";
        \NeoMail::genericMail($body, $subject, $email);
        echo 'done';
    }

}

?>
