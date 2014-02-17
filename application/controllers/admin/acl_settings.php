<?php

/**
 * Feb 05 2014
 * @author Bardas Catalin @ bardascat@gmail.com
 */
class acl_settings extends CI_Controller {
    private $AclModel;
    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->AclModel=new Dealscount\Models\AclModel();
    }

    /**
     * @AclResource Admin: Permisiuni: Lista Permisiuni
     */
    public function index() {
        $roles = $this->AclModel->getRoles();
        $data = array(
            "roles" => $roles
        );
        $this->load_view_admin('admin/acl_settings/acl', $data);
    }

    /**
     * @AclResource Admin: Permisiuni: Setare Permisiuni
     */
    public function load_acl() {
        $id_role = $this->input->get("role");
        if (!$id_role)
            redirect(base_url('admin/acl_settings'));

        $aclResources = $this->AclModel->getAclResourcesForRole($id_role);
        $roles = $this->AclModel->getRoles();
        $data = array(
            "roles" => $roles,
            "selected_role" => $id_role,
            "aclResources" => $aclResources
        );

        $this->load_view_admin('admin/acl_settings/acl', $data);
    }

    /**
     * @AclResource Admin: Permisiuni: Salvare permisiuni
     */
    public function set_acl() {
        $id_role = $this->input->post("id_role");
        $this->AclModel->setRoleRules($id_role, (isset($_POST['acl_rule']) ? $_POST['acl_rule'] : false));
        $url = base_url('admin/acl_settings/load_acl') . '?role=' . $id_role;
        header('Location:' . $url);
        exit();
    }

}

?>
