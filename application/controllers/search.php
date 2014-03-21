<?php

class search extends CI_Controller {

    private $OffersModel = null;

    public function __construct() {
        parent::__construct();
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    public function index() {
        if (!isset($_GET['q']) || !$_GET['q'])
            redirect(base_url());

        $offers = $this->OffersModel->searchOffers($_GET['q']);
        $data = array(
            "offers" => $offers
        );
        
        $this->load_view('index/landing', $data);
    }

}
