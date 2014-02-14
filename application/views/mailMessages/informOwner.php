<?
/* @var $order \NeoMvc\Models\Entity\Order */
?>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">	<?if(is_object($order->getShippingAddress())) { ?>
    Omul pe nume: <?= $order->getShippingAddress()->getShipping_name() ?>, a facut o comandă.<br/><br/>
    Adresa Livrare:<?= $order->getShippingAddress()->getFullAddress() ?><br/>
    Telefon Contact: <?= $order->getShippingAddress()->getShipping_phone() ?><br/><br/>
	<? } ?>

	 Mai jos gasiti detaliile legate de comanda :<br/><br/>    <b>Numarul comenzii dvs: <?= $order->getOrderNumber() ?></b><br/>	    Metoda de plata: <?= $order->getPayment_method() ?><br/><br/>
    <b>Detalii Comanda:</b><br/>
    <? foreach ($order->getItems() as $orderItem) { ?>
        <?
        echo $orderItem->getItem()->getName();
        if ($orderItem->getProductVariant()) {
            foreach ($orderItem->getProductVariant()->getAttributes() as $attribute) {
                echo ", " . $attribute->getAttribute()->getName() . ': ' . $attribute->getValue();
            }
        }
        echo ", Cantitate: " . $orderItem->getQuantity() . ' (buc) ';
        echo "<b>, Total: " . $orderItem->getTotal() . '</b> lei';
        echo "<br/>";
        ?>

    <? } ?>
    <br/>
    Transport: <?= $order->getShipping_cost() ?> lei<br/><br/>
    <span style="color: #0011bf; font-weight: bold">Total General: <?= $order->getTotal() ?>  lei</span><br/>

    <br/>

    Sa fie intr-un ceas bun !
</p>
