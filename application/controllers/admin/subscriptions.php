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
        $subscriptions = $this->PartnerModel->getSubscriptionOptions();
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
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Modificarile au fost salvate"));
        redirect($this->agent->referrer());
    }

    /**
     * @AclResource Admin Comnezi Optiuni
     */
    public function orders() {
        if ($this->input->get('page'))
            $page = $this->input->get('page');
        else
            $page = 1;
        $data = array();
        $orders = $this->PartnerModel->getSubscriptionOptionOrders($page);
        $data['orders'] = $orders;
        $this->load_view_admin('admin/subscriptions/orders.php', $data);
    }

    /**
     * @AclResource Admin Sterge Comanda Optiune    
     */
    public function delete_order() {
        $order_code = $this->uri->segment(4);
        $this->PartnerModel->deleteSubscriptionOptionOrders($order_code);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Comanda a fost stearsa"));
        redirect($this->agent->referrer());
    }

    /**
     * @AclResource Admin Confirma Comanda Optiune 
     */
    public function confirm_order() {
        $order_code = $this->uri->segment(4);
        $this->PartnerModel->confirmSubscriptionOptionOrder($order_code);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Comanda a fost confirmata cu success"));
        redirect($this->agent->referrer());
    }

    public function searchOrder() {
        $searchQuery = $_GET['search'];
        if (strlen($searchQuery) < 2) {
            redirect(base_url('admin/subscriptions/orders'));
        }
        $data = array();
        $orders = $this->PartnerModel->searchSubscriptionOptionOrders($searchQuery);
        $data['orders'] = $orders;
        $this->load_view_admin('admin/subscriptions/orders.php', $data);
    }

}

?>
