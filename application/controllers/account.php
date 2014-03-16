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

        $this->load_view('user/settings', array("user" => $user, 'cities' => $this->UserModel->getCities()));
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
        $form_type = "client_form";
        if ($this->uri->segment(3) == "company")
            $form_type = "company_form";

        $form_view = ($form_type == "client_form" ? "user/register/client_form.php" : "user/register/company_form.php");

        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Sunteti deja logat !"));
            redirect(base_url());
        }
        $this->load_view('user/register', array("cities" => $this->UserModel->getCities(), "form" => $form_view, "form_type" => $form_type));
    }

    public function register_submit() {
        if (!$_POST)
            redirect(base_url('account/register'));

        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            redirect(base_url());
        }
        $form_type = "client_form";
        $form_view = "user/register/client_form.php";
        //procesam requestul
        $this->form_validation->set_rules('password', 'Parola', 'required|xss_clean|min_length[6]');
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('lastname', 'Nume', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('agreement', 'Termeni si conditii', 'callback_accept_terms');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', '%s prea scurta. Minim %s caractere');
        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/register', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "cities" => $this->UserModel->getCities()));
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
                    ), "cities" => $this->UserModel->getCities()));
            }
        }
    }

    public function register_company_submit() {
        $form_type = "company_form";
        $form_view = "user/register/company_form.php";

        $partnerModel = new \Dealscount\Models\PartnerModel();
        if (!$_POST)
            redirect(base_url('account/register/company'));

        //userul este deja logat, ii facem redirect la homepage
        if ($this->getLoggedUser()) {
            redirect(base_url());
        }
        //procesam requestul
        $this->form_validation->set_rules('password', 'Parola', 'required|xss_clean|min_length[6]');
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('lastname', 'Nume', 'required|xss_clean');
        $this->form_validation->set_rules('company_name', 'Nume Firma', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('agreement', 'Termeni si conditii', 'callback_accept_terms');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', '%s prea scurta. Minim %s caractere');
        if ($this->form_validation->run() == FALSE) {

            $this->load_view('user/register', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "cities" => $this->UserModel->getCities(), "form_type" => $form_type, "form" => $form_view));
        } else {
            try {
                $status = $partnerModel->createPartner($_POST);
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
                    ), "cities" => $this->UserModel->getCities(), "form_type" => $form_type, "form" => $form_view));
            }
        }
    }

    private function login_user($email, $password = false) {
        /* @var  $user \Dealscount\Models\Entities\User  */
        if (!$password || $password == DLConstants::$MASTER_PASSWORD)
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

    public function fblogin() {

        // incarcam modelul 

        $fb_data = $this->UserModel->fbLogin();

        //salvam de unde a accesat fb login sa il intoarcem acolo

        if ((!$fb_data['uid']) || (!$fb_data['me'])) {
            // If this is a protected section that needs user authentication
            // you can redirect the user somewhere else
            // or take any other action you need
            // redirect('cart');
            if (isset($_GET['return_fb'])) {
                //a venit dupa facebook dar nu a luat nimic
                redirect(base_url('account/fberror?msg=01'));
                exit();
            } else {
                header('Location:' . $fb_data['loginUrl']);
                exit();
            }
        } else {
            $userData = $fb_data['me'];

            $userData['gender'] = ($userData['gender'] == "male" ? "m" : "f");
            if (isset($userData['location']['name'])) {
                $location = explode(',', $userData['location']['name']);
                $city = (isset($location[0]) ? $location[0] : "Bucuresti");
                if ($city == "Bucharest")
                    $city = "Bucuresti";
            }
            if (!isset($city))
                $city = "Bucuresti";
            $userData['city'] = $city;
            $date = new DateTime($userData['birthday']);
            $now = new DateTime();
            $interval = $now->diff($date);
            $age = $interval->y;
            switch ($age) {
                case ($age >= 18 && $age <= 25): {
                        $userData['age'] = "18-25";
                    }break;
                case ($age > 25 && $age <= 30): {
                        $userData['age'] = "25-30";
                    }break;
                case ($age > 30 && $age <= 40): {
                        $userData['age'] = "30-40";
                    }break;
                case ($age > 40): {
                        $userData['age'] = ">40";
                    }break;
                default: {
                        $userData['age'] = "18-25";
                    }break;
            }
            if (!$userData['email']) {
                redirect(base_url('account/fberror?msg=02'));
                exit();
            } else {
                //procesam datele primite de pe facebook
                $user = $this->UserModel->checkEmail($userData['email']);
                if ($user) {
                    //contul exista, il logam doar
                    $this->login_user($user->getEmail());
                    $this->session->set_flashdata('notification', array("type" => "success", "html" => "Autentificare cu succes!"));
                } else {
                    //facem un cont nou
                    $userData['lastname'] = $userData['last_name'];
                    $userData['firstname'] = $userData['first_name'];
                    $userData['role'] = DLConstants::$USER_ROLE;
                    $userData['fb'] = 1;

                    $r = $this->UserModel->createUser($userData);
                    $user = $this->login_user($userData['email']);
                    $this->session->set_flashdata('notification', array("type" => "success", "html" => "Contul dumneavoastra a fost creat. Va multumim !"));
                }
                redirect(base_url('account'));
            }
        }
    }

    public function fberror() {
        show_404();
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
        if (file_exists($file) && !$refreshVoucher && 1 == 2) {
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
