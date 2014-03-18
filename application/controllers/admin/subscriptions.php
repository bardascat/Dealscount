<?php
/**
 * @author Bardas Catalin @ bardascat@gmail.com
 */
class subscriptions extends \CI_Controller {

    private $PartnerModel;

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->PartnerModel = new \Dealscount\Models\PartnerModel();
    }

    /**
     * @AclResource Admin Abonamente
     */
    public function index() {
        $subscriptions = $this->PartnerModel->getSubscriptions();
        $data['subscriptions'] = $subscriptions;

        if ($this->input->get('id_option')) {
            $subscription = $this->PartnerModel->getSubscriptionOption($this->input->get('id_option'));
            $data['subscription'] = $subscription;
            $this->populate_form($subscription);
        }
        $this->load_view_admin('admin/subscriptions/index.php', $data);
    }

    public function update_option() {
        $this->PartnerModel->updateOption($_POST);
        $this->session->set_flashdata('notification', array("type" => "success", "html" =>"Modificarile au fost salvate"));
        redirect($this->agent->referrer());
    }

}

?>
