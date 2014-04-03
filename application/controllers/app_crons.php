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
     * Pentru fiecare optiune vedem tipul si setam pozitia ofertei corespunzatoare in tabelul items
     */
    public function activate_options() {
        ob_start();
        echo '<pre>';
        //in fiecare noapte la ora 12:01 jobul reseteaza pozitiile ofertelor in home,categorie si subcategorie si newsletter
        echo "RESETEZ POZITIILE OFERTELOR<br/><br/>";
        $this->CronJobModel->resetItemsPosition();

        echo "<br/><br/>APLIC OPTIUNILE PE OFERTE<br/>";
        //dupa ce a resetat pozitiile aplica optiunile active
        $options = $this->CronJobModel->getCronOptions();
        foreach ($options as $active_option) {
            //nu ne intereseaza newsletterul personal
            if ($active_option->getOption()->getSlug() == DLConstants::$OPTIUNE_NEWSLETTER_PERSONAL)
                continue;
            $this->CronJobModel->setItemPosition($active_option->getUsed_on(), $active_option);
        }

        echo('<br/>DONE JOB----------------' . date("y-m-d H:i:s"));

        $log = ob_get_clean();

        echo $log;
        $this->CronJobModel->saveLog($log, "activate_options");

        exit();
    }

    //job notifica partenerul ca ii expira contul, url website/app_crons/notifyPartners?secret=secret&days_before_expiration=$x
    public function notifyPartners() {
        $nr_days_before=$_GET['days_before_expiration'];
        $this->CronJobModel->notifyPartners($nr_days_before);
    }

}

?>
