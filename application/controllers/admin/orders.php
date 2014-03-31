<?php

/**

 * @author Bardas Catalin

 */
class orders extends CI_Controller {

    private $OrdersModel;
    private $OffersModel;
    private $CompaniesModel;

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->view->setPage_name("Lista comenzi");
        $this->OffersModel = new \Dealscount\Models\OffersModel();
        $this->OrdersModel = new Dealscount\Models\OrdersModel();
        $this->CompaniesModel = new Dealscount\Models\PartnerModel();
    }

    /**
     * @AclResource Admin: Comenzi: Lista Comenzi
     */
    public function orders_list() {
        if ($this->input->get('page'))
            $page = $this->input->get('page');
        else
            $page = 1;

        $orders = $this->OrdersModel->PaginateOrders($page);
        $data = array(
            "orders" => $orders,
            'companies' => $this->CompaniesModel->getCompaniesList(),
        );
        $this->load_view_admin('admin/orders/orders_list', $data);
    }

    public function searchOrders() {
        $searchQuery = $_GET['search'];

        $orders = $this->OrdersModel->searchOrders($_GET);
        $data = array(
            "orders" => $orders,
            'companies' => $this->CompaniesModel->getCompaniesList()
        );
        $this->load_view_admin('admin/orders/orders_list', $data);
    }

    /**
     * @AclResource Admin: Comenzi: Editeaza Comanda
     */
    public function edit_order() {

        if ($this->uri->segment(4)) {
            $order = $this->OrdersModel->getOrderByPk($this->uri->segment(4));
            $this->populate_form($order);
            $data = array(
                "order" => $order
            );
            $this->load_view_admin('admin/orders/edit_order', $data);
        }
    }

    public function editOrderDo() {
        redirect($this->agent->referrer());
    }

    /**
     * Adauga la comanda exista un item
     * @AclResource Admin: Comenzi: Adauga Voucher in comanda
     */
    public function addOrderItem() {
        if (isset($_POST['id_item'])) {

            $this->OrdersModel->addOrderItem($_POST);
            echo "<b>Voucherul a fost adaugat cu success<b/>";
        } else
            exit("page not found");
    }

    /**
     * @param type $id_order_item
     */
    public function editVouchersPopup() {
        if ($this->uri->segment(4)) {
            $orderItem = $this->uri->segment(4);

            $orderItem = $this->OrdersModel->getOrderItem($orderItem);
            if (!$orderItem) {
                exit("Eroare: 1:11 - Item-ul nu a fost gasit !");
            }
            $data = array("orderItem" => $orderItem);
            $this->load_view_admin_popup('popups/editOrderItemVouchers', $data);
        }
    }

    /**
     * @AclResource Admin: Comenzi: Modifica Voucher
     */
    public function updateVoucher() {
        $id_voucher = $_POST['id_voucher'];
        $recipient_name = $_POST['recipient_name'];
        $this->OrdersModel->updateVoucher($id_voucher, $recipient_name);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Numele benficiarului a fost salvat"));
        redirect($this->agent->referrer());
    }

    /**
     * Metoda folosita de admini pentru a adauga un voucher suplimentar la o comanda.
     */
    public function addVoucher() {
        $this->OrdersModel->addVoucher($_POST);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Voucherul a fost creat"));
        redirect($this->agent->referrer());
    }

    /**
     * @AclResource Admin: Comenzi: Sterge Voucher
     */
    public function deleteVoucher() {
        $this->OrdersModel->deleteVoucher($_POST['id_voucher']);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Voucherul a fost sters"));
        redirect($this->agent->referrer());
    }

    public function updateOrderItemQuantity() {
        if ($this->input->post("id_orderItem") && $this->input->post("quantity")) {
            $this->OrdersModel->updateOrderItemQuantity($_POST);
            $notification = array("type" => "success", "html" => "Cantitatea a fost actualizata");
            $this->session->set_flashdata('notification', $notification);
            redirect($this->agent->referrer());
        }
    }

    public function addOrderOfferPopup() {
        $data['id_item'] = $this->uri->segment(4);
        $data['quantity'] = $this->uri->segment(5);
        $data['data'] = $data;
        $this->load_view_admin_popup('popups/addOrderItem', $data);
    }

    public function getOrderByCode() {
        $code = $this->input->post('code');
        $order = $this->OrdersModel->getOrderByCode($code);
        if (!$order) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Comanda cu acest cod nu exista"));
            redirect($this->agent->referrer());
        } else {
            $_POST['id_order'] = $order->getId_order();
            $text = "Client: " . $order->getUser()->getFirstname() . ' ' . $order->getUser()->getLastname();
            $text.='<br/> Total Plata: ' . $order->getTotal();
            $text.='<br/> Data Comanda: ' . $order->getOrderedOn();
            $data = array(
                'data' => $_POST,
                'order' => $order
            );
        }
        $this->load_view_admin_popup('popups/addOrderItem', $data);
    }

    private function validateAddProduct($data) {
        $errors = false;
        $variant = false;

        $item = $this->ProductsModel->get_product($data['id_item']);
        $productVariants = $item->getProductVariants();

//verifficam daca userul si-a ales varianta
        if (count($productVariants) > 0) {
            $choosedAttributes = false;

            if (!isset($data['product_attributes']) || count($data['product_attributes']) < 1)
                $errors.= "<br/>Va rugam alegeti detaliile produsului<br/>";
            else {
                $variant = $this->ProductsModel->validateVariant($data['product_attributes'], $data['id_item']);
                if (!$variant) {
                    $errors.= "<br/>Alegeti detaliile produsului<br/>";
                }
            }
        }

        if (!$data['quantity'])
            $errors.= "<br/>Introduceti cantitatea <br/>";

        if (!$errors)
            return array("status" => "success", "variant" => $variant);
        else
            return array("status" => "error", "msg" => $errors);
    }

    public function setOrderItemStatus($params) {
        if (isset($params[0])) {
            $this->OrdersModel->setOrderItemStatus($params);
            Session::set_flash_data('form_ok', 'Produsul a fost actulizat');
            header('Location:' . $this->getRefPage());
            exit();
        }
    }

    /**
     * @AclResource Admin: Comenzi: Sterge Voucher
     */
    public function deleteOrderItem() {
        if ($this->uri->segment(4)) {
            $this->OrdersModel->deleteOrderItem($this->uri->segment(4));
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Voucherele au fost sterse din comanda"));
        }

        redirect($this->agent->referrer());
    }

    /**
     * @AclResource Admin: Comenzi: Sterge Comanda
     */
    public function delete_order() {
        if ($this->uri->segment(4)) {
            $id_order = $this->uri->segment(4);
            $this->OrdersModel->deleteOrder($id_order);
            $notification = array("type" => "success", "html" => "Comanda a fost stearsa cu succes");
            $this->session->set_flashdata('notification', $notification);
            redirect($this->agent->referrer());
        }
    }

    public function downloadInvoice($params) {
        if (isset($params[0])) {

            $ordersModel = new Models\OrdersModel();
            $order = $ordersModel->getOrderByPk($params[0]);

            $filename = $order->getInvoice()->getSeries();
            $filename.=$order->getInvoice()->getNumber() . '.pdf';
            $file = "application_uploads/invoices/" . $filename;
            if (file_exists($file && !$returnFile)) {
                header('Content-disposition: attachment; filename=' . $filename);
                header('Content-type: application/pdf');
                readfile($file);
            } else {
                $file = $this->generateInvoice($order);
                header('Content-disposition: attachment; filename=' . $filename);
                header('Content-type: application/pdf');
                readfile($file);
            }
            if (!$order) {
                exit("<h2>Comanda invalida</h2>");
            }
        } else
            exit("eroare");
    }

    public function generateInvoice($order) {

        $filename = $order->getInvoice()->getSeries();
        $filename.=$order->getInvoice()->getNumber() . '.pdf';
        $file = "application_uploads/invoices/" . $filename;

        ob_start();
        require_once('views/pdf/invoice.php');
        $invoiceHtml = ob_get_clean();
        require_once("NeoMvc/Libs/mpdf54/mpdf.php");
        $mpdf = new \mPDF('c', "A4", '', '', 2, 2, 2, 2, 0, 0);
        $stylesheet = "body { font-family:Tahoma}";
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

        $mpdf->WriteHTML($invoiceHtml);
        $mpdf->Output($file);
        return $file;
    }

    private function validate_order() {

        $rules = array(
            "shipping_name" => array(
                "require" => true,
            ),
            "shipping_cnp" => array(
                "require" => true,
            ),
            "shipping_city" => array(
                "require" => true,
            ),
            "shipping_district_code" => array(
                "require" => true,
            ),
            "shipping_address" => array(
                "require" => true,
            ),
            "total" => array(
                "require" => true,
                "float" => true,
            ),
            "shipping_cost" => array(
                "require" => true,
                "float" => true,
            ),
            "orderedOn" => array(
                "require" => true
            ),
        );
        $messages = array(
            "shipping_name" => array(
                "require" => "Introduceti Numele destinatarului",
            ),
            "shipping_cnp" => array(
                "require" => "Introduceti CNP-ul destinatarului",
            ),
            "shipping_city" => array("require" => "Introduceti orasul destinatarului"),
            "shipping_district_code" => array("require" => "Introduceti judetul destinatarului"),
            "shipping_address" => array("require" => "Introduceti adresa destinatarului"),
            "total" => array("require" => "Totalul de plata nu poate fi null"),
            "shipping_cost" => array("require" => "Costul de transport nu poate fi null")
        );

        $objValidator = new \NeoMvc\Libs\Validator($rules, $messages);


        return $objValidator;
    }

}
