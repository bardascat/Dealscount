<?php

/**
 * @author Bardas Catalin
 */
class users extends CI_Controller {

   

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->setAccessLevel(DLConstants::$ADMIN_LEVEL);
    }

    /**
     * Utilizatori
     */
    public function users_list() {
        if (isset($_GET['page']))
            $page = $_GET['page'];
        else
            $_GET['page'] = 1;
        $this->view->pageName = "Lista utilizatori";
        $users = $this->UserModel->getUsers($_GET['page']);
        $this->view->users = $users;
        $this->view->render("admin/users/users_list", true);
    }

    public function searchUser() {
        $this->view->pageName = "Utilizatori";
        if (!$_GET['search']) {
            header("Location:" . URL . 'admin/users/users_list');
            exit();
        }

        $this->view->users = $this->UserModel->searchUser($_GET['search']);
        $this->view->render("admin/users/users_list", true);
    }

    public function view_user() {
        $this->view->pageName = "Utilizatori";
        $this->view->user = $this->UserModel->getUserByPk($param[0], true);

        $this->populate_form($this->view->user);
        $this->view->render("admin/users/view_user", true);
    }

    /**
     * Companii
     */
    public function company_list() {
        $this->view->setPage_name("Lista parteneri");
        $companies = $this->UserModel->getCompaniesList();

        $this->load_view_admin("admin/users/company/company_list", array("companies" => $companies));
    }

    public function add_company() {
        $this->view->setPage_name("Adauga Partener");
        $this->load_view_admin('admin/users/company/add_company');
    }

    public function addCompanySubmit() {

        $this->form_validation->set_rules($this->getPartnerValidationRules());

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                "notification" => array(
                    "type" => "form_notification",
                    "message" => validation_errors(),
                    "cssClass" => "ui-state-error ui-corner-all"
                )
            );
            $this->load_view_admin('admin/users/company/add_company', $data);
        } else {
            $id = $this->UserModel->getNextId("users", "id_user");
            $images = $this->upload_images($_FILES['image'], "application_uploads/company/" . $id, false);
            $_POST['image'] = $images;
            try {
                $user = $this->UserModel->createPartner($_POST);
                $this->session->set_flashdata("form_message", "Partenerul a fost inserat");
                redirect(base_url('admin/users/company_list'));
            } catch (\Exception $e) {
                //email invalid
                $data = array(
                    "notification" => array(
                        "type" => "form_notification",
                        "message" => $e->getMessage(),
                        "cssClass" => "ui-state-error ui-corner-all"
                    )
                );
                $this->load_view_admin('admin/users/company/add_company', $data);
            }
        }
    }

    public function edit_company() {
        $id_user = $this->uri->segment(4);

        $user = $this->UserModel->getCompanyByPk($id_user);

        $this->populate_form($user);
        $data = array(
            "user" => $user
        );
        if ($this->uri->segment(5) == "popup")
            $this->load_view_admin_popup('admin/users/company/edit_company_popup', $data);
        else
            $this->load_view_admin('admin/users/company/edit_company', $data);
    }

    public function editCompanySubmit() {
        $this->form_validation->set_rules($this->getPartnerValidationRules(true));

        if ($this->form_validation->run() == FALSE) {
            //forma nu e validata
            $user = $this->UserModel->getCompanyByPk($this->input->post("id_user"));
            $data['user'] = $user;
            $this->populate_form($user);
            $data["notification"] = array(
                "type" => "form_notification",
                "message" => validation_errors(),
                "cssClass" => "ui-state-error ui-corner-all"
            );
            $this->load_view_admin('admin/users/company/edit_company', $data);
        } else {
            //forma a fost validata
            $images = $this->upload_images($_FILES['image'], "application_uploads/company/" . $this->input->post("id_user"), false);
            $_POST['image'] = $images;

            try {
                $this->UserModel->updateCompany($_POST);
                $data['notification'] = array(
                    "type" => "form_notification",
                    "message" => "Userul a fost salvat cu success",
                    "cssClass" => "ui-state-highlight ui-corner-all"
                );
            } catch (\Exception $e) {
                //eroare inserare
                $data['notification'] = array(
                    "type" => "form_notification",
                    "message" => $e->getMessage(),
                    "cssClass" => "ui-state-error ui-corner-all"
                );
            }
            $user = $this->UserModel->getCompanyByPk($this->input->post("id_user"));
            $this->populate_form($user);
            $data['user'] = $user;


            $this->load_view_admin('admin/users/company/edit_company', $data);
        }
    }

    public function delete_user($params) {

        $this->UserModel->deleteUser($params[0]);

        header('Location:' . base_url('admin/users'));
    }

    private function validate_company() {
        $rules = array(
            "email" => array(
                "require" => true,
                "email" => true
            ),
            "company_name" => array(
                "require" => true
            ),
            "latitude" => array(
                "require" => true,
            ),
            "longitude" => array(
                "require" => true,
            ),
            "location" => array(
                "require" => true,
            ),
            "city" => array(
                "require" => true,
            ),
            "district_code" => array(
                "require" => true,
            ),
            "password" => array(
                "require" => true,
                "minlength" => 6
            ),
            "company_name" => array("Require" => true, "minlength" => 5),
        );



        $messages = array(
            "email" => array(
                "require" => "E-mail obligatoriu",
                "email" => "E-mail invalid"
            ),
            "password" => array(
                "require" => "Introduceti parola min 6 caractere",
                "minlength" => "Introduceti parola min 6 caractere"
            ),
            "location" => array(
                "require" => "Introduceti locatia",
            ),
            "company_name" => array(
                "require" => "Introduceti denumirea companiei",
            ),
            "latitude" => array(
                "require" => "Introduceti latitudinea",
            ),
            "longitude" => array(
                "require" => "Introduceti longitudinea",
            ),
            "city" => array(
                "require" => "Introduceti Orasul",
            ),
            "district_code" => array(
                "require" => "Introduceti Judetul",
            ),
            "company_name" => array(
                "Require" => "Nume companie obligatoriu",
                "minlength" => "Nume companie obligatoriu min 5 caractere")
        );

        $objValidator = new \NeoMvc\Libs\Validator($rules, $messages);
        return $objValidator;
    }

    private function getPartnerValidationRules($update = false) {
        $config = array(
            array(
                "field" => "username",
                "label" => "Username",
                "rules" => "required|xss_clean|min_length[3]"
            ),
            array(
                "field" => "email",
                "label" => "Email",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "email",
                "label" => "Email",
                "rules" => "required|valid_email|xss_clean"
            ),
            array(
                "field" => "company_name",
                "label" => "Nume Companie",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "commercial_name",
                "label" => "Nume Comercial",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "commercial_name",
                "label" => "Nume Comercial",
                "rules" => "required|xss_clean"
            ),
            array(
                "field" => "website",
                "label" => "Website",
                "rules" => ""
            ),
            array(
                "field" => "description",
                "label" => "Descriere",
                "rules" => ""
            ),
            array(
                "field" => "iban",
                "label" => "iban",
                "rules" => ""
            ),
            array(
                "field" => "bank",
                "label" => "bank",
                "rules" => ""
            ),
            array(
                "field" => "address",
                "label" => "adresa",
                "rules" => ""
            ),
            array(
                "field" => "phone",
                "label" => "phone",
                "rules" => ""
            ),
            array(
                "field" => "firstname",
                "label" => "firstname",
                "rules" => ""
            ),
            array(
                "field" => "lastname",
                "label" => "lastname",
                "rules" => ""
            ),
        );

        if (!$update)
            $config[] = array(
                "field" => "password",
                "label" => "Parola",
                "rules" => "required|xss_clean|min_length[6]"
            );
        return $config;
    }

}
?>
