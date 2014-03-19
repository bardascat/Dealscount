<?php

class partener extends \CI_Controller {

    private $OrderModel;
    private $OffersModel;
    private $PartnerModel;
    private $User;

    function __construct() {
        parent::__construct();
        $this->OrderModel = new Dealscount\Models\OrdersModel();
        $this->OffersModel = new \Dealscount\Models\OffersModel();
        $this->PartnerModel = new \Dealscount\Models\PartnerModel();
        DLConstants::pushJS('assets/js/jquery_ui/ui-1-10.js');
        DLConstants::pushJS('assets/js/timepicker/timepicker.js');
        DLConstants::pushJS('assets/js/ckeditorScripts/ckeditor.js');
        DLConstants::pushCSS('assets/js/jquery_ui/ui-1-10.css');
        $this->load->library('user_agent');
        $this->User = $this->getLoggedUser(true);
        $this->load->library('form_validation');
        $this->checkPermission();
    }

    /**
     * @AclResource "Partener: dashboard"
     */
    public function index() {
        $dashboardStas = $this->OffersModel->getPartnerDashboardStats($this->User, $this->input->get("from"), $this->input->get("to"));
        $options=$this->PartnerModel->getActiveOptions($this->User->getCompanyDetails()->getId_company());
        
        $this->load_view('partner/dashboard', array("user" => $this->User, "stats" => $dashboardStas,'options'=>$options));
    }

    /**
     * @AclResource "Partener: Utilizatori"
     */
    public function utilizatori() {
        $statsByCity = $this->OffersModel->getStatsByCity($this->User);
        $statsByGender = $this->OffersModel->getStatsByGender($this->User);
        $statsByAge = $this->OffersModel->getStatsByAge($this->User);

        $userStats = $this->OffersModel->getUsersStats($this->User);
        $this->load_view('partner/users', array("user" => $this->User,
            "statsByCity" => $statsByCity,
            "statsByGender" => $statsByGender,
            'statsByAge' => $statsByAge,
            'users_stats' => $userStats));
    }

    /**
     * @AclResource "Partener: Descarca Factura"
     */
    public function descarca_factura() {
        $id_invoice = $this->uri->segment(3);
        try {
            $invoice = $this->PartnerModel->getInvoice($id_invoice, $this->User);
        } catch (\Exception $e) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => $e->getMessage()));
            redirect(base_url('partener/facturi'));
        }

        $filename = $invoice->getSeries();
        $filename.=$invoice->getNumber() . '.pdf';
        $file = "application_uploads/invoices/" . $filename;
        if (file_exists($file) && 1 == 2) {
            header('Content-disposition: attachment; filename=' . $filename);
            header('Content-type: application/pdf');
            readfile($file);
        } else {
            $file = $this->PartnerModel->generateInvoiceFile($invoice);
            header('Content-disposition: attachment; filename=' . $filename);
            header('Content-type: application/pdf');
            readfile($file);
        }
    }

    /**
     * @AclResource "Partener: Facturi"
     */
    public function facturi() {

        $this->load_view('partner/invoices', array(
            "user" => $this->User
        ));
    }

    /**
     * @AclResource "Partener: Lista Oferte"
     */
    public function oferte() {
        $this->load_view('partner/offers', array("user" => $this->User));
    }

    /**
     * @AclResource "Partener: Dezactiveaza oferta"
     */
    public function suspend_offer() {
        $id_offer = $this->uri->segment('3');
        $offer = $this->OffersModel->getOffer($id_offer);
        //in cazul in care userul incearca sa dezactiveze oferta unui alt user, dupa id oferta
        if ($offer->getCompany()->getId_user() != $this->User->getId_user()) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Cererea nu a pututut fi finalizata !"));
            redirect(base_url('partener/oferte'));
            exit();
        }
        $offer->setActive(0);
        $this->OffersModel->simpleUpdate($offer);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost suspendata"));
        redirect($this->agent->referrer());
    }

    /**
     * @AclResource "Partener: Activeaza Oferta"
     */
    public function resume_offer() {
        $id_offer = $this->uri->segment('3');
        $offer = $this->OffersModel->getOffer($id_offer);
        if ($offer->getCompany()->getId_user() != $this->getLoggedUser()['id_user']) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Cererea nu a pututut fi finalizata !"));
            redirect(base_url('partener/oferte'));
            exit();
        }

        $offer->setActive(1);
        $this->OffersModel->simpleUpdate($offer);
        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost activata"));
        redirect($this->agent->referrer());
    }

    /**
     * @AclResource "Partener: Detalii Oferta"
     */
    public function offer_details() {
        $id_offer = $this->uri->segment('3');
        $offer = $this->OffersModel->getOffer($id_offer);
        if (!$offer || $offer->getCompany()->getId_user() != $this->getLoggedUser()['id_user']) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Cererea nu a pututut fi finalizata !"));
            redirect(base_url('partener/oferte'));
            exit();
        }
        $statsByCity = $this->OffersModel->getStatsByCity($this->User, $id_offer);
        $statsByGender = $this->OffersModel->getStatsByGender($this->User, $id_offer);
        $statsByAge = $this->OffersModel->getStatsByAge($this->User, $id_offer);
        $data = array("offer" => $offer,
            "user" => $this->User,
            "statsByCity" => $statsByCity,
            "statsByGender" => $statsByGender,
            'statsByAge' => $statsByAge
        );
        $this->load_view('partner/offer_details', $data);
    }

    /**
     * @AclResource "Partener: Editeaza Oferta"
     */
    public function edit_offer() {
        $id_offer = $this->uri->segment('3');
        $offer = $this->OffersModel->getOffer($id_offer);
        if (!$offer || $offer->getCompany()->getId_user() != $this->getLoggedUser()['id_user']) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Cererea nu a pututut fi finalizata !"));
            redirect(base_url('partener/oferte'));
            exit();
        }
        $data = array("offer" => $offer, "user" => $this->User, "categories" => $this->CategoriesModel->getRootCategories());
        $this->populate_form($offer);
        $this->load_view('partner/edit_offer', $data);
    }

    public function editOfferDo() {
        if (count($_POST) < 1)
            redirect($this->agent->referrer());

        $this->form_validation->set_rules($this->setOfferRules());
        $this->form_validation->set_rules('category', 'Categorie', 'callback_categories_check');
        $this->form_validation->set_message('required', '<b>%s</b> este obligatoriu');
        if ($this->form_validation->run() == FALSE) {
            $offer = $this->OffersModel->getOffer($this->input->post("id_item"));
            $this->populate_form($offer);

            $data = array(
                'offer' => $offer,
                'user' => $this->User,
                "categories" => $this->CategoriesModel->getRootCategories(),
                "notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "ui-state-error ui-corner-all"
                )
            );
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Va rugam completati toate campurile."));
            $this->load_view('partner/edit_offer', $data);
        } else {
            $id = $this->input->post('id_item');
            $images = $this->upload_images($_FILES['image'], "application_uploads/items/" . $id);
            $_POST['images'] = $images;
            $this->OffersModel->updateOffer($_POST, $this->User->getId_user());
            $this->session->set_flashdata('form_message', '<div class="ui-state-highlight ui-corner-all" style="padding:5px;color:green">Oferta a fost salvata</div>');
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost salvata"));
            redirect(base_url('partener/editeaza-oferta/' . $id));
        }
    }

    /**
     * @AclResource "Partener: Creeaza Oferta"
     */
    public function add_offer() {
        $data = array("user" => $this->User, "categories" => $this->CategoriesModel->getRootCategories());
        $this->load_view('partner/add_offer', $data);
    }

    public function addOfferDo() {
        if (count($_POST) < 1)
            redirect($this->agent->referrer());

        $this->form_validation->set_rules($this->setOfferRules());
        $this->form_validation->set_rules('category', 'Categorie', 'callback_categories_check');
        $this->form_validation->set_message('required', '<b>%s</b> este obligatoriu');
        if ($this->form_validation->run() == FALSE) {

            $data = array(
                'user' => $this->User,
                "categories" => $this->CategoriesModel->getRootCategories(),
                "notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "ui-state-error ui-corner-all"
                )
            );
            $this->session->set_flashdata('notification', array("type" => "error", "html" => "Va rugam completati toate campurile."));
            $this->load_view('partner/add_offer', $data);
        } else {
            $images = $this->upload_images($_FILES['image'], "application_uploads/items/" . $id);
            $_POST['images'] = $images;
            $offer = $this->OffersModel->addOffer($_POST, $this->User->getId_user());
            $this->session->set_flashdata('form_message', '<div class="ui-state-highlight ui-corner-all" style="padding:5px;color:green">Felicitari, oferta a fost creata cu succes</div>');
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Felicitari, oferta a fost creata. "));
            redirect(base_url('partener/editeaza-oferta/' . $offer->getIdItem()));
        }
    }

    public function delete_image() {
        $id_image = $_POST['id_image'];
        $this->OffersModel->delete_image($id_image);
        echo json_encode(array("type" => "success"));
        exit();
    }

    public function set_primary_image() {
        $id_image = $_POST['id_image'];
        $this->OffersModel->setPrimaryImage($id_image);
        echo json_encode(array("result" => "success"));
    }

    /**
     * @AclResource "Partener: Newsletters"
     */
    public function newsletter() {
        $this->load_view('partner/newsletters', array("user" => $this->User, "cities" => $this->PartnerModel->getActiveCities()));
    }

    /**
     * @AclResource "Partener: Programeaza Newsletter"
     */
    public function schedule_newsletter() {

        //procesam requestul
        $this->form_validation->set_rules('name', 'Nume newsletter', 'required|xss_clean|min_length[10]|max_length[50]');
        $this->form_validation->set_rules('scheduled', 'Data trimitere', 'callback_valid_date|xss_clean');
        $this->form_validation->set_rules('sex[]', 'Sex', 'required');
        $this->form_validation->set_rules('age[]', 'Varsta', 'required');
        $this->form_validation->set_rules('cities', 'Orase', 'required');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', 'Campul <b>%s</b> este obligatoriu sa aiba nimim %s caractere ');
        $this->form_validation->set_message('max_length', 'Campul <b>%s</b> este obligatoriu sa aiba maxim %s caractere ');
        if ($this->form_validation->run() == FALSE) {
            $this->load_view('partner/newsletters', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "user" => $this->User, "cities" => $this->PartnerModel->getActiveCities()));
        } else {
            //forma este corecta, validam business logic
            $valid = $this->valid_newsletter();
            if ($valid) {
                $this->PartnerModel->createNewsletter($_POST, $this->User);
                $this->session->set_flashdata('notification', array("type" => "success", "html" => "Newsletterul a fost programat cu succes!"));
                redirect(base_url('partener/newsletter'));
            } else {

                exit('no validated');
            }
        }
    }

    /**
     * @AclResource "Partener: Abonamente"
     */
    public function abonamente() {
        $options = $this->PartnerModel->getSubscriptionOptions('option',$this->User->getCompanyDetails()->getId_company());

        $this->load_view('partner/abonamente', array("user" => $this->User,
            "subscriptions" => $this->PartnerModel->getSubscriptionOptions("valabilitate"),
            "options" => $options
        ));
    }

    public function buy_option() {
        if (isset($_POST['id_option'])) {

            $NeoCartModel = new \Dealscount\Models\NeoCartModel();
            $option = $this->PartnerModel->getSubscriptionOption($_POST['id_option']);
            $order = $NeoCartModel->buySubscriptionOption($this->User, $option, $_POST);

            switch ($_POST['payment_method']) {
                case DLConstants::$PAYMENT_METHOD_OP: {
                        $this->buy_option_op($order);
                        redirect(base_url('partener/op_return/' . $order->getOrder_number()));
                    }break;
                default: {
                        $this->buy_option_card($order);
                    }break;
            }
        }
        else
            show_404();
    }

    public function buy_option_op(\Dealscount\Models\Entities\SubscriptionOptionOrder $order) {
        ob_start();
        require_once("application/views/mailMessages/transferBancar.php");
        $body = ob_get_clean();
        $subject = "Comanda " . DLConstants::$WEBSITE_COMMERCIAL_NAME . ' a fost finalizata';
        \NeoMail::genericMail($body, $subject, $order->getCompany()->getUser()->getEmail());
        return true;
    }

    public function buy_option_card(\Dealscount\Models\Entities\SubscriptionOptionOrder $order) {
        $option = $order->getOption();

        require_once 'application/libraries/Mobilpay/Payment/Request/Abstract.php';
        require_once 'application/libraries/Mobilpay/Payment/Request/Card.php';
        require_once 'application/libraries/Mobilpay/Payment/Invoice.php';
        require_once 'application/libraries/Mobilpay/Payment/Address.php';

        $paymentUrl = 'http://sandboxsecure.mobilpay.ro';
        //$paymentUrl = 'https://secure.mobilPay.ro';
        $x509FilePath = 'application/libraries/Mobilpay/public.cer';
        try {
            srand((double) microtime() * 1000000);
            $objPmReqCard = new \Mobilpay_Payment_Request_Card();
            $objPmReqCard->signature = 'ULSN-4A5M-3JYK-3BX5-Y75A';
            $objPmReqCard->orderId = $order->getOrder_number();

            $objPmReqCard->confirmUrl = base_url('partener/card_payment_confirm?mobilpay=' . sha1("mobilpay"));
            $objPmReqCard->returnUrl = base_url('partener/card_return/' . $order->getOrder_number());

            $objPmReqCard->invoice = new \Mobilpay_Payment_Invoice();
            $objPmReqCard->invoice->currency = 'RON';

            $objPmReqCard->invoice->customer_type = 2;

            $total = $order->getTotal();
            if (!$total)
                exit("ERROR: 3:31, Please contact administrator !");

            $objPmReqCard->invoice->amount = $total;
            $objPmReqCard->invoice->details = $option->getName();

            $billingAddress = new \Mobilpay_Payment_Address();
            $billingAddress->type = "person";
            $billingAddress->firstName = $order->getCompany()->getUser()->getFirstname();
            $billingAddress->lastName = $order->getCompany()->getUser()->getLastname();
            $billingAddress->address = $order->getCompany()->getUser()->getAddress();
            $billingAddress->email = $order->getCompany()->getUser()->getEmail();
            $billingAddress->mobilePhone = $order->getCompany()->getUser()->getPhone();

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

    public function card_payment_confirm() {

        require_once 'application/libraries/Mobilpay/Payment/Request/Abstract.php';
        require_once 'application/libraries/Mobilpay/Payment/Request/Card.php';
        require_once 'application/libraries/Mobilpay/Payment/Request/Notify.php';
        require_once 'application/libraries/Mobilpay//Payment/Invoice.php';
        require_once 'application/libraries/Mobilpay/Payment/Address.php';

        $errorCode = 0;
        $errorType = \Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_NONE;


        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0) {
            if (isset($_POST['env_key']) && isset($_POST['data'])) {
                $privateKeyFilePath = 'application/libraries/Mobilpay/private.key';

                try {
                    $objPmReq = \Mobilpay_Payment_Request_Abstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $privateKeyFilePath);


                    $order = $this->PartnerModel->getSubscriptionOptionOrder($objPmReq->orderId);
                    if ($objPmReq->objPmNotify->errorCode != 0) {

                        $order->setPayment_status(DLConstants::$PAYMENT_STATUS_CANCELED);
                        $this->PartnerModel->updateSubscriptionOrder($order);
                    }
                    else
                        switch ($objPmReq->objPmNotify->action) {
                            #orice action este insotit de un cod de eroare si de un mesaj de eroare. Acestea pot fi citite folosind $cod_eroare = $objPmReq->objPmNotify->errorCode; respectiv $mesaj_eroare = $objPmReq->objPmNotify->errorMessage;
                            #pentru a identifica ID-ul comenzii pentru care primim rezultatul platii folosim $id_comanda = $objPmReq->orderId;
                            case 'confirmed': {
                                    $this->PartnerModel->confirmSubscriptionOptionOrder($objPmReq->orderId);
                                }
                                break;
                            case 'confirmed_pending': {
                                    #cand action este confirmed_pending inseamna ca tranzactia este in curs de verificare antifrauda. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                                    $order->setPayment_status(DLConstants::$PAYMENT_STATUS_PENDING);
                                    $this->PartnerModel->updateSubscriptionOrder($order);
                                }
                                break;
                            case 'paid_pending': {
                                    $order->setPayment_status(DLConstants::$PAYMENT_STATUS_PENDING);
                                    $this->PartnerModel->updateSubscriptionOrder($order);
                                    #cand action este paid_pending inseamna ca tranzactia este in curs de verificare. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                                    $errorMessage = $objPmReq->objPmNotify->getCrc();
                                }
                                break;
                            case 'paid': {
                                    $order->setPayment_status(DLConstants::$PAYMENT_STATUS_PENDING);
                                    $this->PartnerModel->updateSubscriptionOrder($order);
                                    #cand action este paid inseamna ca tranzactia este in curs de procesare. Nu facem livrare/expediere. In urma trecerii de aceasta procesare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                                    $errorMessage = $objPmReq->objPmNotify->getCrc();
                                }
                                break;
                            case 'canceled': {
                                    $order->setPayment_status(DLConstants::$PAYMENT_STATUS_CANCELED);
                                    $this->PartnerModel->updateSubscriptionOrder($order);
                                    #cand action este canceled inseamna ca tranzactia este anulata. Nu facem livrare/expediere.
                                    $errorMessage = $objPmReq->objPmNotify->getCrc();
                                }
                                break;
                            case 'credit': {
                                    #cand action este credit inseamna ca banii sunt returnati posesorului de card. Daca s-a facut deja livrare, aceasta trebuie oprita sau facut un reverse. 
                                    $order->setPayment_status(DLConstants::$PAYMENT_METHOD_RAMBURS);
                                    $this->PartnerModel->updateSubscriptionOrder($order);
                                }
                                break;
                            default:
                                $order->setPayment_status(DLConstants::$PAYMENT_STATUS_CANCELED);
                                $this->PartnerModel->updateSubscriptionOrder($order);
                                $errorType = \Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
                                $errorCode = \Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_ACTION;
                                $errorMessage = 'mobilpay_refference_action paramaters is invalid';
                                break;
                        }
                } catch (Exception $e) {


                    $errorType = \Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                    $errorCode = $e->getCode();
                    $errorMessage = $e->getMessage();
                }
            } else {
                $errorType = \Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
                $errorCode = \Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
                $errorMessage = 'mobilpay.ro posted invalid parameters';
            }
        } else {
            $errorType = \Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $errorCode = \Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_METHOD;
            $errorMessage = 'invalid request metod for payment confirmation';
        }

        header('Content-type: application/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if (isset($errorCode) && isset($errorMessage) && $errorCode == 0) {
            echo "<crc>{$errorMessage}</crc>";
        } else {
            if (!isset($errorMessage))
                $errorMessage = "";
            echo "<crc error_type=\"{$errorType}\" error_code=\"{$errorCode}\">{$errorMessage}</crc>";
        }
    }

    /**
     * @AclResource "Partener: Landing Page OP"
     */
    public function op_return() {
        $order_code = $this->uri->segment(3);
        $order = $this->PartnerModel->getSubscriptionOptionOrder($order_code);
        $this->load_view('partner/landing_pages/op_payment', array("user" => $this->User, 'order' => $order
        ));
    }

    /**
     * @AclResource "Partener: Landing Page Card"
     */
    public function card_return() {
        $order_code = $this->uri->segment(3);
        $order = $this->PartnerModel->getSubscriptionOptionOrder($order_code);
        $this->load_view('partner/landing_pages/card_payment', array("user" => $this->User, 'order' => $order
        ));
    }

    /**
     * @AclResource "Partener: Cancel Newsletter"
     */
    public function cancel_newsletter() {
        $id_newsletter = $this->uri->segment(3);
        try {
            $this->PartnerModel->suspendNewsletter($id_newsletter, $this->User);
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Newsleterul a fost anulat cu succes !"));
        } catch (\Exception $e) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => $e->getMessage()));
        }
        redirect('partener/newsletter');
    }

    /**
     * @AclResource "Partener: Vizualizare Newsletter"
     */
    public function view_newsletter() {
        $id_newsletter = $this->uri->segment(3);
        try {
            $newsletter = $this->PartnerModel->getNewsletter($id_newsletter, $this->User);
        } catch (\Exception $e) {
            $this->session->set_flashdata('notification', array("type" => "error", "html" => $e->getMessage()));
            redirect('partener/newsletter');
        }


        $offers = json_decode($newsletter->getOffers());
        if (count($offers) < 1) {
            exit("Nu ati selectat nicio oferta !");
        }
        foreach ($offers as $key => $id_offer) {

            $offer = $this->OffersModel->getOffer($id_offer);
            $offers[$key] = $offer;
        }

        $this->load->view('newsletter/newsletter_partener', array("offers" => $offers, 'company' => $this->User));
    }

    //validators
    public function valid_date() {
        $date = $_POST['scheduled'];
        $date = strtotime($date);
        if ($date === false) {
            $this->form_validation->set_message('valid_date', 'Data trimiterii newsletterului este incorecta');
            return false;
        } else {
            if ($date < strtotime(date("Y-m-d"))) {
                $this->form_validation->set_message('valid_date', 'Data trimiterii newsletterului este incorecta');
                return false;
            }
        }
        return true;
    }

    private function valid_newsletter() {
        return true;
    }

    //validators end

    /**
     * @Author : Cornel
     */

    /**
     * @AclResource "Partener: Date Cont"
     */
    public function date_cont() {

        $this->load_view('partner/date_cont', array("user" => $this->User, "cities" => $this->UserModel->getCities()));
    }

    public function change_date_cont() {
        if (!$_POST)
            redirect(base_url('partener'));
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('company_name', 'Company name', 'required|xss_clean');
        $this->form_validation->set_rules('cif', 'Cod fiscal', 'required|xss_clean');
        $this->form_validation->set_rules('regCom', 'Registrul comertului', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('lastname', 'Numele de contact', 'required|xss_clean');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');

        if ($this->form_validation->run() == FALSE) {
            $this->load_view('partner/date_cont', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error",
                    "cities" => $this->UserModel->getCities(),
                ), "user" => $this->User));
        } else {
            try {
                $this->PartnerModel->updateCompanyDetails($_POST, $this->User);
            } catch (\Exception $e) {
                $this->load_view('partner/date_cont', array("notification" => array(
                        "type" => "form_notification",
                        "message" => $e->getMessage(),
                        "cssClass" => "error"
                    ), "user" => $this->User));
            }
        }

        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Modificarile au fost salvate cu success"));
        redirect(base_url('partener/date-cont'));
    }

    public function change_date_cont_company() {

        if (!$_POST)
            redirect(base_url('partener'));

        $this->form_validation->set_rules('commercial_name', 'Comercial name', 'required|xss_clean');
        $this->form_validation->set_rules('description', 'Descriere', 'required|xss_clean');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');

        if ($this->form_validation->run() == FALSE) {
            $this->load_view('partner/date_cont', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "user" => $this->User));
        } else {
            try {
                $images = $this->upload_images($_FILES['image'], "application_uploads/company/" . $this->User->getId_user(), false);
                $_POST['image'] = $images;
                $this->UserModel->updateCompanyDetails($_POST);
            } catch (\Exception $e) {
                $this->load_view('partner/date_cont', array("notification" => array(
                        "type" => "form_notification",
                        "message" => $e->getMessage(),
                        "cssClass" => "error"
                    ), "user" => $this->User));
            }
        }

        $this->session->set_flashdata('notification', array("type" => "success", "html" => "Modificarile au fost salvate cu success"));
        redirect(base_url('partener/date-cont'));
    }

    public function partener_change_password() {
        if (!$_POST)
            redirect(base_url('partner/date-cont'));
        $this->populate_form($this->User);

        //procesam requestul
        $this->form_validation->set_rules('new_password', 'Parola noua', 'required|xss_clean');
        $this->form_validation->set_rules('old_password', 'Parola veche', 'required|xss_clean');
        $this->form_validation->set_rules('old_password', 'Parola veche', 'callback_password_match');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');
        $this->form_validation->set_message('min_length', '%s prea scurta. Minim %s caractere');

        if ($this->form_validation->run() == FALSE) {

            $this->load_view('partner/date_cont', array("notification_password" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
                ), "user" => $this->User));
        } else {
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Parola a fost resetata"));
            $status = $this->UserModel->updatePassword($_POST);
        }
        redirect(base_url('partener/date-cont#change_password'));
    }

    /**
     * @AclResource "Partener: Vouchere Partener"
     */
    public function vouchere() {
        $q = false;
        $voucher = false;

        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            $voucher = $this->PartnerModel->getVoucher($q, $this->User->getId_user());
        }
        $vouchers = $this->PartnerModel->getVouchers($this->User->getId_user());
        $this->load_view('partner/vouchere', array("user" => $this->User, 'vouchers' => $vouchers, 'q' => $q, 'search_result' => $voucher));
    }

    /**
     * @AclResource "Partener: Change Voucher Status"
     */
    public function change_voucher_status() {
        if (!$_POST)
            redirect(base_url('partner/vouchere'));
        $status_changed = $this->PartnerModel->changeVoucherStatus($_POST['voucher_code']);
        if ($status_changed) {
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Voucherul a fost folosit cu succes."));
            redirect(base_url('partener/vouchere?q=' . $status_changed));
        } else {
            //aici ar trebui sa adaug un mesaj de eroare
        }
        die;
    }

    /**
     * END CORNEL
     */
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

    public function password_match() {
        $old_password = $_POST['old_password'];
        if (sha1($old_password) != $this->getLoggedUser(true)->getPassword()) {
            $this->form_validation->set_message('password_match', 'Parola veche este incorecta');
            return false;
        }
        else
            return true;
    }

    private function setOfferRules() {
        $config = array(
            array(
                "field" => "name",
                "label" => "Nume",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "brief",
                "label" => "Scurta descriere",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "benefits",
                "label" => "Beneficii",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "terms",
                "label" => "Termeni",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "price",
                "label" => "Pret",
                "rules" => "required|callback_numeric_check|xss_clean"
            ),
            array(
                "field" => "sale_price",
                "label" => "Pret vanzare",
                "rules" => "required|callback_numeric_check|xss_clean"
            ),
            array(
                "field" => "id_company",
                "label" => "Partener",
                "rules" => "required"
            ),
            array(
                "field" => "start_date",
                "label" => "Data inceput oferta",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "end_date",
                "label" => "Data sfarsit oferta",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "voucher_start_date",
                "label" => "Data start voucher",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "voucher_end_date",
                "label" => "Data sfarsit voucher",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "location",
                "label" => "Locatie",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "city",
                "label" => "Oras",
                "rules" => "required|xss_clean"
            )
        );
        return $config;
    }

    /**
     * Validate custom oferta
     */
    public function numeric_check($str) {
        if (!preg_match('/^[0-9,]+$/', $str)) {
            $this->form_validation->set_message('numeric_check', '%s trebuie sa fie numar intreg');
            return FALSE;
        }
        else
            return true;
    }

    public function images_check($data) {
        if (!$_FILES['image']['name'][0]) {
            $this->form_validation->set_message('images_check', 'Este obligatoriu sa alegi cel putin o poza');
            return false;
        } else {
            return true;
        }
    }

    public function categories_check($data) {
        //daca a ales o categorie
        if ($_POST['category']) {
            $category = $this->CategoriesModel->getCategoryByPk($_POST['category']);
            if (is_object($category)) {
                //a ales categoria, verificam daca a ales subcategoria
                $subcategory = $this->CategoriesModel->getCategoryByPk($_POST['subcategory']);
                if (!is_object($subcategory)) {
                    /**
                     * Subcategoria nu a fost aleasa.
                     * Daca categoria principala nu are subcategorii atunci e ok, else eroare
                     */
                    if (count($category->getChildren()) == 0) {
                        $_POST['categories'][0] = $category->getId_category();
                        return true;
                    }
                } else {
                    $_POST['categories'][0] = $subcategory->getId_category();
                    return true;
                }
            }
        }
        $this->form_validation->set_message('categories_check', 'Este obligatoriu sa alegi categoria ofertei');
        return false;
    }

    //end validatoare

    public function checkPermission() {

        if (isset($_GET['mobilpay']) && $_GET['mobilpay'] = sha1("mobilya"))
            return true;

        //daca contul nu este activ
        if ($this->User->getCompanyDetails()->getStatus() != DLConstants::$PARTNER_ACTIVE && $this->uri->segment(2) != "logout") {
            $this->load_view('partner/inactive', array("user" => $this->User));
        }

        //daca contul nu are valabilitate, ii dam voie in pagina abonamente si date cont
        $restrict_access = array("oferta-noua", "newsletter", "editeaza-oferta", "activeaza-oferta");
        if (!$this->User->getCompanyDetails()->isActive() && in_array($this->uri->segment(2), $restrict_access)) {
            $this->load_view('partner/inactive', array("user" => $this->User, "message" => "Contul dumneavoastra este expirat.<br/> Va rugam intrati in pagina de abonamente si prelungiti-l."));
        }
    }

}

?>
