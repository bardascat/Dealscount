<?php

/**
 * Feb 05 2014
 * @author Bardas Catalin @ bardascat@gmail.com
 */
class Categories extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->CategoriesModel = new Dealscount\Models\CategoriesModel();
    }

    /**
     * @AclResource Admin: Categorii: Lista Categorii
     */
    public function categories_list() {
        $category_type = $this->uri->segment(4);
       
        if (!$category_type)
            $category_type == "offer";

        $this->view->setPage_name("Administrare Categorii");
        $menu = $this->CategoriesModel->createAdminList($category_type);
        $this->load_view_admin('admin/categories/categories_list.php', array("menu" => $menu));
    }

    /**
     * @AclResource Admin: Categorii: Adauga Categorie
     */
    public function add_category() {
        if ($_POST['category_name']) {

            if (count($_FILES['thumb']) > 0) {
                $images = $this->upload_images($_FILES['thumb'], "application_uploads/categories", false);
                $_POST['thumb'] = $images;
            }
            $this->CategoriesModel->addCategory($_POST);
            header('Location: ' . $this->agent->referrer());
        }
    }

    /**
     * @AclResource Admin: Categorii: Sterge Categorie
     */
    public function deleteCategory() {
        if ($_POST['id_category'])
            $this->CategoriesModel->deleteCategory($_POST['id_category']);
        header('Location: ' . $this->agent->referrer());
    }

    public function get_ajax_category_data() {

        if (isset($_POST['id_category'])) {

            $category_data = $this->CategoriesModel->get_ajax_category_data($_POST['id_category']);
            echo json_encode(array("name" => $category_data->getName(), "id_category" => $category_data->getId_category(), "id_parent" => $category_data->getId_parent()));
            exit();
        }
    }

    /**
     * @AclResource Admin: Categorii: Modifica Categorie
     */
    public function updateCategory() {

        if ($_POST['category_name']) {
            if ($_FILES['thumb']['name'][0]) {
                $images = $this->upload_images($_FILES['thumb'], "application_uploads/categories", false, false);
                $_POST['thumb'] = $images;
            }
            if ($_FILES['cover']['name'][0]) {
                $images = $this->upload_images($_FILES['cover'], "application_uploads/categories", false, false);
                $_POST['cover'] = $images;
            }
            if ($_FILES['menuImage']['name'][0]) {
                $images = $this->upload_images($_FILES['menuImage'], "application_uploads/categories", false, false);
                $_POST['menuImage'] = $images;
            }


            $this->CategoriesModel->updateCategory($_POST);
             header('Location: ' . $this->agent->referrer());
        }
    }

    public function setNrItemsCategories() {
        $this->CategoriesModel->setNrItemsCategories();
        echo "Am recalculat nr de produse din categorii.";
    }

}

?>
