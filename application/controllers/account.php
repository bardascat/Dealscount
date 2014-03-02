<?php

class account extends \CI_Controller {

    private $OrderModel;

    function __construct() {
        parent::__construct();
        if ($this->getLoggedUser()['role'] == DLConstants::$PARTNER_ROLE) {
            redirect(base_url('partener'));
        }
        $this->OrderModel = new Dealscount\Models\OrdersModel();
        $this->load->library('form_validation');
    }

    /**
     * @AclResource "User: Date cont"
     */
    public function index() {
        $user = $this->getLoggedUser(true);
        $this->populate_form($user);

        $this->load_view('user/settings', array("user" => $user));
    }

    /**
     * @AclResource "User: Lista Comenzi"
     */
    public function orders() {
        $user = $this->getLoggedUser(true);
        $this->view->setPage_name("Cupoanele tale");

        if ($this->input->get("voucher"))
            $orders = $this->OrderModel->searchVouchers($this->input->get("voucher"), $this->getLoggedUser()['id_user']);
        else
            $orders = $user->getOrders();

        $data = array(
            "user" => $user,
            "orders" => $orders
        );

        $this->load_view('user/orders', $data);
    }

    public function change_settings() {
        $user = $this->getLoggedUser(true);
        if (!$_POST)
            redirect(base_url('account'));
       
        $this->populate_form($user);

        //procesam requestul
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('lastname', 'Nume', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');

        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/settings', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "user" => $user));
        } else {
            try {
                $status = $this->UserModel->updateUser($_POST);
            } catch (\Exception $e) {
                $this->load_view('user/settings', array("notification" => array(
                        "type" => "form_notification",
                        "message" => $e->getMessage(),
                        "cssClass" => "error"
                    ), "user" => $user));
            }
        }

        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Modificarile au fost salvate cu success"));
        redirect(base_url('account'));
    }

    public function change_password() {
        $user = $this->getLoggedUser(true);
        if (!$_POST)
            redirect(base_url('account'));
        $this->populate_form($user);

        //procesam requestul
        $this->form_validation->set_rules('new_password', 'Parola noua', 'required|xss_clean');
        $this->form_validation->set_rules('old_password', 'Parola veche', 'required|xss_clean');
        $this->form_validation->set_rules('old_password', 'Parola veche', 'callback_password_match');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', '%s prea scurta. Minim %s caractere');

        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/settings', array("notification_password" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "user" => $user));
        } else {
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Parola a fost resetata"));
            $status = $this->UserModel->updatePassword($_POST);
        }
        redirect(base_url('account#change_password'));
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
                redirect(base_url('account'));
            }
        }
    }

    public function register() {
        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Sunteti deja logat !"));
            redirect(base_url());
        }
        $this->load_view('user/register');
    }

    public function register_submit() {
        if (!$_POST)
            redirect(base_url('account/register'));

        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            redirect(base_url());
        }
        //procesam requestul
        $this->form_validation->set_rules('password', 'Parola', 'required|xss_clean|min_length[6]');
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('name', 'Nume', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('agreement', 'Termeni si conditii', 'callback_accept_terms');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', '%s prea scurta. Minim %s caractere');
        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/register', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
            )));
        } else {
            try {
                $status = $this->UserModel->createUser($_POST);
                //logam utilizatorul
                if ($status) {
                    $this->login_user($status->getEmail());
                    $this->session->set_flashdata('notification', array("type" => "success", "html" => "Contul dumneavoastra a fost creat. Va multumim !"));
                    redirect(base_url('account'));
                }
            } catch (\Exception $e) {
                $this->load_view('user/register', array("notification" => array(
                        "type" => "form_notification",
                        "message" => $e->getMessage(),
                        "cssClass" => "error"
                )));
            }
        }
    }

    private function login_user($email, $password = false) {
        /* @var  $user \Dealscount\Models\Entities\User  */
        if (!$password)
            $user = $this->UserModel->checkEmail($email);
        else
            $user = $this->UserModel->find_user($email, sha1($password));

        if ($user) {
            $cookie = array('id_user' => $user->getId_user(), 'email' => $user->getEmail(), 'role' => $user->getAclRole()->getName(), "gender" => $user->getGender(), "firstname" => $user->getFirstname(), "lastname" => $user->getLastname(), "username" => $user->getUsername());
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
            show_404();

        $order = $this->OrderModel->getOrderByCode($order_code);
        //daca nu exista comanda, sau trimite prin get codul comenzii unui alt utilizator
        if (!$order || $order->getUser()->getId_user() != $this->getLoggedUser()['id_user'])
            show_404();

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
     * @param: $params este un array cu index 0 id-ul orderItem-ului care contine lista de vouchere
     * Genereaza un popup cu lista voucherelor
     * @AclResource User: Descarca Vouchere
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
     * @AclResource User: Descarca Voucher
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

    public function accept_terms() {
        if (isset($_POST['agreement']))
            return true;
        $this->form_validation->set_message('accept_terms', 'Va rugam sa acceptati termenii si conditiile');
        return false;
    }

    public function password_match() {
        $old_password = $_POST['old_password'];
        if (sha1($old_password) != $this->getLoggedUser(true)->getPassword()) {
            $this->form_validation->set_message('password_match', 'Parola veche este incorecta');
            return false;
        } else
            return true;
    }

}

?>
