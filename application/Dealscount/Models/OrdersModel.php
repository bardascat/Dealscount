<?php

/**
 *
 * @author Bardas Catalin
 * 
 */

namespace Dealscount\Models;

class OrdersModel extends AbstractModel {

    public function PaginateOrders($page = 1, $limit = 100) {
        try {
            $query = $this->em->createQuery("select orders from Entities:Order  orders  order by orders.id_order desc")
                    ->setFirstResult(( $page * $limit) - $limit)
                    ->setMaxResults($limit);
            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
            return $paginator;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

    public function searchOrders($searchQuery) {
        try {
            $result = $this->em->createQueryBuilder()
                    ->select("orders")
                    ->from("Entities:Order", "orders")
                    ->join("orders.user", 'u')
                    ->where("orders.order_number like :searchQuery")
                    ->orWhere("orders.id_order like :searchQuery")
                    ->orWhere("u.nume like :searchQuery")
                    ->orWhere("u.email like :searchQuery")
                    ->setParameter(":searchQuery", '%' . $searchQuery . '%')
                    ->getQuery()
                    ->execute();

            return $result;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Intoarce un orderItem dupa Id
     * @param type $id_item
     * @return \NeoMvc\Models\Entities\OrderItem
     */
    public function getOrderItem($id_item) {
        $orderItem = $this->em->find("Entities:OrderItem", $id_item);
        return $orderItem;
    }

    /**
     * Cauta comanda dupa id-ul voucherului
     * @param type $id_voucher
     * @return Entities\Order
     */
    public function getVoucherOrder($id_voucher) {
        try {
            $result = $this->em->createQuery("select o,oi,ov
            from Entities:Order o
            join o.orderItems oi
            join oi.vouchers ov
            where ov.id_voucher=:id_voucher")
                    ->setParameter(":id_voucher", $id_voucher)
                    ->execute();
            if (isset($result[0]))
                return $result[0];
            else
                return false;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
        exit();
    }


    /**
     * 
     * @param type $id_voucher
     * @return \Dealscount\Models\Entities\OrderVoucher
     */
    public function getVoucherByPk($id_voucher) {
        $voucher = $this->em->find("Entities:OrderVoucher", $id_voucher);
        return $voucher;
    }

    public function updateVoucher($id_voucher, $recipient_name) {
        try {
            $this->em->createQuery("update Entities:OrderVoucher v set v.recipientName=:name where v.id_voucher=:id ")
                    ->setParameter(":name", $recipient_name)
                    ->setParameter(":id", $id_voucher)
                    ->execute();
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

    /**
     *  Metoda folosita de admini pentru a adauga un voucher suplimentar la o comanda.
     * @param type $post
     */
    public function addVoucher($post) {
        $recipientName = $post['recipient_name'];
        $id_orderItem = $post['idOrderItem'];
        $orderItem = $this->getOrderItem($id_orderItem);
        $order = $orderItem->getOrder();
        $item = $orderItem->getItem();

        //recalculam totalul dupa adaugarea unui nou voucher
        $orderItem->setQuantity($orderItem->getQuantity() + 1);
        $orderItem->setTotal($orderItem->getTotal() + $item->getSale_price() * 1);
        $order->setTotal($order->getTotal() + $item->getSale_price() * 1);

        //adaugam voucherul
        $voucher = new Entities\OrderVoucher();
        $voucher->setRecipientName($recipientName);

        $code = "GAD" . $order->getId_order() . 'V' . substr(uniqid(), -4);
        $voucher->setCode(strtoupper($code));

        $orderItem->addVoucher($voucher);
        $order->addOrderItem($orderItem);
        $this->em->persist($order);
        $this->em->flush();
        return true;
    }

    /**
     * Stergem un voucher din comanda.
     * Implicatii:
     * -recalcularea totalului de plata
     * -recalcularea costului total per OrderItem
     * -scaderea cantitatii orderItemului
     * -stergerea voucherului
     * @param type $id_voucher
     * @return boolean
     */
    public function deleteVoucher($id_voucher) {
        /* @var $voucher Entities\OrderVoucher */
        /* @var $orderItem Entities\OrderItem */
        $voucher = $this->em->find("Entities:OrderVoucher", $id_voucher);
        $orderItem = $voucher->getOrderItem();
        $orderItem->setQuantity($orderItem->getQuantity() - 1);
        $item = $orderItem->getItem();
        $orderItem->setTotal($orderItem->getTotal() - $item->getSale_price());

        $order = $orderItem->getOrder();
        $order->setTotal($order->getTotal() - $item->getSale_price());
        $order->addOrderItem($orderItem);
        $this->em->persist($order);
        $this->em->remove($voucher);
        $this->em->flush();
        return true;
    }

    /**
     * 
     * @param type $id_order
     * @return \Dealscount\Models\Entities\Order
     */
    public function getOrderByPk($id_order) {
        return $this->em->find("Entities:Order", $id_order);
    }

    /**
     * 
     * @param type $id_order
     * @return \Dealscount\Models\Entities\Order
     */
    public function getOrderByCode($code) {
        $order = $this->em->getRepository("Entities:Order")->findBy(array("order_number" => $code));
        if (isset($order[0]))
            return $order[0];
        else
            return false;
    }

    public function updateOrder($post, \NeoMvc\Controllers\Admin\orders $OrdersController = null) {
        $id_order = $post['id_order'];
        $order = $this->getOrderByPk($id_order);


        $cost_transport_initial = $order->getShipping_cost();

        $order->postHydrate($post);
        if ($order->getShippingAddress()) {
            $order->getShippingAddress()->postHydrate($post);
            //setam judetul
            $district_code = $order->getShippingAddress()->getShipping_district_code();
            $cargusDistrict = $this->em->getRepository("Entities:CargusDistrict")->findBy(array("district_code" => $district_code));
            if (!$cargusDistrict[0])
                exit("Eroare: judetul ales este invalid ! ");
            $order->getShippingAddress()->setShipping_district($cargusDistrict[0]->getDistrict());
        }


        //resetam pretul total daca s-a modificat pretul de transport
        if ($order->getShipping_cost() != $cost_transport_initial) {
            $order->setTotal($order->getTotal() - $cost_transport_initial + $order->getShipping_cost());
        }

        // Ne ocupam de facturi
        $this->ManageInvoice($order, $OrdersController);

        //daca starea este procesata trimite un mail omului
        $this->ManageUserNotification($order);

        $this->em->persist($order);
        $this->em->flush();

        return true;
    }

    private function ManageInvoice(&$order, $ordersController) {
        $InvoiceModel = new InvoiceModel();
        //daca este livrat si nu are factura generata, o generam acum in baza de date


        if ($order->getOrderStatus() == "F" && !$order->getInvoice()) {


            $invoice = $InvoiceModel->createInvoice($order);
            if ($invoice) {
                $order->setInvoice($invoice);
                $file = $ordersController->generateInvoice($order);

                //trimitem factura pe mail
                $email = $order->getUser()->getEmail();
                ob_start();
                require_once("mailMessages/sendInvoice.php");
                $body = ob_get_clean();
                $subject = "Factura comenzii nr. " . $order->getOrderNumber();
                NeoMail::getInstance()->genericMailAttach($body, $subject, $email, array($file));
            }
        }
        //factura este generata dar comanda nu este livrata => dezactivam factura
        elseif ($order->getInvoice() && $order->getOrderStatus() != "F") {
            $order->getInvoice()->setActive(0);
            \NeoMvc\Controllers\controller::set_alert_message("Factura a fost dezactivata pentru ca ati modificat statusul comenzii ca fiind nelivrata.");
        }
        //daca factura este generata dar inactiva si comanda este livrata
        elseif ($order->getInvoice() && $order->getInvoice()->getActive() == 0 && $order->getOrderStatus() == "F") {
            $order->getInvoice()->setActive(1);
            \NeoMvc\Controllers\controller::set_alert_message("Factura a fost din nou activata.");
        }
    }

    private function ManageUserNotification(Entities\Order &$order) {
        if ($order->getOrderStatus() == "P" && (!$order->getMail_notification())) {
            $order->setMail_notification(1);
            $email = $order->getUser()->getEmail();
            ob_start();
            require_once("mailMessages/comandaProcesata.php");
            $body = ob_get_clean();
            $subject = "Confirmare procesare comandă nr. " . $order->getOrderNumber();
            NeoMail::getInstance()->genericMail($body, $subject, $email);
        }
    }

    /**
     * Verifica daca a fost generat vreun awb pentru comanda 
     */
    public function findAWB($id_order) {
        try {
            $r = $this->em->createQuery("select 1 from Entities:OrderItem oi where oi.awb is not null and oi.id_order=$id_order")
                    ->execute();
            if (isset($r[0]))
                return true;
            else
                return false;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Adauga inca un item la comanda existenta
     * @param type $post
     */
    public function addOrderItem($post) {


        $order = $this->getOrderByPk($post['id_order']);
        /* @var $item Entities\Item */
        $item = $this->em->find("Entities:Item", $post['id_item']);

        $orderItem = new Entities\OrderItem();
        $orderItem->setQuantity($post['quantity']);
        $orderItem->setStatus(\DLConstants::$ORDER_STATUS_CONFIRMED);
        $orderItem->setItem($item);
        $offer = $item;
        $orderItem->setTotal($offer->getSale_price() * $orderItem->getQuantity());
        $beneficiar = $post['beneficiar'];
        $voucher = new Entities\OrderVoucher();
        $voucher->setRecipientName($beneficiar);
        $voucher->setIs_gift(0);
        $code = "GAD" . $order->getId_order() . 'V' . substr(uniqid(), -4);
        $voucher->setCode($code);
        $orderItem->addVoucher($voucher);
        //daca a fost adaugat un nou produs comanda nu mai este confirmata
        $order->setTotal($order->getTotal() + $orderItem->getTotal());
        $order->addOrderItem($orderItem);
        $this->em->persist($order);
        $this->em->flush();
        return true;
    }

    public function resetAwbCode($awb) {
        $this->em->createQuery("update Entities:OrderItem oi set oi.awb=NULL where oi.awb=:awb")
                ->setParameter(":awb", $awb)
                ->execute();
        return true;
    }

    public function setOrderItemAWb(Entities\OrderItem $orderItem) {

        $this->em->createQuery("update Entities:OrderItem oi set oi.awb=:awb where oi.id=:id")
                ->setParameter(":awb", $orderItem->getAwb())
                ->setParameter(":id", $orderItem->getId())
                ->execute();

        return true;
    }

    /**
     * Modifica cantitatea produselor din comanda
     * @param type $post
     */
    public function updateOrderItemQuantity($post) {
        $orderItem = $this->getOrderItem($post['id_orderItem']);
        $item = $orderItem->getItem();
        $new_price = $post['quantity'] * $item->getSale_price();
        /* @var $order Entities\Order */
        $order = $orderItem->getOrder();

        //din totalul de plata scadem totalul itemului vechi si il adaugam pe cel nou
        $order->setTotal($order->getTotal() - $orderItem->getTotal() + $new_price);
        $orderItem->setTotal($new_price);
        $orderItem->setQuantity($post['quantity']);

        $order->addOrderItem($orderItem);
        $this->em->persist($order);
        $this->em->flush();
        return true;
    }

    public function setOrderPaymentStatus($status, Entities\Order $order) {
        try {
            $this->em->createQuery("update Entities:Order o set o.payment_status=:status where o.id_order=:id")
                    ->setParameter(":id", $order->getId_order())
                    ->setParameter(":status", $status)
                    ->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * Schimba statusul unui item.
     * @param type $params
     * @return boolean
     */
    public function setOrderItemStatus($params) {
        $id_orderItem = $params[0];
        $status = $params[1];
        $orderItem = $this->getOrderItem($id_orderItem);
        $order = $orderItem->getOrder();

        try {
            $this->em->createQuery("update Entities:OrderItem o set o.status=:status where o.id=:id")
                    ->setParameter(":id", $id_orderItem)
                    ->setParameter(":status", $status)
                    ->execute();
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
            exit();
        }
        return true;
    }

    /*
     * Scoate un item din comanda
     */

    public function deleteOrderItem($id_orderItem) {

        $orderItem = $this->getOrderItem($id_orderItem);

        $order = $orderItem->getOrder();
        //scadem din total pretul itemului
        $order->setTotal($order->getTotal() - $orderItem->getTotal());

        $this->em->persist($order);
        $this->em->remove($orderItem);
        $this->em->flush();
        return true;
    }

    public function deleteOrder($id_order) {
        $order = $this->em->getReference("Entities:Order", $id_order);
        $this->em->remove($order);
        $this->em->flush();
        return true;
    }

    /**
     * Cauta voucherul dupa cod
     * @param type $code
     * @return array
     */
    public function getVoucherByCode($id_item, $code = false) {
        $conn = $this->em->getConnection();
        $query = "select ov.* from orders_vouchers ov
        join orders_items oi on (ov.id_order_item=oi.id)
        where oi.id_item=:id_item
        ";
        if ($code)
            $query.=" and code=:code";
        $stm = $conn->prepare($query);
        if ($code)
            $stm->bindParam(":code", $code);
        $stm->bindParam(":id_item", $id_item);
        $r = $stm->execute();
        $r = $stm->fetchAll();
        if (!isset($r[0]))
            return false;
        else
            return $r;
    }
    
        /**
     * Cauta comanda dupa id-ul voucherului
     * @param type $id_voucher
     * @return Entities\Order
     */
    public function searchVouchers($query,$id_user) {
        try {
            $result = $this->em->createQueryBuilder()
                    ->select("orders,orderItems,items")
                    ->from("Entities:Order", "orders")
                    ->join("orders.user", 'u')
                    ->join("orders.orderItems","orderItems")
                    ->join("orderItems.item","items")
                    ->where("items.name like :searchQuery")
                    ->orWhere("items.brief like :searchQuery")
                    ->andWhere("orders.id_user=:id_user")
                    ->setParameter(":searchQuery", '%' . $query . '%')
                    ->setParameter("id_user", $id_user)
                    ->getQuery()
                    ->execute();
                    
            return $result;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
        exit();
    }

    /**
     * Seteaza voucherul ca folosit sau nu
     * @param type $id_voucher
     * @param type $status
     */
    public function toggleUsedVoucher($id_voucher, $status) {

        $qb = $this->em->getConnection()->createQueryBuilder();
        try {
            $qb->update("orders_vouchers", "ov")
                    ->set("ov.used", $status)
                    ->where("ov.id_voucher=:id")
                    ->setParameter(":id", $id_voucher)
                    ->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return true;
    }

    /*
     * Intoarce numarul de vouchere comandate
     */

    public function getNrVouchersOrder($id_order) {
        $dql = $this->em->createQuery("
            select sum(oi.quantity) as nr_items from Entities:OrderItem oi
            where oi.id_order=:id_order");

        $dql->setParameter(":id_order", $id_order);
        $r = $dql->getResult();

        if (!$r[0]['nr_items'])
            $nr_items = 0;
        else {
            $r = $r[0];
            $nr_items = $r['nr_items'];
        }
        return $nr_items;
    }

}

?>
