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
                        <td width="44%">
                        </td>
                        <td width="17%">
                            Platesti pe site
                        </td>
                        <td width="17%">
                            Platesti la furnizor
                        </td>
                        <td width="17%">
                            Economisesti
                        </td>
                        <td width="5%">

                        </td>
                    </tr>
                </table>

                <div style="margin-top: 20px"></div>
                <table border="0" width="100%" style="font-size: 12px;">
                    <tr>
                        <td style="color:#f00">
                            <?php
                            $errors = $this->session->flashdata('process_payment_errors');
                            if ($errors){
                                echo '<div style="padding:10px; font-size:15px;">';
                                foreach ($errors as $error) {
                                    echo $error.'<br/>';
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
                                <table width="44%" cellpadding="0" border="0" cellspacing="0">
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
                                        <th>

                                        </th>
                                        <th>

                                        </th>
                                        <th>

                                        </th>
                                        <th>

                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                    <?php for ($i = 0; $i < $cartItem->getQuantity(); $i++) { ?>
                                        <tr>
                                            <td width="60">
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 14px;" width="50">Nume</td>
                                                        <td>
                                                            <input type='text' name='name_<?php echo $cartItem->getId() ?>[]'/>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>


                                            <td class="total_plata" width="17%">
                                                <?php echo $offer->getSale_price() ?> lei
                                            </td>
                                            <td class="plata_partener" width="17%">
                                                <?php echo $offer->getVoucher_price() ?> lei
                                            </td>
                                            <td class="economie" width="17%">
                                                <?php
                                                //economie
                                                echo ($offer->getPrice() - $offer->getVoucher_price());
                                                ?>
                                                lei
                                            </td>
                                            <td width="5%" style="text-align: center">
                                                <a class="delete" href="javascript:updateQuantity(<?= $cartItem->getId() ?>, 'minus')"></a>
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

