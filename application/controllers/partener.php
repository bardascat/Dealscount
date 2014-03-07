<?php

class partener extends \CI_Controller {

    private $OrderModel;
    private $OffersModel;
    private $PartnerModel;
    private $User;

    function __construct() {
        parent::__construct();
        $this->OrderModel = new Dealscount\Models\OrdersModel();
        $this->OffersModel = new \Dealscount\Models\OffersModel();
        $this->PartnerModel = new \Dealscount\Models\PartnerModel();
        DLConstants::pushJS('assets/js/jquery_ui/ui-1-10.js');
        DLConstants::pushJS('assets/js/timepicker/timepicker.js');
        DLConstants::pushCSS('assets/js/jquery_ui/ui-1-10.css');

        $this->User = $this->getLoggedUser(true);
        ;
        $this->load->library('form_validation');
    }

    /**
     * @AclResource "Partener: dashboard"
     */
    public function index() {
        $this->populate_form($this->User);
        $this->load_view('partner/dashboard', array("user" => $this->User));
    }

    /**
     * @AclResource "Partener: Lista Oferte"
     */
    public function oferte() {
        $this->load_view('partner/offers', array("user" => $this->User));
    }

    /**
     * @AclResource "Partener: Dezactiveaza oferta"
     */
    public function suspend_offer() {
        $id_offer = $this->uri->segment('3');
        $offer = $this->OffersModel->getOffer($id_offer);
        //in cazul in care userul incearca sa dezactiveze oferta unui alt user, dupa id oferta
        if ($offer->getCompany()->getId_user() != $this->User->getId_user()) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Cererea nu a pututut fi finalizata !"));
            redirect(base_url('partener/oferte'));
            exit();
        }
        $offer->setActive(0);
        $this->OffersModel->simpleUpdate($offer);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost suspendata"));
        redirect(base_url('partener/oferte'));
    }

    /**
     * @AclResource "Partener: Activeaza Oferta"
     */
    public function resume_offer() {
        $id_offer = $this->uri->segment('3');
        $offer = $this->OffersModel->getOffer($id_offer);
        if ($offer->getCompany()->getId_user() != $this->getLoggedUser()['id_user']) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Cererea nu a pututut fi finalizata !"));
            redirect(base_url('partener/oferte'));
            exit();
        }

        $offer->setActive(1);
        $this->OffersModel->simpleUpdate($offer);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost activata"));
        redirect(base_url('partener/oferte'));
    }

    /**
     * @AclResource "Partener: Newsletters"
     */
    public function newsletter() {
        $this->load_view('partner/newsletters', array("user" => $this->User));
    }

    /**
     * @AclResource "Partener: Programeaza Newsletter"
     */
    public function schedule_newsletter() {

        //procesam requestul
        $this->form_validation->set_rules('name', 'Nume newsletter', 'required|xss_clean|min_length[10]|max_length[50]');
        $this->form_validation->set_rules('scheduled', 'Data trimitere', 'callback_valid_date|xss_clean');
        $this->form_validation->set_rules('sex[]', 'Sex', 'required');
        $this->form_validation->set_rules('age[]', 'Varsta', 'required');
        $this->form_validation->set_rules('cities', 'Orase', 'required');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', 'Campul <b>%s</b> este obligatoriu sa aiba nimim %s caractere ');
        $this->form_validation->set_message('max_length', 'Campul <b>%s</b> este obligatoriu sa aiba maxim %s caractere ');
        if ($this->form_validation->run() == FALSE) {
            $this->load_view('partner/newsletters', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "user" => $this->User));
        } else {

            //forma este corecta, validam business logic
            $valid = $this->valid_newsletter();
            if ($valid) {
                $this->PartnerModel->createNewsletter($_POST, $this->User);
                $this->session->set_flashdata('notification', array("type" => "success", "html" => "Newsletterul a fost programat cu succes!"));
                redirect(base_url('partener/newsletter'));
            } else {

                exit('no validated');
            }
        }
    }

    /**
     * @AclResource "Partener: Cancel Newsletter"
     */
    public function cancel_newsletter() {
        $id_newsletter = $this->uri->segment(3);
        try {
            $this->PartnerModel->suspendNewsletter($id_newsletter, $this->User);
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Newsleterul a fost anulat cu succes !"));
        } catch (\Exception $e) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => $e->getMessage()));
        }
        redirect('partener/newsletter');
    }

    /**
     * @AclResource "Partener: Vizualizare Newsletter"
     */
    public function view_newsletter() {
        $id_newsletter = $this->uri->segment(3);
        try {
            $newsletter = $this->PartnerModel->getNewsletter($id_newsletter, $this->User);
        } catch (\Exception $e) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => $e->getMessage()));
            redirect('partener/newsletter');
        }

        echo 'Astept grafica pentru newsletter<br/>';
        echo $newsletter->getName();
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

    //validators
    public function valid_date() {
        $date = $_POST['scheduled'];
        $date = strtotime($date);
        if ($date === false) {
            $this->form_validation->set_message('valid_date', 'Data trimiterii newsletterului este incorecta');
            return false;
        } else {
            if ($date < strtotime(date("Y-m-d"))) {
                $this->form_validation->set_message('valid_date', 'Data trimiterii newsletterului este incorecta');
                return false;
            }
        }
        return true;
    }

    private function valid_newsletter() {
        return true;
    }

    //validators end
}

?>
