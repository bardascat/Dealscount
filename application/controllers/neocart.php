<?php

/**
 *
 * @author Neo aka Bardas Catalin
 */
class neocart extends CI_Controller {

    private $NeoCartModel;

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->NeoCartModel = new Dealscount\Models\NeoCartModel();
    }

    public function index() {
        
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
     * Payment methods
     */
    public function process_payment() {
        $cart = $this->NeoCartModel->getCart(self::getHash());

        $errors = $this->validateForm($_POST, $cart);

        if ($errors) {
            $this->setCargusDistricts();
            $validator = $errors['shipping_address_errors'];
            if ($validator)
                $this->view->form_js.= $validator->form_js("newAddressMessages", "Toate câmpurile sunt obligatorii", array("shipping_address_id"));


            $validator = $errors['billing_address_errors'];
            if ($validator)
                $this->view->form_js.= $validator->form_js("newBillingMessages", "Toate câmpurile sunt obligatorii", array("shipping_address_id"));


            $alertErrors = "<br/> Înainte de a continua vă rugăm: <br/>";
            foreach ($errors as $error) {
                if (is_string($error))
                    $alertErrors.=$error;
            }

            $this->set_alert_message($alertErrors);
            $this->view->cart = $cart;
            $this->view->post = $_POST;
            $this->view->render('cart/index');
        }

        switch ($_POST['payment_method']) {
            case "card": {
                    $this->processCardPayment();
                }break;
            case "op": {
                    $this->processOpPayment();
                }break;
            case "ramburs": {
                    $this->processRambursPayment();
                }break;
            case "free": {
                    $this->processFreePayment();
                }break;
        }
    }

    private function processFreePayment() {
        /* @var $order Entity\Order */
        $order = $this->NeoCartModel->insertOrder($this->logged_user['orm'], $_POST);

        $email = $order->getUser()->getEmail();

        ob_start();
        require_once("mailMessages/freeOrder.php");
        $body = ob_get_clean();
        $subject = "Comanda " . $order->getOrderNumber() . ' ORINGO';

        $vouchers = $this->NeoCartModel->generateVouchers($order);
        NeoMail::getInstance()->genericMailAttach($body, $subject, $email, $vouchers);

        $this->informOwner($order);
        header('Location:' . URL . 'cont/finalizare_free?code=' . $order->getOrderNumber());
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

    private function processCardPayment() {

        $order = $this->NeoCartModel->insertOrder($this->logged_user['orm'], $_POST);
        $this->informOwner($order);

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
        NeoMail::getInstance()->genericMail($body, $subject, 'comenzi@oringo.ro');
    }

}
