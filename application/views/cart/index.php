<?php
/* @var  $neoCart \Dealscount\Models\Entities\NeoCart */ $neoCart;
$cartItems = $neoCart->getCartItems();
?>
<div id="content">
    <div class="cart_page">
        <div class="breadcrumbs">
            <h1>Cosul meu</h1>
        </div>

        <?php if (!count($cartItems)) { ?>
            <div>Nu exista niciun produs in cos</div>
        <?php } else { ?>
            <form method='post' action='<?php echo base_url('neocart/process_payment') ?>'>

                <table cellpadding="0" cellspacing="0" class="table_header" width="100%" border="0">
                    <tr>
                        <td width="320">
                        </td>
                        <td width="150">
                            Cantitate
                        </td>
                        <td width="100">
                            Platesti pe site
                        </td>
                        <td width="190">
                            Platesti la furnizor
                        </td>
                        <td width="100">
                            Economisesti
                        </td>
                        <td width="50">

                        </td>
                    </tr>
                </table>

                <div style="margin-top: 20px"></div>
                <table border="0" width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="color:#f00">
                            <?php
                            $errors = $this->session->flashdata('process_payment_errors');
                            if ($errors) {
                                echo '<div style="padding:10px; font-size:15px;">';
                                foreach ($errors as $error) {
                                    echo $error . '<br/>';
                                }
                                echo "</div>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    foreach ($cartItems as $cartItem) {
                        $offer = $cartItem->getItem();
                        ?>
                        <tr>
                            <td class="detalii">
                                <table width="340" cellpadding="0" cellspacing="0" border="0" cellspacing="0">
                                    <tr>
                                        <td width="50">
                                            <img width="50" src="<?php echo $offer->getMainImage() ?>"/>
                                        </td>
                                        <td style="padding-left: 10px; font-size: 12px; color: #1d1d1d;">
                                            <?php echo $offer->getName(); ?>
                                        </td>
                                    </tr>
                                </table>


                                <table class="inner_table" border="0" width="100%">
                                    <tr>
                                        <th width="314">

                                        </th>
                                        <th width="150">

                                        </th>
                                        <th width="100">

                                        </th>
                                        <th width="190">

                                        </th>
                                        <th width="100">

                                        </th>
                                        <th width="50">

                                        </th>
                                    </tr>
                                    <?php for ($i = 0; $i < $cartItem->getQuantity(); $i++) { ?>
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <?php require('application/views/cart/recipients.php') ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                            <td  class="quantity" >
                                                <div class="update_quantity" style="*width: 90px;">
                                                    <div class="minus">
                                                        <input type="button" onclick="updateQuantity(<?= $cartItem->getId() ?>, 'minus')" name="minus" value="" />
                                                    </div>
                                                    <div class="input" style="float: left;">
                                                        <input value="<?= $cartItem->getQuantity() ?>" type="text" name="quantity"/>
                                                    </div>
                                                    <div class="plus">
                                                        <input type="button"  onclick="updateQuantity(<?= $cartItem->getId() ?>, 'plus')" name="plus" value=""/>
                                                    </div>
                                                </div>
                                            </td>



                                            <td class="total_plata">
                                                <?php echo $offer->getSale_price()*$cartItem->getQuantity() ?> lei
                                            </td>
                                            <td class="plata_partener">
                                                <?php echo $offer->getVoucher_price()*$cartItem->getQuantity() ?> lei
                                            </td>
                                            <td class="economie">
                                                <?php
                                                //economie
                                                echo ($offer->getPrice() - $offer->getVoucher_price())*$cartItem->getQuantity();
                                                ?>
                                                lei
                                            </td>
                                            <td width="5%" style="text-align: right">
                                                <a style="float: right;" class="delete" href="javascript:deleteCartItem(<?= $cartItem->getId() ?>, 'minus')"></a>
                                            </td>
                                        </tr>

                                    <?php } ?>



                                </table>
                            </td>

                        </tr>
                    <?php } ?>
                    <tr>
                        <td>
                            <input type='submit' class="finalizare" value=''/>
                            <input type='hidden' name='payment_method' value='FREE'/>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </form>
        <form method="post" action="<?php echo base_url() ?>neocart/update_quantity" id="updateForm">
            <input type="hidden" name="cartItem"/>
        </form>
        <div id="clear"></div>
    </div>
</div>


<form id="deleteForm" method="post" action="<?php echo base_url('neocart/deleteCartItem') ?>">
    <input type="hidden" name="cartItem"/>
</form>