<?php


class dashboard extends \CI_Controller {

    function __construct() {
        parent::__construct();
        parent::setAccessLevel(DLConstants::$ADMIN_LEVEL);       
    }

    public function index() {
        $this->load_view_admin('admin/dashboard/index.php');
    }


}

?>
