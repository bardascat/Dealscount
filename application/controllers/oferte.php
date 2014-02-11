<?php

class oferte extends CI_Controller {

    private $OffersModel = null;

    public function __construct() {
        parent::__construct();
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    public function index(){
        echo 'index';
    }
    public function view(){
        $slug=$this->uri->segment(2);
        $offer=$this->OffersModel->getOfferBySlug($slug);
        if(!$offer)
            exit('Page not found');
        
        $data=array(
            "offer"=>$offer
        );    
        $this->load_view('oferte/view', $data);
    }
  

}
