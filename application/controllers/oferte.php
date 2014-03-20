<?php

class oferte extends CI_Controller {

    private $OffersModel = null;

    public function __construct() {
        parent::__construct();
        $this->OffersModel = new Dealscount\Models\OffersModel();
    }

    public function index() {
        echo 'index';
    }

    public function view() {
        $slug = $this->uri->segment(2);
        $offer = $this->OffersModel->getOfferBySlug($slug);
        if (!$offer)
            show_404 ();

        $data = array(
            "offer" => $offer
        );
        $this->view->setMetaTitle(($offer->getMeta_title() ? $offer->getMeta_title() : $offer->getName()));
        $this->view->setMetaDesc(($offer->getMeta_desc() ? $offer->getMeta_desc() : $offer->getBrief()));
        $this->view->setMetaKeywords($offer->getTagsInfo());
        
        $this->load_view('oferte/view', $data);
    }

    public function add_to_cart() {
        $id_item = $this->uri->segment(3);
        if (!is_numeric($id_item))
            exit('page not found');

        //get offer
        $offer = $this->OffersModel->getOffer($id_item);
        if (!$offer) {
            exit('page not found');
        }

        echo $offer->getName();
    }

    public function increment_offer_view() {
        $id_item = $this->input->post("id_item");

        if ($id_item)
            $this->OffersModel->increment_offer_view($id_item);
    }

}
