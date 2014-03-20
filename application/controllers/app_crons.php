<?php

class app_crons extends \CI_Controller {

    private $CronJobModel;
    private $OffersModel;
    private $PartnerModel;
    private $User;

    function __construct() {
        parent::__construct();
        $this->CronJobModel = new \Dealscount\Models\CronJobModel();
        $this->OffersModel = new \Dealscount\Models\OffersModel();
        $this->PartnerModel = new \Dealscount\Models\PartnerModel();
        if (!isset($_GET['secret']) || $_GET['secret'] != DLConstants::$CRON_ACCESS) {
            show_404();
        }
    }

    public function index() {
        
    }

    /**
     * Activeaza una din cele 4 optiuni
     * Ofera promovata 
     * Ofera promovata in categorie 
     * Ofera promovata in subcategorie 
     * Promovare Newsletter 
     * 
     * Mod de functionare:
     * Selectam toate optiunile din tabelul active_options care sunt de tipul de mai sus
     * si care sunt programate pentru ziua curenta.
     * Pentru fiecare optiune vedem tipul si setam pozitia corespunzatoare in tabelul items
     */
    public function activate_options() {
        $options = $this->CronJobModel->getCronOptions();
        foreach ($options as $active_option) {
            //nu ne intereseaza newsletterul personal
            if ($active_option->getOption()->getSlug() == DLConstants::$OPTIUNE_NEWSLETTER_PERSONAL)
                continue;
            $this->CronJobModel->setItemPosition($active_option->getUsed_on(), $active_option);
        }

        exit('DONE JOB');
    }

    public function resetItemsPositon() {
        $this->CronJobModel->resetItemsPosition();
        exit('DONE JOB');
    }

}
?>
