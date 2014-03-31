<?php
/* @var $cart \Dealscount\Models\Entities\NeoCart */
/* @var $cartItems \Dealscount\Models\Entities\CartItem */
$cart = $this->view->getCartModel()->getCart();
$cartItems = $cart->getCartItems();
?>
<div id="cart_header" <?php if (count($cartItems) < 1) { ?> style=" margin-left:-120px;" <?php } ?>>
    <div class = "pointing_arrow"></div>
    <div class = "inner" <?php if (count($cartItems) < 1) {
    ?> style="width:220px;;" <?php } ?>>
         <?php if (count($cartItems) < 1) { ?>
            <div class="empty_cart">Nu exista niciun voucher in cos</div>
            <?php
        } else {
            ?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td class="title">
                        Cosul meu
                    </td>
                    <td class="discount">
                        Economie
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <?php
                            $total_economie=0;
                            foreach ($cartItems as $cartItem) {
                                $item = $cartItem->getItem();
                                ?>
                                <tr>
                                    <td width="60">
                                        <img width="50" src="<?php echo base_url($item->getMainImage()) ?>"/>
                                    </td>
                                    <td width="230" class="brief">
                                        <a href="<?php echo base_url('oferte/' . $item->getSlug()) ?>">
                                            <?php echo $item->getName() ?>
                                        </a>
                                    </td>
                                    <td width="65" style="text-align: right; padding-right: 10px;">
                                        <b style="font-size: 14px;"><?php echo "x" . $cartItem->getQuantity() ?></b>
                                    </td>
                                    <td style="text-align: right; padding-right: 10px;">
                                        <b style="font-size: 14px;"><?php $economie=($cartItem->getTotal($item->getPrice()) - $cartItem->getTotal($item->getVoucher_price())); $total_economie+=$economie; echo $economie; ?> lei</b>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" class="space"></td></tr>
                <tr>
                    <td class="download">
                        <a href="<?php echo base_url('cart') ?>"></a>
                    </td>
                    <td class="summary_discount">
                        Economisesti: <b><?php echo $total_economie?> lei</b>
                    </td>
                </tr>

            </table>
        <?php } ?>
    </div>
</div>