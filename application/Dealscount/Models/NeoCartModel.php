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
    public function getCart($hash) {

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

        $hash = \NeoMvc\Controllers\controller::getHash();
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
        $dql->setParameter(":hash", \NeoMvc\Controllers\NeoCart::getHash());
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
        $cart = $this->getCart(\NeoMvc\Controllers\NeoCart::getHash());
        if (!$cart) {
            header('Location: ' . URL);
            exit();
        }

        $cartItems = $cart->getCartItems();
        if (!count($cartItems)) {
            //nu are nimic in cos
            header("Location: " . URL . 'cart');
            exit();
        }
        $order = new Entities\Order();

        $total = 0;
        /**
         * Generam item-urile comenzii
         */
        /* @var $cartItem Entities\CartItem */
        foreach ($cartItems as $cartItem) {
            $orderItem = new Entities\OrderItem();

            $item = $cartItem->getItem();

            /* @var $itemDetails Entities\Product */ // sau Entities\Offer
            $itemDetails = $item->getItemDetails();

            $orderItem->setQuantity($cartItem->getQuantity());
            $orderItem->setTotal($cartItem->getTotal($itemDetails->getSale_price()));
            $orderItem->setItem($item);
            if ($cart->hasOnlyOffers())
                $orderItem->setStatus("F");
            else
                $orderItem->setStatus("W");
            //daca itemul are varianta o adaugam
            if ($cartItem->getProductVariant())
                $orderItem->setProductVariant($cartItem->getProductVariant());

            $total+=$orderItem->getTotal();

            /**
             * Daca Itemul este oferta, atunci trebuie sa adaugam vouchere
             * Observatie: item-ul poate fi facut si cadou atunci mai avem in post pe langa nume si emailul prietenului
             */
            if ($item->getItem_type() == "offer") {
                for ($i = 0; $i < $orderItem->getQuantity(); $i++) {
                    $voucher = new Entities\OrderVoucher();
                    $voucher->setRecipientName($post['name_' . $cartItem->getId()][$i]);
                    if ($cartItem->getIs_gift()) {
                        $voucher->setRecipientEmail($post['email_' . $cartItem->getId()][$i]);
                        $voucher->setIs_gift(1);
                    }
                    $code = "ORV" . $nextOrderId . 'V' . substr(uniqid(), -4);
                    $voucher->setCode($code);
                    $orderItem->addVoucher($voucher);
                }
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

        if (isset($post['christmas_shipping']))
            $order->setChristmas_shipping(1);

        $order->setShipping_cost($this->getShippingCost($params, $total));
        $order->setTotal($total + $order->getShipping_cost());
        $order->setUser($user);
        $orderCode = "ORO" . $nextOrderId . 'O' . $last_four;
        $order->setOrderNumber($orderCode);

        //daca comanda contine doar cupoane este confirmata automat
        if ($cart->hasOnlyOffers()) {
            $order->setPayment_status("F"); // 
            $order->setOrderStatus("F");
            $order->setMail_notification(1);
        }

        /**
         * Adresa de livrare/facturare. Doar atunci cand comanda contine si produse
         * Sunt 2 situatii:
         *  1. Userul decide ca vrea o adresa de livrare noua si atunci id-ul adresei de livrare este new.
         *  2. Userul alege o adresa de livrare deja existenta
         */
        if (!$cart->hasOnlyOffers()) {
            if ($post['shipping_address_id'] == "new") {
                $shippingAddress = new Entities\ShippingAddress();
                $shippingAddress->postHydrate($post);
                $cargusDistrict = $this->em->getRepository("Entities:CargusDistrict")->findBy(array("district_code" => $shippingAddress->getShipping_district_code()));
                if (isset($cargusDistrict[0]))
                    $shippingAddress->setShipping_district($cargusDistrict[0]->getDistrict());
                else
                    $shippingAddress->setShipping_district($post['shipping_district_code']);
                $user->setShippingAddresses($shippingAddress);
            }
            else {
                $shippingAddress = $this->em->find("Entities:ShippingAddress", $post['shipping_address_id']);
            }

            if (!$shippingAddress) {
                exit("Eroare: 1:22. Adresa de livrare aleasă nu există");
            }

            /* Daca datele omului nu sunt completate le luam din adresa de livrare */
            if (!$user->getNume())
                $user->setNume($shippingAddress->getShipping_name());

            if (!$user->getPhone())
                $user->setPhone($shippingAddress->getShipping_phone());

            /**
             * Adresa de facturare
             */
            $billingAddress = new Entities\BillingAddress();
            //factura persoana juridica

            if (isset($post['new_billing_address'])) {
                $billingAddress->postHydrate($post);
                $billingAddress->setBilling_type("legal");
            }
            //factura persoana fizica, datele de pe pe factura sunt aceleasi ca cele din adresa de livrare
            else {
                $billingAddress->setIndividualDetails($shippingAddress);
                $billingAddress->setBilling_type("individual");
            }

            //adaugam noua adresa de facturare la user
            $user->setBillingAddresses($billingAddress);

            $order->setShippingAddress($shippingAddress);
            $order->setBillingAddress($billingAddress);

            //setam numele si telefonul userului din adresa de livrare, daca nu sunt setate
            if (!$user->getNume())
                $user->getNume($shippingAddress->getShipping_name());

            if (!$user->getPhone())
                $user->getNume($shippingAddress->getShipping_phone());
        } //end adresa de facturare/livrare

        $this->em->persist($order);
        $this->em->persist($user);
        $this->em->flush();
        $this->emptyCart();
        return $order;
    }

    public function getShippingCost($params, $total) {
        //daca suma dapaseste 250 lei transprot grauit
        if ($total >= \NeoMvc\Controllers\controller::TRANSPORT_GRATIS)
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

        if (isset($params['christmas_shipping']))
            $tax = $tax + (20 - $tax);


        return $tax;
    }

    /**
     * Genereaza fisierele pdf cu vouchere, si intoarce locatia lor pe server
     */
    public function generateVouchers(Entities\Order $order) {

        $vouchers_list = array();
        $orderItems = $order->getItems();
        foreach ($orderItems as $orderItem) {

            if ($orderItem->getItem()->getItem_type() == "offer") {
                $item = $orderItem->getItem();
                $offer = $item->getOffer();
                $company = $item->getCompany();
                $companyDetails = $company->getCompanyDetails();
                $vouchers = $orderItem->getVouchers();
                foreach ($vouchers as $voucher) {

                    $file = "application_uploads/vouchers/" . $order->getId_order() . '/' . $voucher->getId_voucher() . '.pdf';
                    ob_start();
                    require('views/popups/voucher.php');
                    $voucherHtml = ob_get_clean();
                    require_once("NeoMvc/Libs/mpdf54/mpdf.php");
                    $mpdf = new \mPDF('utf-8', array(190, 536), '', 'Arial', 2, 2, 2, 2, 2, 2);
                    $mpdf->WriteHTML(utf8_encode($voucherHtml));

                    if (!is_dir("application_uploads/vouchers/" . $order->getId_order()))
                        mkdir("application_uploads/vouchers/" . $order->getId_order(), 0777);
                    $mpdf->Output($file);
                    $vouchers_list[] = $file;
                }
            }
        }
        if (count($vouchers_list) < 1)
            return false;
        else
            return $vouchers_list;
    }

}

?>
