<?php
/* @var  $neoCart \Dealscount\Models\Entities\NeoCart */ $neoCart;
$cartItems = $neoCart->getCartItems();
?>
<div class="content general_page">
    <div class="info_bar">
        <div class="breadcrumbs" style="clear: both;">
            Lista cumparaturi
        </div>
    </div>

    <?php if (!count($cartItems)) { ?>
        <div>Nu exista niciun produs in cos</div>
    <?php } else { ?>
        <form method='post' action='<?php echo base_url('neocart/process_payment') ?>'>
            <table border="1" style="font-size: 12px;">
                <tr>
                    <td colspan="4">
                        <?php $errors=$this->session->flashdata('process_payment_errors');
                        if($errors)
                        foreach($errors as $error){
                            echo $error;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Nume
                    </th>
                    <th>
                        Cantitate
                    </th>
                    <th>
                        Pret
                    </th>
                    <th>
                        Sterge
                    </th>
                </tr>
                <?php
                foreach ($cartItems as $cartItem) {
                    $offer = $cartItem->getItem();
                    ?>
                    <tr>
                        <td>
                            <?php echo $offer->getName(); ?>
                            <?php for ($i = 0; $i < $cartItem->getQuantity(); $i++) { ?>
                                <input type='text' placeholder='Nume Beneficiar' name='name_<?php echo $cartItem->getId() ?>[]'/>
                                <br/>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $cartItem->getQuantity() ?>
                        </td>
                        <td>
                            <?php echo $cartItem->getTotal($offer->getSale_price()) ?>
                        </td>
                        <td>
                            <a href='javascript:delete_cart_item(<?php echo $cartItem->getId()?>)'>X</a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">
                        <input type='submit' value='Finalizare'/>
                        <input type='hidden' name='payment_method' value='FREE'/>
                    </td>
                </tr>
            </table>
        <?php } ?>
    </form>
</div>

