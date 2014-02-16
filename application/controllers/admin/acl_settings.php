<?php

/**
 * Feb 05 2014
 * @author Bardas Catalin @ bardascat@gmail.com
 */
class acl_settings extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->setAccessLevel(DLConstants::$ADMIN_LEVEL);
    }

    public function index() {
        $roles = $this->UserModel->getRoles();
        $data = array(
            "roles" => $roles
        );
        $this->load_view_admin('admin/acl_settings/acl', $data);
    }

    public function load_acl() {
        $id_role = $this->input->post("role");
        if (!$id_role)
            redirect(base_url('admin/acl_settings'));

        $aclResources = $this->UserModel->getAclResources();
        $roles = $this->UserModel->getRoles();
        $data = array(
            "roles" => $roles,
            "selected_role" => $id_role,
            "aclResources" => $aclResources
        );

        $this->load_view_admin('admin/acl_settings/acl', $data);
    }

}

?>
