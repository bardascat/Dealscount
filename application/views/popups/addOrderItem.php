<div id="popup">
    <div class="vouchersList">
        <table width="100%" border="0">


            <tr>
                <td colspan="2" id='message'>

                </td>
            </tr>

            <tr>
            <form method='post' action='<?= base_url() ?>admin/orders/getOrderByCode'>
                <input type="hidden" name="id_item" value="<?=$data['id_item'] ?>"/>
                <input type="hidden" name="quantity" value="<?=$data['quantity'] ?>"/>
                <input type="hidden" name="id_variant" value="<?php if (isset($data['id_variant'])) echo $data['id_variant'] ?>"/>
                <input type="hidden" name="item_type" value="offer"/>
                <td width='100'>
                    <label><b>Cod Comanda</b></label>
                </td>
                <td>
                    <input style='width: 60%' type='text' value="<?php if (isset($order)) echo $order->getOrderNumber(); ?>" name='code'/>
                </td>
            </form>
            </tr>

            <?php if (isset($order)): ?>
                <tr>

                    <td colspan="2">
                        <form id="addItemForm" method='post' action='<?= base_url() ?>admin/orders/addOrderItem'>
                            <input type="text" name="beneficiar" placeholder="Nume Beneficiar"/>
                            <div class="blueButton" onclick="$('#addItemForm').submit()">Adauga Produs in Comanda</div>
                            <input type="hidden" name="id_item" value="<?=$data['id_item'] ?>"/>
                            <input type="hidden" name="quantity" value="<?=$data['quantity'] ?>"/>
                            <input type="hidden" name="id_variant" value="<?php if (isset($data['id_variant'])) echo $data['id_variant'] ?>"/>
                            <input type="hidden" name="id_order" value="<?= $data['id_order'] ?>"/>
                            <input type="hidden" name="item_type" value="offer"/>
                        </form>
                    </td>
                </tr>
                <?php
            endif;
            ?>
        </table>
    </div>
</div>
