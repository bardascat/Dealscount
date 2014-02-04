<script type="text/javascript">

    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <!-- content -->

                <div class="paginator">
                    <form method="get" action="?" class="paginateForm">
                        Pagina: <input style="width: 20px; text-align: center; padding: 2px; font-size: 15px;" type="text" name="page" value="<? if (isset($_GET['page'])) echo $_GET['page'] ?>"/>
                        din  <?= round(count($this->orders) / 100) ?>
                    </form>

                    <div class="searchForm">
                        <form method="get" action="<?= URL ?>admin/orders/searchOrder">
                            <input type="text" value="<? if (isset($_GET['search'])) echo $_GET['search'] ?>" name="search" placeholder="Cauta dupa nume/email client sau cod comanda"/>
                        </form>
                    </div>

                </div>
                <table width="100%" border="0" id="list_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th width="100" class="cell_left">
                            Cod Comanda
                        </th>
                        <th>
                            Data Comanda
                        </th>
                        <th style="padding-left: 20px;">
                            Cumparator
                        </th>
                        <th >
                            Pret
                        </th>
                        <th>
                            Status Plata
                        </th>
                        <th>
                            Status Livrare
                        </th>
                        <th class="cell_right">

                        </th>

                    </tr>
                    <?
                    /* @var $order \NeoMvc\Models\Entity\Order */
                    foreach ($this->orders as $order) {
                        ?>

                        <tr>
                            <td width="10%"><a href="<?= URL ?>admin/orders/edit_order/<?= $order->getId_order() ?>"><?= $order->getOrderNumber() ?></a></td>
                            <td width="15%"><?= $order->getOrderedOn() ?></td>
                            <td style="padding-left: 20px;" width="15%"><?= $order->getUser()->getNume() ?></td>

                            <td width="15%"><?= $order->getTotal() ?> ron</td>
                            <td wdith="15%"><?= $this->getHumanPaymentStatus($order->getPayment_status(), false); ?></td>
                            <td wdith="15%"><?= $this->getHumanOrderStatus($order->getOrderStatus(), false); ?></td>
                          
                            <td width="15%" class="list_buttons cell_right">
                                <a href="<?= URL ?>admin/orders/edit_order/<?= $order->getId_order() ?>">Editeaza</a>
                                <a  href="javascript:triggerDeleteConfirm('.delete_<?= $order->getId_order() ?>',1)">Sterge</a>
                                <a style='display: none;'  class="delete_<?= $order->getId_order() ?>"  href="<?= URL ?>admin/orders/delete_order/<?= $order->getId_order() ?>">Sterge</a>
                            </td>
                        </tr>
                    <? } ?>
                </table

                <!-- end content -->
            </td>
        </tr>
    </table>

</div>