<script type="text/javascript">

    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<style>
     #list_table tr:hover td a{color: #fff}
    #list_table .confirmed_row td{
        background-color: #bbf895
    }
    #list_table .cancelled_row td{
        background-color: #ffa8a8
    }
     
</style>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <?php $this->load->view('admin/left_menu'); ?>

            <td class='content index'>
                <!-- content -->
                <div>
                    <?php if (isset($notification)) echo $this->view->show_message($notification) ?>
                </div>

                <div class="paginator">
                    <form method="get" action="?" class="paginateForm">
                        Pagina: <input style="width: 20px; text-align: center; padding: 2px; font-size: 15px;" type="text" name="page" value="<?php if (isset($_GET['page'])) echo $_GET['page'] ?>"/>
                        din  <?php echo round(count($orders) / 100) ?>
                    </form>

                    <div class="searchForm">
                        <form method="get" action="<?php echo base_url() ?>admin/subscriptions/searchOrder">
                            <input type="text" value="<?php if (isset($_GET['search'])) echo $_GET['search'] ?>" name="search" placeholder="Cauta dupa email/nume companie  sau cod comanda"/>
                        </form>
                    </div>

                </div>
                <table width="100%" border="0" id="list_table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th width="100" class="cell_left">
                            Cod Comanda
                        </th>
                        <th style="padding-left: 20px;">
                            Cumparator
                        </th>

                        <th>
                            A cumparat
                        </th>
                        <th>
                            Cantitate
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                            Plata
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Data Comanda
                        </th>

                        <th>Telefon</th>
                        <th class="cell_right">

                        </th>

                    </tr>
                    <?php
                    /* @var $order \Dealscount\Models\Entities\SubscriptionOptionOrder */
                    foreach ($orders as $order) {
                        ?>

                        <tr class="<?php if ($order->getPayment_status() == \DLConstants::$PAYMENT_STATUS_CONFIRMED) echo "confirmed_row"; if ($order->getPayment_status() == \DLConstants::$PAYMENT_STATUS_CANCELED) echo "cancelled_row"; ?>">
                            <td width="10%"><?php echo $order->getOrder_number() ?></td>
                            <td style="padding-left: 20px;" width="20%"><a href="<?php echo base_url('admin/users/edit_company/'.$order->getCompany()->getUser()->getId_user())?>"><?php echo $order->getCompany()->getCompany_name() ?></a></td>
                            <td width="16%"><?php echo $order->getOption()->getName() ?></td>
                            <td width="3%"><?php echo $order->getQuantity() ?></td>
                            <td width="7%"><?php echo $order->getTotal() ?> lei </td>
                            <td width="7%"><?php echo $order->getPayment_method() ?></td>
                            <td width=8%"><?php
                                switch ($order->getPayment_status()) {
                                    case DLConstants::$PAYMENT_STATUS_CONFIRMED: {
                                            echo "Confirmata";
                                        }break;
                                    case DLConstants::$PAYMENT_STATUS_PENDING: {
                                            echo "In asteptare";
                                        }break;
                                    case DLConstants::$PAYMENT_STATUS_CANCELED: {
                                            echo "Esuat";
                                        }break;
                                }
                                ?></td>
                            <td width="12%"><?php echo $order->getOrderedOn()->format("d-m-Y H:i") ?></td>
                            <td><?php echo $order->getCompany()->getUser()->getPhone(); ?></td>
                            <td width="20%" class="list_buttons cell_right">
                                 <?php if($order->getPayment_status()!=DLConstants::$PAYMENT_STATUS_CONFIRMED):?>
                                <a  href="javascript:triggerDeleteConfirm('.delete_<?php echo $order->getOrder_number() ?>',1)">Sterge</a>
                                <a style='display: none;'  class="delete_<?php echo $order->getOrder_number() ?>"  href="<?php echo base_url() ?>admin/subscriptions/delete_order/<?= $order->getOrder_number() ?>">Sterge</a>
                                <?php endif;?>
                                <?php if($order->getPayment_status()==DLConstants::$PAYMENT_STATUS_PENDING):?>
                                <a onclick="return confirm('Sigur vrei sa confirmi comanda ?');" href="<?php echo base_url('admin/subscriptions/confirm_order/'.$order->getOrder_number()) ?>">Confirma</a>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php } ?>
                </table

                <!-- end content -->
            </td>
        </tr>
    </table>

</div>