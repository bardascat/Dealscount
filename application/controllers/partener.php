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
        
        $this->User = $this->getLoggedUser(true);;
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
        $this->load_view('partner/newsletters', array("user" => $this->User));
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
