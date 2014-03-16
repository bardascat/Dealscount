<?php

/**
 *
 * @author Neo aka Bardas Catalin
 */
class neocart extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->NeoCartModel = new Dealscount\Models\NeoCartModel();
    }

    public function index() {
        $cart = $this->NeoCartModel->getCart(self::getCartHash());
        $this->load_view('cart/index', array("neoCart" => $cart));
    }

    public function update_quantity() {
        if (!isset($_POST['cartItem']))
            exit("Page not found");

        $this->NeoCartModel->updateQuantity($_POST);
        
        redirect($this->agent->referrer());
    }

    public function deleteCartItem() {
        $this->NeoCartModel->deleteCartItem($_POST['cartItem']);
        redirect($this->agent->referrer());
    }

    public function add_to_cart() {
        $hash = $this->getCartHash();
        $cart = $this->NeoCartModel->getCart($hash);

        //hai sa bagam produsul in shopping cart
        $this->NeoCartModel->addToCart($_POST, $cart);

        $notification = array("type" => "success", "html" => "Produsul a fost adăugat în coș");
        $this->session->set_flashdata('notification', $notification);
        redirect($this->agent->referrer());
    }

    /**
     * @AclResource User: Genereaza Comanda
     */
    public function process_payment() {
        $this->load->library('form_validation');
        $cart = $this->NeoCartModel->getCart(CI_Controller::getCartHash());

        $errors = $this->validatePaymentProcess($_POST, $cart);
        if ($errors) {
            $notification = array("type" => "error", "html" => "Va rugam completati toate datele");
            $this->session->set_flashdata('notification', $notification);
            $this->session->set_flashdata('process_payment_errors', $errors);
            redirect(base_url('cart'));
        }

        switch ($_POST['payment_method']) {
            case "CARD": {
                    // $this->processCardPayment();
                }break;
            case "OP": {
                    // $this->processOpPayment();
                }break;
            case "RAMBURS": {
                    //  $this->processRambursPayment();
                }break;
            case "FREE": {
                    $this->processFreePayment();
                }break;
        }
    }

    private function processFreePayment() {

        /* @var $order Entity\Order */
        $order = $this->NeoCartModel->insertOrder($this->getLoggedUser(true), $_POST);
     

        $email = $order->getUser()->getEmail();

        ob_start();
        require_once("application/views/mailMessages/freeOrder.php");
        $body = ob_get_clean();
        $subject = "Comanda " . $order->getOrderNumber() . DLConstants::$WEBSITE_COMMERCIAL_NAME;

        /**
         * Nu mai generam nimic, serverul e prea praf si dureaza mult finalizarea comenzii.
         * Poate un request ajax in pagina de thankyou
         * 
        $vouchers = $this->NeoCartModel->generateVouchers($order);
        NeoMail::genericMailAttach($body, $subject, $email, $vouchers);
        //$this->informOwner($order);
        */
        redirect(base_url('account/finalizare?type=free&code=' . $order->getOrderNumber()));
        exit();
    }

    private function processOpPayment() {
        /* @var $order Entity\Order */
        $order = $this->NeoCartModel->insertOrder($this->logged_user['orm'], $_POST);

        $email = $order->getUser()->getEmail();
        $vouchers = $this->NeoCartModel->generateVouchers($order);

        ob_start();
        require_once("mailMessages/transferBancar.php");
        $body = ob_get_clean();
        $subject = "Confirmare comandă nr. " . $order->getOrderNumber();

        if ($vouchers)
            NeoMail::getInstance()->genericMailAttach($body, $subject, $email, $vouchers);
        else
            NeoMail::getInstance()->genericMail($body, $subject, $email);

        $this->informOwner($order);
        header('Location:' . URL . 'cont/finalizare_op?code=' . $order->getOrderNumber());
        exit();
    }

    private function processRambursPayment() {
        /* @var $order Entity\Order */
        $order = $this->NeoCartModel->insertOrder($this->logged_user['orm'], $_POST);

        $email = $order->getUser()->getEmail();
        $vouchers = $this->NeoCartModel->generateVouchers($order);

        ob_start();
        require_once("mailMessages/rambursConfirm.php");
        $body = ob_get_clean();
        $subject = "Confirmare comandă nr. " . $order->getOrderNumber();

        if ($vouchers)
            NeoMail::getInstance()->genericMailAttach($body, $subject, $email, $vouchers);
        else
            NeoMail::getInstance()->genericMail($body, $subject, $email);

        $this->informOwner($order);
        header('Location:' . URL . 'cont/finalizare_ramburs?code=' . $order->getOrderNumber());
        exit();
    }

    //neadaptata
    private function processCardPayment() {

        $order = $this->NeoCartModel->insertOrder($this->logged_user['orm'], $_POST);
       
        require_once 'NeoMvc/Libs/Mobilpay/Payment/Request/Abstract.php';
        require_once 'NeoMvc/Libs//Mobilpay/Payment/Request/Card.php';
        require_once 'NeoMvc/Libs//Mobilpay/Payment/Invoice.php';
        require_once 'NeoMvc/Libs//Mobilpay/Payment/Address.php';


        // $paymentUrl = 'http://sandboxsecure.mobilpay.ro';
        $paymentUrl = 'https://secure.mobilPay.ro';
        $x509FilePath = 'NeoMvc/Libs/Mobilpay/public.cer';
        try {
            srand((double) microtime() * 1000000);
            $objPmReqCard = new \Mobilpay_Payment_Request_Card();
            $objPmReqCard->signature = 'T64Q-JUXS-SQB4-H5QQ-1DBJ';
            $objPmReqCard->orderId = $order->getOrderNumber();

            $objPmReqCard->confirmUrl = URL . 'cart/payment_confirm';
            $objPmReqCard->returnUrl = URL . 'cont/card_return';

            $objPmReqCard->invoice = new \Mobilpay_Payment_Invoice();
            $objPmReqCard->invoice->currency = 'RON';

            $objPmReqCard->invoice->customer_type = 2;

            if ($order->getInstallments()) {
                $objPmReqCard->invoice->selectedInstallments = $order->getInstallments();
                $objPmReqCard->invoice->installments = '2,3,4';
            }
            $total = $order->getTotal();
            if (!$total)
                exit("ERROR: 3:31, Please contact administrator !");

            $objPmReqCard->invoice->amount = $total;
            $objPmReqCard->invoice->details = 'Cumparaturi Oringo';

            $billingAddress = new \Mobilpay_Payment_Address();
            $billingAddress->type = "person";
            $billingAddress->firstName = $order->getUser()->getPrenume();
            $billingAddress->lastName = $order->getUser()->getNume();
            $billingAddress->address = $order->getBillingAddress()->getBilling_address();
            $billingAddress->email = $order->getUser()->getEmail();
            $billingAddress->mobilePhone = $order->getUser()->getPhone();

            $objPmReqCard->invoice->setBillingAddress($billingAddress);

            $objPmReqCard->encrypt($x509FilePath);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $e = "";

        echo '
        <div class="span-15 prepend-1" style="margin:0 auto; text-align:center; margin-top:100px;">
        <?php if (!($e instanceof Exception)): ?>
                <p>
                <form name="frmPaymentRedirect" method="post" action="' . $paymentUrl . '">
                    <input type="hidden" name="env_key" value="' . $objPmReqCard->getEnvKey() . '"/>
                    <input type="hidden" name="data" value="' . $objPmReqCard->getEncData() . '"/>
                    <p>	

                        Pentru a finaliza plata vei redirectat catre pagina de plati securizata a mobilpay.ro
                    </p>
                    <p>
                        Daca nu esti redirectat in 3 secunde apasa <input type="image" value="Redirect"/>
                    </p>
                </form>
            </p>
            <script type="text/javascript" language="javascript">
               window.setTimeout(document.frmPaymentRedirect.submit(),1000);
            </script>
        <?php else: ?>
            <p><strong><?php echo $e->getMessage(); ?></strong></p>
        <?php endif; ?>
</div>';
    }

    private function informOwner(Entity\Order $order) {
        ob_start();
        require_once("mailMessages/informOwner.php");
        $body = ob_get_clean();
        $subject = "A fost plasata comanda " . $order->getOrderNumber() . ' Sa curga banii !';
        NeoMail::getInstance()->genericMail($body, $subject, $email);
    }

    private function validatePaymentProcess($post, Dealscount\Models\Entities\NeoCart $cart) {

        $hasErrors = false;
        $cartItems = $cart->getCartItems();
        if (!$cartItems) {
            header('Location: ' . base_url());
            exit();
        }

        foreach ($cartItems as $cartItem) {
            $item = $cartItem->getItem();
            for ($i = 0; $i < $cartItem->getQuantity(); $i++) {
                if ($cartItem->getIs_gift()) {
                    if (strlen($post['name_' . $cartItem->getId()][$i]) < 2 || !filter_var($post['email_' . $cartItem->getId()][$i], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Introduceți  corect datele prietenului !";
                        $hasErrors = true;
                        break 2;
                    }
                } else
                if (strlen($post['name_' . $cartItem->getId()][$i]) < 2) {
                    $errors[] = "Completati numele beneficiarilor!";
                    $hasErrors = true;
                    break 2;
                }
            }
        }

        if (!isset($_POST['payment_method']))
            $errors[] = "Alegeti metoda de plata";


        if ($hasErrors)
            return $errors;
        else
            return false;
    }

}
