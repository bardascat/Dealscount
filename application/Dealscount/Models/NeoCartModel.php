<?php

/**
 * Description of neocart_model
 * @author Bardas Catalin
 * date: feb , 2014
 */

namespace Dealscount\Models;

class NeoCartModel extends AbstractModel {

    public function addToCart($post, Entities\NeoCart $cart) {

        $cartItem = new Entities\CartItem();
        //get item
        $item = $this->em->find("Entities:Item", $post['id_item']);
        $cartItem->setItem($item);

        $cartItem->setQuantity($post['quantity']);
        if (isset($post['size']))
            $cartItem->setSize($post['size']);

        $cartItem->setId_cart($cart->getId_cart());

        if (isset($post['is_gift'])) {
            $cartItem->setIs_gift(1);
            $cartItem->setDetails($post['details']);
        }

        if (isset($post['id_variant']))
            $cartItem->setItemVariant($this->getItemVariant($post['id_variant']));

        //setam unique hash. Acest hash este generat de atributele ce fac cartitem-ul unic=> id_cart,id_item
        $cartItem->setUniqueHash();

        //Verificam daca produsul cu acelasu hash a mai fost adaugat in cos. Daca da facem update la cantitate
        if ($this->tryUpdateQuantity($cart, $cartItem)) {
            return true;
        }

        $cart->addCartItem($cartItem);
        $this->em->persist($cart);
        $this->em->flush();

        return true;
    }

    /**
     * @param \Dealscount\Models\Entities\NeoCart $cart
     * @param \Dealscount\Models\Entities\CartItem $cartItem
     * @return boolean
     */
    private function tryUpdateQuantity(Entities\NeoCart $cart, Entities\CartItem $cartItem) {

        $rows = $this->em->createQuery("update Entities:CartItem c set c.quantity=c.quantity+:quantity where c.unique_hash=:hash")
                ->setParameter(":hash", $cartItem->getUnique_hash())
                ->setParameter(":quantity", $cartItem->getQuantity())
                ->execute();
        //in rows vedem cate linii au fost updatate. Daca rows>0 inseamna ca a facut un update
        if ($rows)
            return true;
        else
            return false;
    }

    public function createCart(Entities\NeoCart $cart) {
        $this->em->persist($cart);
        $this->em->flush();
        return true;
    }

    /**
     * Intoarce shopping cartul in functie de cookie. Daca nu exista il creeaza
     * @param type $hash
     * @return \Dealscount\Models\Entities\NeoCart
     */
    public function getCart($hash = false) {
        if (!$hash)
            $hash = \CI_Controller::getCartHash();

        $cartRep = $this->em->getRepository("Entities:NeoCart");

        $cart = $cartRep->findBy(array("hash" => $hash));

        if (isset($cart[0]))
            return $cart[0];
        else {
            //trebuie sa generam un cart
            $cart = new Entities\NeoCart();

            $cart->setHash($hash);
            $this->em->persist($cart);
            $this->em->flush($cart);
            return $cart;
        }
    }

    /**
     * Face update la cantitatea unui item din cart
     * @param type $post
     * @return Boolean
     */
    public function updateQuantity($post) {
        $cartItem = $this->getCartItemByPk($post['cartItem']);
        $remove = false;

        if (isset($post['plus']))
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        else {
            //stergem itemul
            if ($cartItem->getQuantity() <= 1) {
                $remove = true;
            }
            $cartItem->setQuantity($cartItem->getQuantity() - 1);
        }
        if ($remove)
            $this->em->remove($cartItem);
        else
            $this->em->persist($cartItem);

        $this->em->flush();
    }

    public function deleteCartItem($id_item) {

        $dql = $this->em->createQuery("delete from Entities:CartItem item where item.id=:id_item");
        $dql->setParameter(":id_item", $id_item);
        $dql->execute();
        return true;
    }

    public function getNrItems() {
        $hash = \CI_Controller::getCartHash();
        if (!$hash)
            return 0;

        $dql = $this->em->createQuery("
            select sum(cartItems.quantity) as nr_items from Entities:NeoCart cart join cart.CartItems cartItems
            where cart.hash=:hash");

        $dql->setParameter(":hash", $hash);
        $r = $dql->getResult();
        if (!$r[0]['nr_items'])
            $nr_items = 0;
        else {
            $r = $r[0];
            $nr_items = $r['nr_items'];
        }
        return $nr_items;
    }

    /**
     * Intoarce un obiect cartItem
     * @param type $id
     * @return Entities\CartItem
     */
    public function getCartItemByPk($id) {
        $cartItem = $this->em->find("Entities:CartItem", $id);
        return $cartItem;
    }

    public function emptyCart() {

        $dql = $this->em->createQuery('delete Entities:NeoCart cart where cart.hash=:hash');
        $dql->setParameter(":hash", \CI_Controller::getCartHash());
        $dql->execute();
        return true;
    }

    /**
     * 
     * @param \Dealscount\Models\Entities\User $user
     * @param type $params
     * @return \Dealscount\Models\Entities\Order
     */
    public function insertOrder(Entities\User $user, $params) {
        $nextOrderId = $this->getNextId("orders", "id_order");

        //luam shopping cart
        $cart = $this->getCart(\CI_Controller::getCartHash());
        if (!$cart) {
            redirect(base_url());
            exit();
        }

        $cartItems = $cart->getCartItems();

        if (!count($cartItems)) {
            //nu are nimic in cos
            redirect(base_url());
            exit();
        }
        $order = new Entities\Order();

        $total = 0;
        /**
         * Generam item-urile comenzii
         */
        foreach ($cartItems as $cartItem) {
            
            $orderItem = new Entities\OrderItem();

            $item = $cartItem->getItem();
            $orderItem->setQuantity($cartItem->getQuantity());
            $orderItem->setTotal($cartItem->getTotal($item->getSale_price()));
            $orderItem->setItem($item);


            if ($cartItem->getItemVariant())
                $orderItem->setItemVariant($cartItem->getItemVariant());

           
            $total+=$orderItem->getTotal();

            /**
             * Observatie: item-ul poate fi facut si cadou atunci mai avem in post pe langa nume si emailul prietenului
             */
            for ($i = 0; $i < $orderItem->getQuantity(); $i++) {
                $voucher = new Entities\OrderVoucher();
                $voucher->setRecipientName($params['name_' . $cartItem->getId()][$i]);
                if ($cartItem->getIs_gift()) {
                    $voucher->setRecipientEmail($params['email_' . $cartItem->getId()][$i]);
                    $voucher->setIs_gift(1);
                }
                $code = \DLConstants::$CODE_PREFIX . $nextOrderId . 'V' . substr(uniqid(), -4);
                $voucher->setCode(strtoupper($code));
                $orderItem->addVoucher($voucher);
            }

            $order->addOrderItem($orderItem);
        }

        //generam 4 cifre pentru orderCode
        $date = new \DateTime();
        $stamp = $date->getTimestamp();
        $last_four = substr($stamp, -4);

        $order->setPayment_method($params['payment_method']);

        //rate
        if (isset($post['installments']))
            $order->setInstallments($post['installments']);

        $order->setShipping_cost($this->getShippingCost($params, $total));
        $order->setTotal($total + $order->getShipping_cost());
        $order->setUser($user);
        $orderCode = \DLConstants::$CODE_PREFIX . $nextOrderId . 'O' . $last_four;
        $order->setOrderNumber($orderCode);


        //daca comanda contine doar cupoane gratuite este confirmata automat
        $order->setPayment_status(\DLConstants::$PAYMENT_STATUS_CONFIRMED); // 
        $order->setOrderStatus(\DLConstants::$ORDER_STATUS_CONFIRMED);
        $order->setMail_notification(1);

        $this->em->persist($order);
        $this->em->persist($user);

        try {
            $this->em->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }

        $this->emptyCart();
        return $order;
    }

    /**
     * @param \Dealscount\Models\Entities\User $user
     * @param \Dealscount\Models\Entities\SubscriptionOption $option
     * @return \Dealscount\Models\Entities\SubscriptionOptionOrder
     */
    public function buySubscriptionOption(Entities\User $user, Entities\SubscriptionOption $option, $params) {
        $nextOrderId = $this->getNextId("subscription_options_order", "id_option_order");
        $order = new Entities\SubscriptionOptionOrder();

        $total = $option->getSale_price() * $params['quantity'];
        $order->setQuantity($params['quantity']);
        $order->setOption($option);
        //generam 4 cifre pentru orderCode
        $date = new \DateTime();
        $stamp = $date->getTimestamp();
        $last_four = substr($stamp, -4);

        $order->setPayment_method($params['payment_method']);
        $order->setPayment_status(\DLConstants::$PAYMENT_STATUS_PENDING);
        $order->setTotal($total);
        $order->setCompany($user->getCompanyDetails());
        $orderCode = \DLConstants::$CODE_PREFIX . $nextOrderId . 'O' . $last_four;
        $order->setOrder_number($orderCode);
        $this->em->persist($order);
        $this->em->persist($user);

        try {
            $this->em->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
        }
        return $order;
    }

    public function getShippingCost($params, $total) {
        //cupoanele nu au  taxa de transport
        return 0;

        $tax = 0;
        switch ($params['payment_method']) {
            case "card": {
                    $tax = 12;
                }break;
            case "op": {
                    $tax = 12;
                }break;
            case "ramburs": {
                    $tax = 17;
                }break;
            case "free": {
                    $tax = 0;
                }break;
            default: {
                    exit("Err:12:00 Payment method not implemented");
                }break;
        }
        return $tax;
    }

    /**
     * Genereaza fisierele pdf cu vouchere, si intoarce locatia lor pe server
     */
    public function generateVouchers(Entities\Order $order) {

        $vouchers_list = array();
        $orderItems = $order->getItems();
        foreach ($orderItems as $orderItem) {

            $offer = $orderItem->getItem();
            $company = $offer->getCompany();
            $companyDetails = $company->getCompanyDetails();
            $vouchers = $orderItem->getVouchers();
            foreach ($vouchers as $voucher) {

                $file = "application_uploads/vouchers/" . $order->getId_order() . '/' . $voucher->getId_voucher() . '.pdf';
                ob_start();
                require('application/views/popups/voucher.php');
                $voucherHtml = ob_get_clean();

                require_once("application/libraries/mpdf54/mpdf.php");
                $mpdf = new \mPDF('utf-8', array(190, 536), '', 'Arial', 2, 2, 2, 2, 2, 2);
                $mpdf->WriteHTML(utf8_encode($voucherHtml));

                if (!is_dir("application_uploads/vouchers/" . $order->getId_order()))
                    mkdir("application_uploads/vouchers/" . $order->getId_order(), 0777);
                $mpdf->Output($file);
                $vouchers_list[] = $file;
            }
        }
        if (count($vouchers_list) < 1)
            return false;
        else
            return $vouchers_list;
    }

    /**
     * 
     * @param type $id_variant
     * @return \Dealscount\Models\Entities\ItemVariant
     * @throws \Exception
     */
    public function getItemVariant($id_variant) {
        $variant = $this->em->find("Entities:ItemVariant", $id_variant);
        if (!$variant)
            throw new \Exception("Invalid id_variant");

        return $variant;
    }

}

?>
