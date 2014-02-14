<div id="popup">
    <div class="vouchersList">
        <table border="0" width="100%" border="0">
            <?
            /* @var $voucher NeoMvc\Models\Entity\OrderVoucher */
            $vouchers = $this->orderItem->getVouchers();
            foreach ($vouchers as $voucher) {
                ?>
                <tr>
                    <td class="serie">
                        <div>Serie Voucher: <?=$voucher->getCode()?></div>
                        <div>Beneficiar:<?=$voucher->getRecipientName()?></div>
                    </td>
                    <td>
                        <a href="<? echo URL . 'cont/downloadVoucher/'.$voucher->getId_voucher() ?>">
                            <img src="<?= URL ?>images/descarca.png"/>
                        </a>
                    </td>
                </tr>
            <? } ?>
        </table>
    </div>
</div>
