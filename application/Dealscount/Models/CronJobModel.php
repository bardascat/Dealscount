<?php

namespace Dealscount\Models;

/**
 *
 * @author Neo aka Bardas Catalin
 */
class CronJobModel extends AbstractModel {

    // intoarce optiunile care trebuie activate de cron
    /**
     * @return \Dealscount\Models\Entities\ActiveOption
     */
    public function getCronOptions() {
        $cDate = date("Y-m-d");
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("o")
                ->from("Entities:ActiveOption", "o")
                ->where("o.scheduled=:cdate")
                ->setParameter(":cdate", $cDate)
                ->getQuery()
                ->getResult();
        if (count($result) < 1)
            $log = array(
                'status' => "success",
                'msg' => "Nu am gasit nicio oferta pe care sa activez optiune"
            );

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
            'msg' => "Am setat optiunea " . $active_option->getOption()->getSlug() . " pentru oferta " . $item->getId_item() . " pe pozitia " . $active_option->getPosition()
        );

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
        $cDate = date("Y-m-d", strtotime(date("Y-m-d") . ' -1 day'));

        $qb = $this->em->createQueryBuilder();
        $result = $qb->select("o")
                ->from("Entities:ActiveOption", "o")
                ->where("o.scheduled=:cdate")
                ->setParameter(":cdate", $cDate)
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
        foreach ($result as $active_option) {
            $id_item = $active_option->getUsed_on();
            /* @var $item \Dealscount\Models\Entities\Item */
            $item = $this->em->find("Entities:Item", $id_item);

            $log = array(
                'status' => "success",
                'msg' => "Am resetat pozitia pentru  optiunea " . $active_option->getOption()->getSlug() . " pentru oferta " . $item->getId_item() . ". Fosta pozitie " . $active_option->getPosition()
            );


            switch ($active_option->getOption()->getSlug()) {
                case \DLConstants::$OPTIUNE_OFERTA_PROMOVATA: {
                        $item->setHome_position(null);
                    }break;
                case \DLConstants::$OPTIUNE_OFERTA_PROMOVATA_CATEGORIE: {
                        $item->setCategory_position(null);
                    }break;
                case \DLConstants::$OPTIUNE_OFERTA_PROMOVATA_SUBCATEGORIE: {
                        $item->setSubcategory_position(null);
                    }break;
                case \DLConstants::$OPTIUNE_PROMOVARE_NEWSLETTER: {
                        $item->setNewsletter_position(null);
                    }break;
            }
            $this->em->persist($item);
            $this->em->flush();
            print_r($log);
        }
    }

}
