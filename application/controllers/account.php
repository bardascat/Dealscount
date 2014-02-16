<?php

class account extends \CI_Controller {

    private $OrderModel;

    function __construct() {
        parent::__construct();
        $this->OrderModel = new Dealscount\Models\OrdersModel();
        $this->load->library('form_validation');
    }

    public function index() {
        $t = new Dealscount\Models\LandingModel();
        $this->load_view('index/landing', array("test" => "pula"));
    }

    
    public function login_submit() {

        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            redirect(base_url());
        }
        //procesam requestul
        $this->form_validation->set_rules('password', 'parola', 'required|xss_clean');
        $this->form_validation->set_rules('username', 'utilizator', 'required');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');

        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/login', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
            )));
        } else {
            $user = $this->login_user($this->input->post('username'), $this->input->post('password'));
            if (!$user) {
                //datele introduse nu sunt corecte
                $this->load_view('user/login', array("notification" => array(
                        "type" => "form_notification",
                        "message" => "Datele introduse sunt incorecte",
                        "cssClass" => "error"
                )));
            } else {
                //userul a fost logat
                //$response = array("type" => "success", "action" => "login", "data" => array("email" => $user->getEmail(), "nume" => $user->getLastname(), "prenume" => $user->getFirstname()));
                redirect(base_url());
            }
        }
    }

    private function login_user($email, $password = false) {
        /* @var   $user User  */
        if (!$password)
            $user = $this->UserModel->checkEmail($email);
        else
            $user = $this->UserModel->find_user($email, md5($password));

        if ($user) {
            $cookie = array('id_user' => $user->getId_user(), 'email' => $user->getEmail(), 'access_level' => $user->getAccessLevel(), "gender" => $user->getGender(), "firstname" => $user->getFirstname(), "lastname" => $user->getLastname(), "username" => $user->getUsername());
            $cookie = array(
                'name' => 'dl_loggedin',
                'value' => serialize($cookie),
                'expire' => time() + 10 * 365 * 24 * 60 * 60,
                'path' => "/"
            );
            set_cookie($cookie);
            return $user;
        }
        return false;
    }

    /**
     * @AclResource "User: Finalizare comanda"
     */
    public function finalizare() {

        $order_code = $this->input->get("code");
        if (!$order_code)
            exit("page not found");

        $order = $this->OrderModel->getOrderByCode($order_code);
        if (!$order)
            exit("page not found");

        $data = array(
            "order" => $order
        );
        $this->load_view('user/finalizare', $data);
    }

    public function logout() {

        $cookie = array(
            'name' => 'dl_loggedin',
            'value' => '',
            'expire' => time() - 365,
            'path' => "/"
        );
        set_cookie($cookie);
        redirect(base_url());
    }

    /**
     * @AclResource "User: Lista Comenzi"
     */
    public function orders() {
        $user = $this->getLoggedUser(true);
        $this->view->setPage_name("Cupoanele tale");
        $orders = $user->getOrders();
        $data = array(
            "user" => $user,
            "orders" => $orders
        );

        $this->load_view('user/orders', $data);
    }

    /**
     * @param: $params este un array cu index 0 id-ul orderItem-ului care contine lista de vouchere
     * Genereaza un popup cu lista voucherelor
     * @AclResource User:Descarca Vouchere
     */
    public function downloadVouchers($params) {
        $this->initHeaderFilesPopup();
        if (!isset($params[0])) {
            exit("Page not found");
        }
        $ordersModel = new Models\OrdersModel();
        $orderItem = $ordersModel->getOrderItem($params[0]);
        if (!$orderItem)
            exit("Page not found");
        $this->view->orderItem = $orderItem;
        $this->view->render("popups/vouchersList", false, "popup");
    }

    /**
     * @AclResource User:Descarca Voucher
     * @param $voucher[0] contine id-ul voucherului ce urmeaza a fi downloadat
     */
    public function download_voucher() {
        $id_voucher = $this->uri->segment('3');

        $refreshVoucher = false;
        if ($this->uri->segment('4'))
            $refreshVoucher = true;


        $order = $this->OrderModel->getVoucherOrder($id_voucher);

        if (!$order) {
            exit("<h2>Acest voucher nu exista</h2>");
        }

        $file = "application_uploads/vouchers/" . $order->getId_order() . '/' . $id_voucher . '.pdf';
        if (file_exists($file) && !$refreshVoucher) {
            header('Content-disposition: attachment; filename=voucher_' . $id_voucher . '.pdf');
            header('Content-type: application/pdf');
            readfile($file);
        } else {
            // daca se fac modificari la voucher, trebuie sa il regeneram
            $voucher = $this->OrderModel->getVoucherByPk($id_voucher);
            $orderItem = $voucher->getOrderItem();
            $offer = $orderItem->getItem();
            $company = $offer->getCompany();
            $companyDetails = $company->getCompanyDetails();

            ob_start();
            require_once('application/views/popups/voucher.php');
            $voucherHtml = ob_get_clean();
            require_once("application/libraries/mpdf54/mpdf.php");
            $mpdf = new \mPDF('utf-8', array(190, 536), '', 'Arial', 2, 2, 2, 2, 2, 2);
            $mpdf->WriteHTML(utf8_encode($voucherHtml));

            if (!is_dir("application_uploads/vouchers/" . $order->getId_order()))
                mkdir("application_uploads/vouchers/" . $order->getId_order(), 0777);
            $mpdf->Output($file);
            header('Content-disposition: attachment; filename=voucher_' . $id_voucher . '.pdf');
            header('Content-type: application/pdf');
            readfile($file);
        }
    }

}

?>
