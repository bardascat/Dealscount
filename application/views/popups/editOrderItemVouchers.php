<?php /* @var $orderItem \Dealscount\Models\Entities\OrderItem */?>
<div id="popup" style="width: auto" >
    <div class="vouchersList" style="width: 100%">
        <table border="0" width="100%" border="0">
            <tr>
                <td style="padding-bottom: 50px;" colspan="5">
                    <div onclick="addNewVoucher()" class="blueButton">Adaugă Voucher</div>
                </td>
            </tr>
            <?php
           
            $vouchers = $orderItem->getVouchers();

            foreach ($vouchers as $voucher) {
                ?>
                <tr>
                    <td width="100" style="font-size: 12px;">
                        <div>Serie Voucher: <?php echo $voucher->getCode() ?></div>
                    </td>
                    <td>
                        <form id="voucherform_<?= $voucher->getId_voucher() ?>" method="post" action="<?php echo base_url() ?>admin/orders/updateVoucher">
                            <input style="width:170px;" type="text" name="recipient_name" value="<?php echo $voucher->getRecipientName() ?>"/>
                            <input type="hidden" name="id_voucher" value="<?php echo $voucher->getId_voucher() ?>"/>
                        </form>
                    </td>
                    <td>
                        <div class="blueButton" style="float:none; width:70px;" onclick="$('#voucherform_<?= $voucher->getId_voucher() ?>').submit()">Salvează</div>
                    </td>
                    <td>
                        <form  id="voucherformDelete_<?php echo $voucher->getId_voucher() ?>" method="post" action="<?php echo base_url() ?>admin/orders/deleteVoucher">
                            <input type="hidden" name="id_voucher" value="<?php echo $voucher->getId_voucher() ?>"/>
                            <div class="blueButton" style="float:none; width:70px;" onclick="$('#voucherformDelete_<?php echo $voucher->getId_voucher() ?>').submit()">Sterge</div>
                        </form>
                    </td>
                    <td>
                        <a href="<?php echo base_url() . 'account/download_voucher/' . $voucher->getId_voucher() ?>/refresh">
                            <img src="<?php echo base_url() ?>assets/images_fdd/descarca.png"/>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script>
                        function addNewVoucher() {
                            var rand = 1 + Math.floor(Math.random() * 99999);
                            var form = '<tr><td colspan="5"><form id="' + rand + '" method="post" action="<?= base_url() ?>admin/orders/addVoucher"><input type="text" name="recipient_name" style="float:left; margin-right:10px;" placeholder="Nume beneficiar"/><div class="blueButton" style="float:right;" onclick="$(\'#' + rand + '\').submit()">Adaugă</div><input type="hidden" name="idOrderItem" value="<?= $orderItem->getId() ?>"/></form></td></tr>';
                            $('.vouchersList table').append(form);
                        }
</script>