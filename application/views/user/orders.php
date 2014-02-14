<?php
/* @var $order Dealscount\Models\Entities\Order */ $orders
?>
<div class="content general_page">

    <?php
    foreach ($orders as $order) {
        $orderItems = $order->getItems();
        foreach ($orderItems as $orderItem) {
            $item=$orderItem->getItem();
            echo "<div>".$item->getName()."</div>";
            $vouchers=$orderItem->getVouchers();
            foreach($vouchers as $voucher)
                echo "<div>".$voucher->getCode().'  <a style="color:#f00" href="'.base_url('account/download_voucher/'.$voucher->getId_voucher()).'">Descarca</a></div>';
            ?>
    
            

        <?php
        }
    }
    ?>

</div>
