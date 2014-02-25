<?php
/* @var $order Dealscount\Models\Entities\Order */
?>
<div id="content">
    <div class="thankyou_page">
        <div class="breadcrumbs">
            <h1>Cosul meu</h1>
        </div>

        <div class="summary">
            <table width="100%" border="0" cellspacing="0" cellspacing="0">
                <tr>
                    <th width="40%">
                       
                    </th>
                    <th>
                        Platesti pe site
                    </th>
                    <th>
                        Platesti la furnizor
                    </th>
                    <th>
                        Economisesti
                    </th>
                </tr>
                <tr>
                    <td style="font-size: 17px; padding-left: 10px;">
                         Ai comandat <?php echo $order->getVouchersNr()?> voucher(e)
                    </td>
                    <td class="center_bold">
                        <?php echo $order->getTotal();?> <span>lei</span>
                    </td>
                    <td class="center_bold">
                        <?php echo $order->getTotalPaymentPartner()?> <span>lei</span>
                    </td>
                    <td class="center_bold">
                        <?php echo $order->getTotalDiscount()?> <span>lei</span>
                    </td>
                </tr>
            </table>
        </div>


        <div class="message">
            <div class="text">
                Sa te bucuri de vouchere sa fii sanatos si voios.<br/>
                Pentru a le utiliza, trebuie sa le descarci din contul tau.
            </div>
            <a href="<?php echo base_url('account') ?>" id="greenButton">Contul meu</a>
        </div>

    </div>
</div>
