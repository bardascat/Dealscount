<?php
/* @var $order \Dealscount\Models\Entities\SubscriptionOptionOrder */
?>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
 Buna <?php $order->getCompany()->getUser()->getLastname() ?>,<br/><br/>


<b>Detalii Comanda:</b><br/>

<div>Numar de referinta <b><?php echo $order->getOrder_number() ?></b> <span style="color: #F00">Acest numar trebuie scris pe OP</span><br/></div>
<div>Ati comandat <?php if ($order->getOption()->getType() == "option") echo "optiunea " ?> <b><?php echo $order->getOption()->getName() ?></div></b>
<div>Cantitate <?php echo $order->getQuantity() ?></div>
<div>Total General <?php echo $order->getTotal() ?> lei</div>
<br/><br/>


<u>Detalii efectuare transfer bancar (OP)</u><br/>
IBAN: <?php echo DLConstants::$SUPPLIER_IBAN ?><br/>
BANCA: <?php echo DLConstants::$SUPPLIER_BANK ?><br/>
BENEFICIAR: <?php echo DLConstants::$SUPPLIER_NAME ?><br/><br/>

Transferul trebuie efectuat intr-un termen de 72 de ore de la finalizarea comenzii.<br/>
<b>Va rugam sa nu uitati sa mentionati numarul comenzii in detaliile transferului.</b><br/><br/><br/>

Va dorim toate cele bune,<br/>
<br/>
Web: <a href="<?php echo base_url() ?>"><?php echo DLConstants::$WEBSITE_COMMERCIAL_NAME ?></a><br/>
E-mail: <?php echo DLConstants::$OFFICE_EMAIl ?><br/>
</p>
