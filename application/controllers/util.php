<?php

class util extends \CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function permission_denied() {
        $this->load_view('util/permission_denied');
    }

}

?>
