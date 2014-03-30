<?php

namespace Dealscount\Models;

/**
 * @author Bardas Catalin
 * date: Dec 29, 2011 
 */
class OffersModel extends \Dealscount\Models\AbstractModel {

    /**
     * @param type $post
     * @param type $id_operator
     * @return \Dealscount\Models\Entities\Item
     */
    public function addOffer($post, $id_operator) {
        $next_id = $this->getNextId("items");
        $item = new Entities\Item();

        //adaugam tagurile daca exista
        if ($post['tags']) {
            try {
                $this->em->createQuery("delete  Entities:ItemTags c where c.id_item=:id_item")
                        ->setParameter(":id_item", $post['id_item'])
                        ->execute();
            } catch (\Exception $e) {
                print_r($e->getMessage());
                exit();
            }
            $tags = explode(',', $post['tags']);
            foreach ($tags as $tag) {
                $tagEntity = new Entities\ItemTags();
                $tagEntity->setValue($tag);
                $item->addTag($tagEntity);
            }
        }

        foreach ($post['images'] as $image)
            $item->addImage($image);

        foreach ($post['categories'] as $category) {
            $category = $this->em->find("Entities:Category", $category);
            $categoryReference = new Entities\ItemCategories();
            $categoryReference->setCategory($category);
            $item->addCategory($categoryReference);
        }

        $item->postHydrate($post);
        if ($post['slug']) {
            $item->setSlug(\Dealscount\Util\NeoUtil::makeSlugs($post['slug'] . '-' . $next_id));
        } else
            $item->setSlug(\Dealscount\Util\NeoUtil::makeSlugs($post['name'] . '-' . $next_id));

        $item->setOperator($this->em->find("Entities:User", $id_operator));

//asociem partenerul
        $company = $this->em->find("Entities:User", $post['id_company']);
        $item->setCompany($company);

        //adaugam variantele
        $item = $this->addProductVariants($item);

        $this->em->persist($item);
        $this->em->flush();
        return $item;
    }

    public function simpleUpdate($offer) {
        $this->em->persist($offer);
        $this->em->flush();
        return true;
    }

    public function updateOffer($post, $id_operator) {

        $this->em->beginTransaction();
        
        $item = $this->getOffer($post['id_item']);
        $current_slug = $item->getSlug();

        $item->postHydrate($post);

        //daca operatorul doreste modificarea slugului
        if ($post['slug'] != substr($current_slug, 0, strripos($current_slug, '-'))) {
            $slug = $post['slug'];
            $item->setSlug(\Dealscount\Util\NeoUtil::makeSlugs($slug . '-' . $post['id_item']));
        } else
            $item->setSlug($current_slug);

        if (isset($post['images']))
            foreach ($post['images'] as $image)
                $item->addImage($image);

        //setam imaginea principala
        if (isset($_POST['primary_image'])) {
            $this->setPrimaryImage($_POST['primary_image']);
        }

        //asociem categoriile
        $this->em->createQuery("delete  Entities:ItemCategories c where c.id_item=:id_item")
                ->setParameter(":id_item", $post['id_item'])
                ->execute();

        foreach ($post['categories'] as $category) {
            $category = $this->em->find("Entities:Category", $category);
            $categoryReference = new Entities\ItemCategories();
            $categoryReference->setCategory($category);
            $item->addCategory($categoryReference);
        }

        //asociem partenerul
        $company = $this->em->find("Entities:User", $post['id_company']);
        $item->setCompany($company);

        $item->setUpdated_by($id_operator);

        //adaugam tagurile daca exista
        if ($post['tags']) {
            try {
                $this->em->createQuery("delete  Entities:ItemTags c where c.id_item=:id_item")
                        ->setParameter(":id_item", $post['id_item'])
                        ->execute();
            } catch (\Exception $e) {
                print_r($e->getMessage());
                exit();
            }
            $tags = explode(',', $post['tags']);
            foreach ($tags as $tag) {
                $tagEntity = new Entities\ItemTags();
                $tagEntity->setValue($tag);
                $item->addTag($tagEntity);
            }
        }

        //adaugam variantele
        $item = $this->addProductVariants($item);

        try {
            $this->em->persist($item);
            $this->em->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return true;
    }

    private function addProductVariants(Entities\Item &$item) {
        
        if (isset($_POST['id_variant'])) {
            $nr_variants = count($_POST['id_variant']);

//nr_atribute in total
            $nr_attributes = count($_POST['id_attribute']);

//cate atribute avem pe varianta
            $nr_attributes_each = $nr_attributes / $nr_variants;
            $indexAtribut = 0;
            for ($i = 0; $i < $nr_variants; $i++) {

//daca se face update la varianta
                if ($_POST['id_variant'][$i])
                    $variant = $this->em->find("Entities:ItemVariant", $_POST['id_variant'][$i]);
                else
                    $variant = new Entities\ItemVariant();

                for ($j = 0; $j < $nr_attributes_each; $j++) {

                    $id_attribute = $_POST['id_attribute'][$indexAtribut];

//atributul cu id-ul  1,2,3 sunt pentru pret,pret redus si descriere si se salveaza in tabelul de variante
                    if ($id_attribute == "1") {
                        $variant->setPrice($_POST['attribute_value'][$indexAtribut]);
                    }
                    if ($id_attribute == "2") {
                        $variant->setSale_price($_POST['attribute_value'][$indexAtribut]);
                    }
                    if ($id_attribute == "3") {
                        $variant->setDescription($_POST['attribute_value'][$indexAtribut]);
                    }
                    if ($id_attribute == "6") {
                        $variant->setActive($_POST['attribute_value'][$indexAtribut]);
                    }

                    //daca se face update la atribut
                    if ($_POST['id_attribute_value'][$indexAtribut]) {
                        $attributeValue = $this->em->find("Entities:AttributeValue", $_POST['id_attribute_value'][$indexAtribut]);
                        if (!$attributeValue)
                            exit("Fatal error: 12:04 Msg: Eroare la variante.");
                    } else {
                        /* @var $attrbute Entities\Attribute */
                        $attribute = $this->em->find("Entities:Attribute", $id_attribute);
                        if (!$attribute) {
                            exit("Fatal Error: 10:17 - Un atribut ales nu exista in sistem ID ATRIBUT: " . $id_attribute);
                        }
                        $attributeValue = new Entities\AttributeValue();
                        $attributeValue->setAttribute($attribute);
                    }

                    try {
                        $attributeValue->setValue($_POST['attribute_value'][$indexAtribut]);
                    } catch (\Exception $e) {
                        $this->em->rollback();
                        echo $e->getMessage();
                        exit();
                    }
                    $variant->addAtributeValue($attributeValue);
                    $indexAtribut++;
                }

                $item->addItemVariant($variant);
            }
        }

        $this->em->commit();
        return $item;
    }

    /**
     * @param type $id_variant
     * @param type $action
     * @return boolean
     */
    public function toggleVariant($id_variant, $action) {
        if ($action ==
                "active")
            $action = 1;
        else
            $action = 0;
        try {
            $updateQuery = "update Entities:ItemVariant variant set variant.active=:action where variant.id_variant=:id_variant";
            $deleteQuery = "delete Entities:ItemVariant variant where variant.id_variant=:id_variant";
            $this->em->createQuery($deleteQuery)
                    ->setParameter(":id_variant", $id_variant)->execute();
        } catch (Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
            exit();
        }


        return true;
    }

    public function getOffers() {

        $productsRep = $this->em->getRepository("Entities:Item");
        $products = $productsRep->findBy(array("item_type" => "offer"), array("id_item" => "DESC"));

        return

                $products;
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

    public function getActiveOffers() {
        $rsm = $this->getItemRsm();
        $query = "select items.* from items where items.active=1
        and items.start_date<=NOW()
        and items.end_date>=NOW()
        order by -home_position desc,createdDate desc
        ";
        $offers = $this->em->createNativeQuery($query, $rsm)->getResult();


        return

                $offers;
    }

    private function getItemRsm() {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult("Entities:Item", "i");
        $rsm->addFieldResult("i", "id_item", "id_item");
        $rsm->addFieldResult("i", "id_user", "id_user");
        $rsm->addFieldResult("i", "name", "name");
        $rsm->addFieldResult("i", "brief", "brief");
        $rsm->addFieldResult("i", "company_name", "company_name");
        $rsm->addFieldResult("i", "slug", "slug");
        $rsm->addFieldResult("i", "createdDate", "createdDate");
        $rsm->addFieldResult("i", "active", "active");
        $rsm->addFieldResult("i", "home_position", "home_position");
        $rsm->addFieldResult("i", "category_position", "category_position");
        $rsm->addFieldResult("i", "subcategory_position", "subcategory_position");
        $rsm->addFieldResult("i", "newsletter_position", "newsletter_position");
        $rsm->addFieldResult("i", "id_stats", "id_stats");
        $rsm->addFieldResult("i", "location", "location");
        $rsm->addFieldResult("i", "city", "city");
        $rsm->addFieldResult("i", "terms", "terms");
        $rsm->addFieldResult("i", "benefits", "benefits");
        $rsm->addFieldResult("i", "price", "price");
        $rsm->addFieldResult("i", "voucher_price", "voucher_price");
        $rsm->addFieldResult("i", "sale_price", "sale_price");
        $rsm->addFieldResult("i", "start_date", "start_date");
        $rsm->addFieldResult("i", "end_date", "end_date");
        $rsm->addFieldResult("i", "end_date", "end_date");


        return $rsm;
    }

    public function getNewsletterOffers() {
        try {
            $rsm = $this->getItemRsm();
            $query = "select items.* from items where items.active=1
        and items.start_date<=NOW()
        and items.end_date>=NOW()
        order by -newsletter_position desc,createdDate desc
        ";
            $offers = $this->em->createNativeQuery($query, $rsm)->getResult();


            return $offers;
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
        if (!
                $offer)
            throw new \Exception('Invalid offer id');

        return $offer;
    }

    /**
     * 
     * @param type $id_offer
     * @return \Dealscount\Models\Entities\Item
     */
    public function getOfferBySlug($slug) {
        $offerRep = $this->em->getRepository("Entities:Item");
        $offers = $offerRep->findBy(array("slug" => $slug, 'active' => 1));
        if (isset(
                        $offers[0]))
            return $offers[0];
        else
            return false;
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

        if (count(
                        $result) < 0)
            return false;
        else
            return $result;
    }

    /**
     * 
     * Intoarce lista de oferte ce sunt in categoria cautata sau in subcategoriile categoriei trimise ca parametru
     * @param type $id_category
     * @return boolean
     */
    public function getOffersByParentCategory($category_slug) {

        $categoriesModel = new CategoriesModel();
        $category = $categoriesModel->getCategoryBySlug($category_slug);
        if (!
                $category)
            return false;

        $childs = $categoriesModel->getChilds($category->getId_category());
        $parent = $category->getParent();

        $in = "";
        foreach ($childs as $child) {
            $in.=$child[0]->getId_category() . ',';
        }

        $in = substr($in, 0, -1);

        try {
            //daca este categorie adica nu are parinte ordonam dupa category_position
            //daca este subcategorie adica are parinte ordonam dupa subcategory_position
            $rsm = $this->getItemRsm();
            $query = "select items.* from items 
                left join item_categories using(id_item)
                where id_category in ($in) 
                and items.active=1
                and items.start_date<=NOW()
                and items.end_date>=NOW()
                order by " . (!$parent ? "-category_position" : "-subcategory_position" ) . " desc,createdDate desc
        ";

            $offers = $this->em->createNativeQuery($query, $rsm)->getResult();

            return $offers;
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
        $this->em->
                flush();
    }

    public function setPrimaryImage($id_image) {

        $image = $this->em->find("Entities:ItemImage", $id_image);

        //setam imaginea principala
//scoatem imaginile care erau principale in trecut
        $this->em->createQuery("update Entities:ItemImage p set p.primary_image=null where p.primary_image is not null and p.id_item=:id_item")
                ->setParameter(":id_item", $image->getItem()->getId_item())
                ->execute();
//setam imaginea principala
        $this->em->createQuery("update Entities:ItemImage p set p.primary_image=1 where p.id_image=:id_image")
                ->setParameter(":id_image", $image->getId_image())
                ->execute();



        return true;
    }

    public function adminSearchOffers($searchQuery) {
        try {
            $result = $this->em->createQueryBuilder()
                    ->select("i")
                    ->from("Entities:Item", "i")
                    ->where("1=1");

            if (isset($searchQuery ['keywords']) && $searchQuery['keywords']) {
                $result->andWhere("i.name like :name");
                $result->setParameter(":name", '%' . $searchQuery ['keywords'] . '%');
            }

            if (isset($searchQuery ['id_company']) && $searchQuery['id_company']) {
                $result->andWhere("i.id_user=:id_user");
                $result->setParameter(":id_user", $searchQuery['id_company']);
            }

            if (isset($searchQuery ['from']) && $searchQuery['from']) {
                $result->andWhere("i.createdDate>=:from");
                $result->setParameter(":from", $searchQuery['from']);
            }

            if (isset($searchQuery['to']) && $searchQuery['to']) {
                $result->andWhere("i.createdDate<=:to");
                $result->setParameter(":to", $searchQuery['to']);
            }
            $result->orderBy("i.createdDate", "desc");
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $result->getQuery()->
                        getResult();
    }

    public function searchOffers($searchQuery) {

        try {
            $result = $this->em->createQueryBuilder()
                    ->select("i")
                    ->from("Entities:Item", "i")
                    ->where("i.name like :name")
                    ->andWhere("i.active=1")
                    ->andWhere("i.end_date>CURRENT_TIMESTAMP()")
                    ->andWhere("i.start_date<=CURRENT_TIMESTAMP()")
                    ->setParameter(":name", '%' . $searchQuery . '%')
                    ->setMaxResults(50)
                    ->orderBy("i.createdDate", "desc")
                    ->getQuery()
                    ->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return

                $result;
    }

    public function increment_offer_view($id_item) {
        $item = $this->getOffer($id_item);
        if (!$item->getStats()) {
            //nu avem linia de statistici o inseram
            $stats = new Entities\ItemStats();
            $stats->setId_item($item->getIdItem());
            $this->em->persist($stats);
            $this->em->flush();
        }

        $qb = $this->em->createQueryBuilder();
        $qb->update("Entities:ItemStats", 'stats')
                ->set("stats.views", 'stats.views+1')
                ->where('stats.id_item=:id_item')
                ->setParameter(":id_item", $id_item)
                ->getQuery()
                ->
                execute();
    }

    public function getStatsByCity(Entities\User $user, $id_item = false) {

        $stm = $this->em->getConnection()->prepare("
           SELECT users.city, sum( quantity ) as sales
            FROM orders_items
            join items on(orders_items.id_item=items.id_item)
            JOIN orders
            USING ( id_order )
            JOIN users on (orders.id_user=users.id_user)
            where items.id_user=:id_user
            " . ($id_item ? ' and orders_items.id_item =:id_item ' : false) . "
            GROUP BY users.city
            order by sales desc
           ");

        $stm->bindParam(":id_user", $user->getId_user());
        if (
                $id_item)
            $stm->bindParam(":id_item", $id_item);

        $stm->execute();
        $result = $stm->fetchAll();

        if (count(
                        $result) < 1)
            return false;

        $total_sales = 0;
        foreach ($result as $city) {
            $total_sales+=$city['sales'];
        }

        //calculate percentage y=(sales*100/)total_sales
        foreach ($result as $key => $city) {
            $city['percentage'] = round(($city ['sales'] * 100) / $total_sales, 1);
            $result[$key] = $city;
        }
        return $result;
        exit(
                'done');
    }

    public function getStatsByGender(Entities\User $user, $id_item = false) {

        $stm = $this->em->getConnection()->prepare("
           SELECT users.gender, sum( quantity ) as sales
            FROM orders_items
            join items on(orders_items.id_item=items.id_item)
            JOIN orders
            USING ( id_order )
            JOIN users on(orders.id_user=users.id_user)
            
            where items.id_user=:id_user
            " . ($id_item ? ' and orders_items.id_item =:id_item ' : false) . "
            GROUP BY gender
            order by sales desc
           ");

        $stm->bindParam(":id_user", $user->getId_user());
        if (
                $id_item)
            $stm->bindParam(":id_item", $id_item);
        $stm->execute();
        $result = $stm->fetchAll();

        if (count(
                        $result) < 1)
            return false;

        $total_sales = 0;
        foreach ($result as $gender) {
            $total_sales+=$gender['sales'];
        }

        //calculate percentage y=(sales*100/)total_sales
        foreach ($result as $key => $gender) {
            $gender['percentage'] = round(($gender ['sales'] * 100) / $total_sales, 1);
            $result[$key] = $gender;
        }
        return

                $result;
    }

    public function getStatsByAge(Entities\User $user, $id_item = false) {

        $stm = $this->em->getConnection()->prepare("
           SELECT age, sum( quantity ) as sales
            FROM orders_items
            join items on(orders_items.id_item=items.id_item)
            JOIN orders
            USING ( id_order )
            JOIN users on(orders.id_user=users.id_user)
            where items.id_user=:id_user
            " . ($id_item ? ' and orders_items.id_item =:id_item ' : false) . "
            GROUP BY age
            order by sales desc
           ");

        $stm->bindParam(":id_user", $user->getId_user());
        if (
                $id_item)
            $stm->bindParam(":id_item", $id_item);
        $stm->execute();
        $result = $stm->fetchAll();

        if (count(
                        $result) < 1)
            return false;

        $total_sales = 0;
        foreach ($result as $age) {
            $total_sales+=$age['sales'];
        }

        //calculate percentage y=(sales*100/)total_sales
        foreach ($result as $key => $age) {
            $age['percentage'] = round(($age ['sales'] * 100) / $total_sales, 1);
            $result[$key] = $age;
        }

        return

                $result;
    }

    public function getPartnerDashboardStats(Entities\User $user, $from = false, $to = false) {

        $stats = array("total_sales" => 0, "total_views" => 0, "confirmed" => 0);

        //determinam numarul total de viuzlizari
        $stm = $this->em->getConnection()->prepare("
            SELECT sum(views) as total_views,sum(sales) as total_sales
            FROM items join items_stats using(id_item)
            where id_user=:id_user
           ");

        $stm->bindParam(":id_user", $user->getId_user());
        $stm->execute();
        $result = $stm->fetchAll();
        if (isset($result[0][
                        'total_views']))
            $stats['total_views'] = $result[0]['total_views'];

        //nr vanzari
        $vanzari = "select sum(quantity) as sales from 
           orders_items
           join orders using(id_order)
           join items using(id_item)
           where items.id_user=:id_user
            ";
        if ($from && $to) {
            $vanzari.=' and (:from<=DATE_FORMAT(orders.orderedOn,"%Y-%m-%d") and DATE_FORMAT(orders.orderedOn,"%Y-%m-%d")<=:to)';
        }


        $stm = $this->em->getConnection()->prepare($vanzari);
        $stm->bindParam(":id_user", $user->getId_user());
        if ($from && $to) {
            $stm->bindParam(":from", $from);
            $stm->bindParam(":to", $to);
        }
        $stm->execute();
        $result = $stm->fetchAll();
        if ($result[0][
                'sales'])
            $stats['total_sales'] = $result[0]['sales'];

        //adaucam si numarul de vouchere folosite
        $confirmed = "SELECT count(*) as confirmed FROM `orders_vouchers`
            join orders_items on(orders_vouchers.id_order_item=orders_items.id)
            join items using(id_item)
            where used=1
            and id_user=:id_user ";
        if ($from && $to) {

            $confirmed.=' and (:from<=DATE_FORMAT(orders_vouchers.used_at,"%Y-%m-%d") and DATE_FORMAT(orders_vouchers.used_at,"%Y-%m-%d")<=:to)';
        }


        $stm = $this->em->getConnection()->prepare($confirmed);
        $stm->bindParam(":id_user", $user->getId_user());
        if ($from && $to) {
            $stm->bindParam(":from", $from);
            $stm->bindParam(":to", $to);
        }

        $stm->execute();
        $result = $stm->fetchAll();
        if ($result[0][
                'confirmed'])
            $stats['confirmed'] = $result[0]['confirmed'];


        return $stats;
    }

    /**
     * Intoarce lista de utilizatori cu 
     * numarul de vouchere cumparate si numarul de vouchere folosite
     * @param \Dealscount\Models\Entities\User $partener
     */
    public function getUsersStats(Entities\User $partener) {
        $sql_vanzari = "SELECT users.id_user,users.lastname,users.firstname, sum( quantity ) AS sales
            FROM orders_items
            JOIN items ON ( orders_items.id_item = items.id_item )
            JOIN orders
            USING ( id_order )
            JOIN users ON ( orders.id_user = users.id_user )
            where items.id_user=:id_user
            GROUP BY users.id_user order by sales desc limit 70";
        $con = $this->em->getConnection($sql_vanzari);
        $stm = $con->prepare($sql_vanzari);
        $stm->bindParam(":id_user", $partener->getId_user());
        $stm->execute();
        $r = $stm->fetchAll();

        if (count(
                        $r) < 1)
            return false; else {
            $sql_confirmed = "
                SELECT count(*) as confirmed
            FROM orders_vouchers
            join orders_items on (orders_vouchers.id_order_item=orders_items.id)
            JOIN items ON ( orders_items.id_item = items.id_item )
            JOIN orders
            USING ( id_order )
	    where used=1
            and items.id_user=:id_partener
            and orders.id_user=:id_user
                ";
            foreach ($r as $key => $row) {
                $stm = $con->prepare($sql_confirmed);
                $stm->bindParam(":id_partener", $partener->getId_user());
                $stm->bindParam(":id_user", $row['id_user']);
                $stm->execute();
                $r2 = $stm->fetchAll();
                if (isset($r2[0]['confirmed']))
                    $row['confirmed'] = $r2[0]['confirmed'];
                $r[$key] = $row;
            }
        }

        return $r;
    }

}

?>
