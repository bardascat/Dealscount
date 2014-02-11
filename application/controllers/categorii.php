<?php

class categorii extends CI_Controller {

    private $OffersModel = null;

    public function __construct() {
        parent::__construct();
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    public function load_categories() {
        $category_slug = null;


        if ($this->uri->segment(2)) {
            $parent_category_slug = $this->uri->segment(2);

            $parent_category = $this->CategoriesModel->getCategoryBySlug($parent_category_slug);
            if (!$parent_category)
                exit('Page not found');
        } else
            exit('Page not found');

        if ($this->uri->segment(3)) {
            $child_category_slug = $this->uri->segment(3);

            $child_category = $this->CategoriesModel->getCategoryBySlug($child_category_slug);
            if (!$child_category)
                exit('Page not found');
        }
        
        if(isset($child_category)) $category=$child_category;
        else
            $category=$parent_category;
        
        
        $offers = $this->OffersModel->getOffersByParentCategory($category->getSlug());
        
        $data = array(
            "offers" => $offers
        );
        if (!$offers)
            $data['no_data'] = "Momentan nu sunt oferte adaugate";

        
        $this->load_view('index/landing', $data);
    }

}
