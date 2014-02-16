<?php

/**
 * Description of index
 * @author Bardas Catalin
 * date: Dec 28, 2011 
 */
class pages extends CI_Controller {

    private $PagesModel;

    function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->library('form_validation');

        $this->setAccessLevel(DLConstants::$ADMIN_LEVEL);
        $this->PagesModel = new Dealscount\Models\PagesModel();
    }

    /**
     * @AclResource "Admin: Editeaza Pagina"
     */
    public function edit_page() {
        if ($this->uri->segment(4)) {
            $page = $this->PagesModel->getPageByPk($this->uri->segment(4));
            if (!$page)
                exit('page not found');
            $this->populate_form($page);
            $this->load_view_admin('admin/pages/edit_page', array("page" => $page));
        } else
            exit("Page not found");
    }
    
    public function updatePageSubmit() {

        $this->PagesModel->updatePage($_POST);
        header('Location: ' . $this->agent->referrer());
    }

}
