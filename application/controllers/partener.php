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
        ;
        $this->load->library('form_validation');
    }

    /**
     * @AclResource "Partener: dashboard"
     */
    public function index() {
        $this->populate_form($this->User);
        $this->load_view('partner/dashboard', array("user" => $this->User));
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
        $data = array("offer" => $offer, "user" => $this->User);
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
            $offer=$this->OffersModel->addOffer($_POST, $this->User->getId_user());
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
        $this->load_view('partner/newsletters', array("user" => $this->User));
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
                ), "user" => $this->User));
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

        echo 'Astept grafica pentru newsletter<br/>';
        echo $newsletter->getName();
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

        $this->load_view('partner/date_cont', array("user" => $this->User));
    }

    public function change_date_cont() {
        if (!$_POST)
            redirect(base_url('partener'));
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('company_name', 'Company name', 'required|xss_clean');
        $this->form_validation->set_rules('cif', 'Cod fiscal', 'required|xss_clean');
        $this->form_validation->set_rules('regCom', 'Registrul comertului', 'required|xss_clean');
        $this->form_validation->set_rules('address', 'Adresa', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('bank', 'Banca', 'required|xss_clean');
        $this->form_validation->set_rules('iban', 'IBAN', 'required|xss_clean');
        $this->form_validation->set_rules('lastname', 'Numele de contact', 'required|xss_clean');
        $this->form_validation->set_rules('firstname', 'Prenumele de contact', 'required|xss_clean');
        $this->form_validation->set_message('required', 'Campul <b>%s</b> este obligatoriu');

        if ($this->form_validation->run() == FALSE) {

            $this->load_view('partner/date_cont', array("notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "error"
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
        redirect(base_url('partener/date_cont'));
    }

    public function change_date_cont_company() {

        if (!$_POST)
            redirect(base_url('partener'));

        $this->form_validation->set_rules('commercial_name', 'Comercial name', 'required|xss_clean');
        $this->form_validation->set_rules('description', 'Descriere', 'required|xss_clean');
        $this->form_validation->set_rules('phone', 'Telefon', 'required|numeric|xss_clean');
        $this->form_validation->set_rules('website', 'Site', 'required|xss_clean');
        $this->form_validation->set_rules('address', 'Adresa', 'required|xss_clean');
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
        redirect(base_url('partener/date_cont'));
    }

    public function partener_change_password() {
        if (!$_POST)
            redirect(base_url('partner/date_cont'));
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
        } else
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
        } else
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

}

?>
