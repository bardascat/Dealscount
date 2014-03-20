<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $vouchers Dealscount\Models\Entities\OrderVoucher */;
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div style="clear: both; float: left; width:100%;" class="vouchers">
            <h1>Vouchere</h1>
            <div class="search_bar">
                <form action="" method="GET">
                    <input type="text" value="<?php echo isset($q) ? $q : "" ?>" name="q" placeholder="Serie voucher">
                    <input type="submit" value="">
                </form>
            </div>
            <?php if (isset($_GET['q'])): ?>
                <div class="search_result">
                    <?php if ($search_result): ?>
                        <div class="founded" style="display: block;">
                            <div class="recipient_name"><?=$search_result->getRecipientName()?></div>
                            <div class="voucher_code"><?=$search_result->getCode()?></div>

                            <!--Verifica statusul voucherului-->
                            <?php if ($search_result->getUsed() == 0) : ?>
                                <form action="<?php echo base_url('partener/change_voucher_status') ?>" method="POST" name="voucher-form">
                                    <input type="hidden" name="voucher_code" value="<?=$search_result->getCode()?>">
                                    <div class="voucher_btn" onClick="document.forms['voucher-form'].submit();">Utlizează voucher</div>
                                </form>
                            <?php else : ?>
                                <div class="used_voucher">Voucherul a fost utilizat</div>
                                <div class="clearfix"></div>

                            <?php endif; ?>

                        </div>

                    <?php else : ?>

                        <div class="not_found">
                            Nu s-a gasit niciun rezultat.
                        </div>

                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (count($vouchers) > 0) { ?>
                <table class="voucher_listing_table">
                    <tr>
                        <th class="nume">
                            <label>Nume</label>
                        </th>
                        <th class="email">
                            <label>E-mail</label>
                        </th>
                        <th class="serie">
                            <label>Serie voucher</label>
                        </th>
                        <th class="used">
                            <label>Folosit</label>
                        </th>
                    </tr>
                    <?php foreach ($vouchers as $voucher) : ?>
                        <tr>
                            <td class="nume">
                                <label><?=$voucher->getRecipientName()?></label>
                            </td>
                            <td class="email">
                                <label>
                                    <?php
                                    echo $voucher->getRecipientEmail() != "" ? $voucher->getRecipientEmail() : $voucher->getOrderItem()->getOrder()->getUser()->getEmail();
                                    ?>
                                </label>
                            </td>
                            <td class="serie">
                                <label><?=$voucher->getCode()?></label>
                            </td>
                            <td class="used">
                                <label><?php echo $voucher->getUsed() != 0 ? $voucher->getUsed_at()->format("Y-m-d") : "Nu" ?></label>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php } else { ?>
            <div style="margin-top:30px;"> Nu aveti niciun voucher generat.</div>
            <?php } ?>

        </div>
    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
                            $(document).ready(function() {
                                $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy"});
                            })
</script>