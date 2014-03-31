<?php
/* @var $order Dealscount\Models\Entities\Order */
/* @var $user Dealscount\Models\Entities\User */
?>
<div id="content">

    <div class="account">
        <div class="breadcrumbs">
            <h1>Voucherele mele</h1>
        </div>

        <?php $this->load->view('user/user_menu'); ?>

        <div class="search_vouchers">
            <form method="get" action="<?php base_url('account/orders') ?>">
                <input type="text" placeholder="Cauta dupa nume oferta" name="voucher" class="query_field" value="<?php echo $this->input->get("voucher") ?>" />
                <input type="submit" value=""/>
            </form>
            <div class="username">
                Salut, <?php echo $user->getLastname() . ' ' . $user->getFirstname() ?>
            </div>
        </div>

        <div class="orders_list">
            <table cellpadding="0" cellspacing="0">
                <?php
                if (count($orders)) {
                    foreach ($orders as $order) {
                        $orderItems = $order->getItems();
                        foreach ($orderItems as $orderItem) {
                            $item = $orderItem->getItem();
                            $vouchers = $orderItem->getVouchers();
                            foreach ($vouchers as $voucher) {
                                ?>
                                <tr>
                                    <td width="154">
                                        <img src="<?php echo base_url($item->getMainImage()) ?>" width="154"/>
                                    </td>
                                    <td width="350" style="padding-left: 10px; padding-right: 20px;">
                                        <div  style="position: relative; height: 100%">
                                            <?php echo $item->getName() ?>
                                            <div style="margin-top:20px;">
                                                Beneficiar <b><?php echo $voucher->getRecipientName(); ?></b>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="250" style="padding-right: 20px;">
                                        <table class="inner" cellpadding="0" cellsapcing="0">
                                            <tr>
                                                <td width="150">
                                                    Plateste pe site: 
                                                </td>
                                                <td>
                                                    <b><?php echo$item->getSale_price() ?> lei</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Plateste la furnizor: 
                                                </td>
                                                <td>
                                                    <b><?php echo $item->getVoucher_price() ?> lei</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Economisesti: 
                                                </td>
                                                <td>
                                                    <b><?php echo $item->getPrice() - $item->getVoucher_price() ?> lei</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #8c8c8c">
                                                    <?php echo date("d.m.Y", strtotime($order->getOrderedOn())) ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="160">
                                        <a href="<?php echo base_url('account/download_voucher/' . $voucher->getId_voucher()) ?>">
                                            <img src="<?php echo base_url('assets/images_fdd/fab_descarca.png') ?>"/>
                                        </a>

                                    </td>
                                </tr>

                                <?php
                            }
                        }
                    }
                } else {
                    ?>
                    <div style="margin: 20px; margin-left: 0px;">
                        Nu am gasit niciun voucher.
                    </div>
                <?php }
                ?>
            </table>
        </div>
    </div>
    <div id="clear"></div>
</div>
