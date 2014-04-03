<?php

namespace Dealscount\Models;

/**
 *
 * @author Neo aka Bardas Catalin
 */
class CronJobModel extends AbstractModel {

    // intoarce optiunile care trebuie activate de cron in data curenta
    /**
     * @return \Dealscount\Models\Entities\ActiveOption
     */
    public function getCronOptions() {
        $cDate = date("Y-m-d");
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("o")
                ->from("Entities:ActiveOption", "o")
                ->where("o.scheduled=:cdate")
                ->andWhere("o.activated is null")
                ->setParameter(":cdate", $cDate)
                ->getQuery()
                ->getResult();
        if (count($result) < 1) {
            $log = array(
                'status' => "success",
                'msg' => "Nu am gasit nicio oferta pe care sa activez optiune"
            );
            print_r($log);
        }


        return $result;
    }

    public function setItemPosition($id_item, Entities\ActiveOption $active_option) {
        /* @var $item \Dealscount\Models\Entities\Item */
        $log = array();
        $item = $this->em->find("Entities:Item", $id_item);
        if (!$item) {
            $log = array(
                'status' => "error",
                'msg' => "Oferta cu id-ul " . $item->getId_item() . ' nu exista'
            );
        }

        switch ($active_option->getOption()->getSlug()) {
            case \DLConstants::$OPTIUNE_OFERTA_PROMOVATA: {
                    $item->setHome_position($active_option->getPosition());
                }break;
            case \DLConstants::$OPTIUNE_OFERTA_PROMOVATA_CATEGORIE: {
                    $item->setCategory_position($active_option->getPosition());
                }break;
            case \DLConstants::$OPTIUNE_OFERTA_PROMOVATA_SUBCATEGORIE: {
                    $item->setSubcategory_position($active_option->getPosition());
                }break;
            case \DLConstants::$OPTIUNE_PROMOVARE_NEWSLETTER: {
                    $item->setNewsletter_position($active_option->getPosition());
                }break;
        }
        $log = array(
            'status' => "success",
            'msg' => "Am setat optiunea " . $active_option->getOption()->getSlug() . " id=" . $active_option->getId() . " pentru oferta " . $item->getId_item() . " pe pozitia " . $active_option->getPosition()
        );
        $active_option->setActivated(new \DateTime("now"));

        $this->em->persist($active_option);
        $this->em->persist($item);
        $this->em->flush();
        echo '<pre>';
        print_r($log);
        echo '-------------------------------<br/>';
    }

    /*
     * Luam toate ofertele din ziua precedenta care au avut optiuni active si le setam pozitia null
     */

    public function resetItemsPosition() {
        //$cDate = date("Y-m-d", strtotime(date("Y-m-d") . ' -1 day'));
        //selectez toate ofertele care sutn promovate
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("i")
                ->from("Entities:Item", "i")
                ->where("i.home_position is not null")
                ->orWhere("i.category_position is not null")
                ->orWhere("i.newsletter_position is not null")
                ->orWhere("i.subcategory_position is not null")
                ->getQuery()
                ->getResult();
        if (count($result) < 1) {
            $log = array(
                'status' => "success",
                'msg' => "Nu am gasit nicio oferta a carei optiune sa fie dezactivata"
            );
            print_r($log);
            return false;
        }

        echo '<pre>';
        foreach ($result as $item) {

            /* @var $item  */
            $log = array(
                'status' => "success",
                'msg' => "Am resetat pozitia pentru   oferta " . $item->getId_item()
            );

            $item->setHome_position(null);
            $item->setCategory_position(null);
            $item->setNewsletter_position(null);
            $item->setSubcategory_position(null);
        }
        $this->em->persist($item);
        $this->em->flush();
        print_r($log);
    }

    public function saveLog($log, $job_name) {
        $stm = $this->em->getConnection()->prepare("insert into job_log (cdate,data,job_name) values (:cdate,:data,:job_name)");
        $stm->bindParam(":cdate", date("Y-m-d H:i:s"));
        $stm->bindParam(":data", $log);
        $stm->bindParam(":job_name", $job_name);

        $stm->execute();
    }

    //selectam toti partenerii carora le vor expira conturile dupa $days_before zile
    public function notifyPartners($days_before) {
        $log = "";
        //construim data cand notificam partenerul din data curenta + nr de zile
        $available_to = date("Y-m-d", strtotime(date("Y-m-d") . ' +' . $days_before . " days"));


        /* @var $partners \Dealscount\Models\Entities\User */
        $qb = $this->em->createQueryBuilder();
        $partners = $qb->select("u")
                ->from("Entities:User", "u")
                ->join("u.company", "company")
                ->where("company.available_to=:available_to")
                ->setParameter(":available_to", $available_to)
                ->getQuery()
                ->getResult();
        if (count($partners) < 1) {
            $log.="Nu am gasit niciun partener al carei valabilitati expira peste " . $days_before . " zile";
            return false;
        } else {

            foreach ($partners as $user) {
                $log.="Am notificat utilizatorul:" . $user->getId_user() . "<br/><br/>";
                ob_start();
                require_once("application/views/mailMessages/partner_notifying.php");
                $body = ob_get_clean();
                $subject = "Contul dumneavoastra expira in " . $days_before . " zile.";
                $user->setEmail("catalin.bardas@codesphere.ro");
                \NeoMail::genericMail($body, $subject, $user->getEmail());
            }
        }

        print_r($log);
        $this->saveLog($log, "notifyPartnersForExpirationBefore" . $days_before . "days");
    }

}
