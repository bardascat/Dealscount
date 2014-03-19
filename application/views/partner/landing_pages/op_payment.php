<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $order Dealscount\Models\Entities\SubscriptionOptionOrder */
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="pagina_abonamente">

            <h1>Comanda a fost finalizata</h1>

            <div  class="info">

                Ai ales sa platesti comanda <?php echo $order->getOrder_number() ?> prin transfer bancar.<br/><br/>

                <b>Detalii Comanda</b><br/><br/>

                <div>Numar de referinta <b><?php echo $order->getOrder_number() ?></b> <span style="color: #F00">Acest numar trebuie scris pe OP</span><br/></div>
                <div>Ati comandat <?php if($order->getOption()->getType()=="option") echo "optiunea "?> <b><?php echo $order->getOption()->getName() ?></div></b>
                <div>Cantitate <?php echo $order->getQuantity() ?></div>
                <div>Total General <?php echo $order->getTotal() ?> lei</div>
                <br/><br/>

                <b>Vireaza banii in contul urmator</b><br/><br/>

                <div>IBAN: <?php echo DLConstants::$SUPPLIER_IBAN ?></div>
                <div>BANCA: <?php echo DLConstants::$SUPPLIER_BANK ?></div>
                <div>BENEFICIAR: <?php echo DLConstants::$SUPPLIER_NAME ?></div>

            </div>
        </div>
    </div>
    <div id="clear"></div>
</div>
