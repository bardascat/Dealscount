<?php

/**
 * Description of index
 * @author Bardas Catalin
 * date: Dec 28, 2011 
 */
class offer extends CI_Controller {

    /**
     *
     * @var OffersModel $OffersModel
     */
    private $OffersModel;

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->setAccessLevel(DLConstants::$ADMIN_LEVEL);
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    /**
     * @AclResource Admin:Lista Oferte
     */
    public function offers_list() {
        if ($this->input->get('page'))
            $page = $this->input->get('page');
        else
            $page = 1;

        $offers = $this->OffersModel->PaginateOffers($page, 30);


        $data = array(
            "totalPages" => round(count($offers) / 30) + 1,
            "offers" => $offers
        );
        $this->load_view_admin('admin/offer/offers_list', $data);
    }

    /**
     * @AclResource Admin:Adauga Oferta
     */
    public function add_offer() {
        $this->view->setPage_name("Adauga Oferta");

        $companies = $this->UserModel->getCompaniesList();
        $tree = $this->CategoriesModel->createCheckboxList("offer");

        $data = array(
            'companies' => $companies,
            'category_tree' => $tree
        );
        $this->load_view_admin('admin/offer/add_offer', $data);
    }

    public function addOfferDo() {

        $this->form_validation->set_rules($this->setOfferRules());
        $this->form_validation->set_rules('categories', 'Categorie', 'callback_categories_check');
        $this->form_validation->set_rules('image', 'Poze', 'callback_images_check');

        if ($this->form_validation->run() == FALSE) {
            $tree = $this->CategoriesModel->createCheckboxList("offer");
            $companies = $this->UserModel->getCompaniesList();
            $data = array(
                'companies' => $companies,
                'category_tree' => $tree,
                "notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "ui-state-error ui-corner-all"
                )
            );
            $this->load_view_admin('admin/offer/add_offer', $data);
        } else {
            $id = $this->OffersModel->getNextId("items", "id_item");
            $images = $this->upload_images($_FILES['image'], "application_uploads/items/" . $id);
            $_POST['images'] = $images;
            $this->OffersModel->addOffer($_POST, $this->getLoggedUser()['id_user']);

            $this->session->set_flashdata('form_ok', 'Oferta a fost adaugata');
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost adaugata"));
            redirect(base_url('admin/offer/offers_list'));
        }
    }

    /**
     * @AclResource Admin:Editeaza Oferta
     */
    public function editOffer() {
        $this->view->setPage_name("Editeaza Oferta");

        $id_item = $this->uri->segment(4);

        /* @var $product Entity\Item  */
        $companies = $this->UserModel->getCompaniesList();
        $tree = $this->CategoriesModel->createCheckboxList("offer", $id_item);

        $item = $this->OffersModel->getOffer($id_item);
        $item->setSlug(substr($item->getSlug(), 0, strripos($item->getSlug(), '-')));
        $this->populate_form($item);
        $data = array(
            "companies" => $companies,
            "tree" => $tree,
            "item" => $item
        );
        $this->load_view_admin('admin/offer/edit_offer', $data);
    }

    public function editOfferDo() {

        $this->form_validation->set_rules($this->setOfferRules());
        $this->form_validation->set_rules('categories', 'Categorie', 'callback_categories_check');

        if ($this->form_validation->run() == FALSE) {
            $tree = $this->CategoriesModel->createCheckboxList("offer", $this->input->post("id_item"));
            $item = $this->OffersModel->getOffer($this->input->post("id_item"));
            $companies = $this->UserModel->getCompaniesList();
            $this->populate_form($item);

            $data = array(
                'item' => $item,
                'companies' => $companies,
                'tree' => $tree,
                "notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "ui-state-error ui-corner-all"
                )
            );
            $this->load_view_admin('admin/offer/edit_offer', $data);
        } else {
            $id = $this->input->post('id_item');
            $images = $this->upload_images($_FILES['image'], "application_uploads/items/" . $id);
            $_POST['images'] = $images;
            $this->OffersModel->updateOffer($_POST, $this->getLoggedUser()['id_user']);
            $this->session->set_flashdata('form_message', '<div class="ui-state-highlight ui-corner-all" style="padding:5px;color:green">Oferta a fost salvata</div>');
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost salvata"));
            redirect(base_url('admin/offer/editOffer/' . $id));
        }
    }

    /**
     * @AclResource Admin:Sterge Oferta
     */
    public function delete_offer() {
        if ($this->uri->segment(3)) {

            $id = $this->uri->segment(3);

            $this->OffersModel->deleteOffer($id);
            $this->session->set_flashdata('notification', array("type" => "success", "html" => "Oferta a fost stearsa"));
            redirect($this->agent->referrer());
        }
    }

    public function delete_image() {
        if ($this->input->post("id_image")) {
            $data = false;
            $this->OffersModel->delete_image($this->input->post("id_image"));
            echo json_encode(array('type' => 'success', 'msg' => 'Oferta a fost stersa', 'data' => $data));
        } else {
            echo json_encode(array('type' => 'error', 'msg' => 'Id produs incorect'));
        }
    }

    public function searchOffers() {
        $searchQuery = $_GET['search'];
        if (strlen($searchQuery) < 2) {
            header('Location:' . URL . 'admin/offer/offers_list');
            exit();
        }
        $offer = $this->OffersModel->searchOffers($searchQuery);
        $this->view->offers = $offer['result'];
        $this->view->render('admin/offer/offers_list', true);
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
            $this->form_validation->set_message('numeric_check', '%s must be a number');
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
        if (isset($data[0]) and is_numeric($data[0]))
            return true;
        else {
            $this->form_validation->set_message('categories_check', 'Este obligatoriu sa alegi o categorie');
            return false;
        }
    }

}
