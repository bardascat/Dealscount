<?php

namespace Dealscount\Models;

use Doctrine\ORM\EntityManager;
use NeoMvc\Models\Entities as Entities;

class PagesModel extends \Dealscount\Models\AbstractModel {

    function __construct() {
        parent::__construct();
    }

    public function getPages() {
        $qb = $this->em->createQueryBuilder();
        $qb->select("p")
                ->from("Entities:SimplePage", "p")
                ->orderBy("p.id_page", "desc");

        $query = $qb->getQuery();
        //  $query->setQueryCacheDriver(new \Doctrine\Common\Cache\ApcCache());
        //  $query->useQueryCache(true);
        $query->execute();
        return $query->getResult();
    }

    public function getPageByPk($id_page) {
        return $this->em->find("Entities:SimplePage", $id_page);
    }

    public function getPageBySlug($slug) {
        return $this->em->getRepository("Entities:SimplePage")->findBy(array("slug" => $slug));
    }

    public function updatePage($post) {
        /* @var $page \NeoMvc\Models\Entities\SimplePage */
        $page = $this->em->find("Entities:SimplePage", $post['id_page']);
        $page->postHydrate($post);
        $this->em->persist($page);
        $this->em->flush($page);
        return true;
    }

}

?>
