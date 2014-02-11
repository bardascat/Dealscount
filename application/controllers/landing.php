<?php

class landing extends CI_Controller {

    private $OffersModel = null;

    public function __construct() {
        parent::__construct();
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    public function index() {
        $offers = $this->OffersModel->getActiveOffers();
        $data = array(
            "offers" => $offers
        );
        if (!$offers)
            $data['no_data'] = "Momentan nu sunt oferte adaugate";
        
        $this->load_view('index/landing', $data);
    }

}
