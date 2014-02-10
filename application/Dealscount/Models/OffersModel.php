<?php

namespace Dealscount\Models;

/**
 * Description of login_model
 * @author Bardas Catalin
 * date: Dec 29, 2011 
 */
class OffersModel extends \Dealscount\Models\AbstractModel {

    public function addOffer($post, $id_operator) {
        $next_id = $this->getNextId("items");
        $item = new Entities\Item();
        $item->setName($post['name']);
        $item->setSlug(\Dealscount\Util\NeoUtil::makeSlugs($post['name'] . '-' . $next_id));

        foreach ($post['images'] as $image)
            $item->addImage($image);

        foreach ($post['categories'] as $category) {
            $category = $this->em->find("Entities:Category", $category);
            $categoryReference = new Entities\ItemCategories();
            $categoryReference->setCategory($category);
            $item->addCategory($categoryReference);
        }

        $item->postHydrate($post);
        $item->setOperator($this->em->find("Entities:User", $id_operator));

//asociem partenerul
        $company = $this->em->find("Entities:User", $post['id_company']);
        $item->setCompany($company);

        $this->em->persist($item);
        $this->em->flush();
        return true;
    }

    public function updateOffer($post, $id_operator) {

        $item = $this->getOffer($post['id_item']);
        $item->postHydrate($post);

        if (isset($post['images']))
            foreach ($post['images'] as $image)
                $item->addImage($image);

//setam imaginea principala
        if (isset($_POST['primary_image'])) {
//scoatem imaginile care erau principale in trecut
            $this->em->createQuery("update Entities:ItemImage p set p.primary_image=null where p.primary_image is not null and p.id_item=:id_item")
                    ->setParameter(":id_item", $post['id_item'])
                    ->execute();
//setam imaginea principala
            $this->em->createQuery("update Entities:ItemImage p set p.primary_image=1 where p.id_image=:id_image")
                    ->setParameter(":id_image", $post['primary_image'])
                    ->execute();
        }

//daca se modifica categoria
        if ((!$item->getCategory()) || $item->getCategory()->getId_category() != $post['categories'][0]) {
//stergem ascorierele de categorii
            $this->em->createQuery("delete  Entities:ItemCategories c where c.id_item=:id_item")
                    ->setParameter(":id_item", $post['id_item'])
                    ->execute();

            $category = $this->em->find("Entities:Category", $post['categories'][0]);
            $categoryReference = new Entities\ItemCategories();
            $categoryReference->setCategory($category);
            $item->addCategory($categoryReference);
        }
        else
            $category = $item->getCategory();

//asociem partenerul
        $company = $this->em->find("Entities:User", $post['id_company']);
        $item->setCompany($company);

        $item->setUpdated_by($id_operator);

  
        //adaugam tagurile
        if ($post['tags']) {
            try{
            $this->em->createQuery("delete  Entities:ItemTags c where c.id_item=:id_item")
                    ->setParameter(":id_item", $post['id_item'])
                    ->execute();
            }catch(\Exception $e){
                print_r($e->getMessage());
                exit();
            }
            $tags = explode(',', $post['tags']);
            foreach ($tags as $tag) {
                $tagEntity= new Entities\ItemTags();
                $tagEntity->setValue($tag);
                $item->addTag($tagEntity);
            }
        }

        try {
            $this->em->persist($item);
            $this->em->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return true;
    }

    public function getOffers() {

        $productsRep = $this->em->getRepository("Entities:Item");
        $products = $productsRep->findBy(array("item_type" => "offer"), array("id_item" => "DESC"));
        return $products;
    }

    public function PaginateOffers($page = 1, $limit = 30) {
        try {
            $query = $this->em->createQuery("select item from Entities:Item  item  order by item.id_item desc")
                    ->setFirstResult(( $page * $limit) - $limit)
                    ->setMaxResults($limit);

            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);

            return $paginator;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

    public function getActiveOffers($limit = 10, $page = 1) {

        try {
            $offers = $this->em->createQueryBuilder()
                    ->select("i")
                    ->from("Entities:Item", "i")
                    ->join("i.offer", "o")
                    ->where("i.item_type='offer'")
                    ->andWhere("i.active=1")
                    ->andWhere("o.end_date>CURRENT_TIMESTAMP()")
                    ->andWhere("o.start_date<=CURRENT_TIMESTAMP()")
                    ->orderBy("o.end_date", "asc")
                    ->setFirstResult(( $page * $limit) - $limit)
                    ->setMaxResults($limit)
                    ->getQuery();

            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($offers);

            return $paginator;
        } catch (\Exception $e) {
            echo $e->getMessage();
        };

        return $offers;
    }

    /**
     * 
     * @param type $id_offer
     * @return \Dealscount\Models\Entities\Item
     */
    public function getOffer($id_offer) {
        $offer = $this->em->find("Entities:Item", $id_offer);
        return $offer;
    }

    public function getNrVouchersBought($id_item) {

        $query = "select count(id_voucher) as nr_vouchers from orders_vouchers ov
            join orders_items oi on(ov.id_order_item=oi.id)
            where oi.id_item=:id_item
            ";
        $stm = $this->em->getConnection()->prepare($query);
        $stm->bindParam(":id_item", $id_item);
        $stm->execute();
        $r = $stm->fetchAll();
        return $r[0]['nr_vouchers'];
    }

    /**
     * Intoarce lista de oferte ce sunt stric in cateoria respectiva
     * @param type $id_category
     * @return Item
     */
    public function getOffersByCategory($id_category) {
        $dql = $this->em->createQuery("select items from Entities:Item items join items.ItemCategories c where c.id_category=:id_category and items.item_type='offer'");
        $dql->setParameter(":id_category", $id_category);

        $result = $dql->getResult();

        if (count($result) < 0)
            return false;
        else
            return $result;
    }

    /**
     * 
     * Intoarce lista de oferte ce sunt in categoria cautata sau in subcategorii
     * @param type $id_category
     * @return boolean
     */
    public function getOffersByParentCategory($id_category, $page) {
        $limit = 13;
        $categoriesModel = new Models\CategoriesModel();
        $childs = $categoriesModel->getChilds($id_category);

        $in = "";
        foreach ($childs as $child) {
            $in.=$child[0]->getId_category() . ',';
        }

        $in = substr($in, 0, -1);

        try {
            $qb = $this->em->createQueryBuilder();

            $offers = $qb->select("i")
                    ->from("Entities:Item", "i")
                    ->join("i.offer", "o")
                    ->join('i.ItemCategories', 'cat')
                    ->add('where', $qb->expr()->in('cat.id_category', $in))
                    ->andWhere("i.item_type='offer'")
                    ->andWhere("i.active=1")
                    ->andWhere("o.end_date>CURRENT_TIMESTAMP()")
                    ->andWhere("o.start_date<=CURRENT_TIMESTAMP()")
                    ->orderBy("o.end_date", "asc")
                    ->setFirstResult(( $page * $limit) - $limit)
                    ->setMaxResults($limit)
                    ->getQuery();



            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($offers);

            return $paginator;
        } catch (\Exception $e) {
            echo $e->getMessage();
        };
    }

    public function deleteOffer($id_offer) {
        $product = $this->em->getReference("Entities:Item", $id_offer);
        $this->em->remove($product);
        try {
            $this->em->flush();
        } catch (\Exception $e) {
            echo "<b>Item-ul nu poate fi sters. Exista comenzi asociate acestui item !</br></br></b>";
            echo $e->getMessage();

            exit();
        }
    }

    public function delete_image($id_image) {
        $image = $this->em->find("Entities:ItemImage", $id_image);
        $this->em->remove($image);
        $this->em->flush();
    }

    public function searchOffers($searchQuery) {
        try {
            if (isset($_GET['pagina']))
                $startForm = ($_GET['pagina'] * 30) - 30;
            else
                $startForm = 0;

            $query = "select count(id_item) as nr_items from items where name like :name";
            $stm = $this->em->getConnection()->prepare($query);
            $stm->bindValue(":name", '%' . $searchQuery . '%');
            $stm->execute();
            $nr_results = $stm->fetchAll();

            $result = $this->em->createQueryBuilder()
                    ->select("items")
                    ->from("Entities:Item", "items")
                    ->where("items.name like :name")
                    ->join("items.offer", "o")
                    ->andWhere("items.item_type='offer'")
                    ->andWhere("items.active=1")
                    ->andWhere("o.end_date>CURRENT_TIMESTAMP()")
                    ->andWhere("o.start_date<=CURRENT_TIMESTAMP()")
                    ->setParameter(":name", '%' . $searchQuery . '%')
                    ->setFirstResult($startForm)
                    ->setMaxResults(30)
                    ->orderBy("o.end_date", "asc")
                    ->getQuery()
                    ->execute();
            return array("nr_items" => $nr_results[0]['nr_items'], "result" => $result);
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

}

?>
