<?php

class landing extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $t=new Dealscount\Models\LandingModel();
        $this->load_view('index/landing',array("test"=>"pula"));
    }

}
