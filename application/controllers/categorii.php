<?php

class categorii extends CI_Controller {

    private $OffersModel = null;

    public function __construct() {
        parent::__construct();
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    public function load_categories() {
        echo $this->uri->segment('3');
        
    }

}
