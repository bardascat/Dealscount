<?php
/**
 * Feb 05 2014
 * @author Bardas Catalin @ bardascat@gmail.com
 */
class dashboard extends \CI_Controller {

    function __construct() {
        parent::__construct();
    }
    /**
     * @AclResource Admin Dashboard
     */
    public function index() {
        $this->load_view_admin('admin/dashboard/index.php');
    }


}

?>
