<?
/* @var $order \NeoMvc\Models\Entity\Order */
?>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Buna <?= $order->getShippingAddress()->getShipping_name() ?>,<br/><br/>

   Plata dvs. cu cardul bancar pentru comanda numarul <?= $order->getOrderNumber() ?> a fost confirmata.
 <br/>
Multumim ca ati folosit serviciile oringo.ro !  
<?if($vouchers):?>
Atasat(e) acestui e-mail puteti gasi cuponul/cupoanele descarcat(e).<br/>

<?endif;?>
In cateva momente comanda dvs. va fi preluata si va vom contacta pentru confirmarea acesteia.<br/><br/>
  Puteti urmari starea comenzii dvs in contul Oringo sau apasand acest <a href="<?= URL ?>cont/comenzi">link</a>.<br/><br/>

Mai jos gasiti detaliile legate de comanda dvs:

    Mai jos gasiti detaliile legate de comanda dvs:<br/><br/>

    <b>Numarul comenzii dvs: <?= $order->getOrderNumber() ?></b><br/>
    Adresa Livrare:<?= $order->getShippingAddress()->getFullAddress() ?><br/>
    Telefon Contact: <?= $order->getShippingAddress()->getShipping_phone() ?><br/><br/>



    <b>Detalii Comanda:</b><br/>
    <? foreach ($order->getItems() as $orderItem) { ?>
        <?
        echo $orderItem->getItem()->getName();
        if ($orderItem->getProductVariant()) {
            foreach ($orderItem->getProductVariant()->getAttributes() as $attribute) {
                echo $attribute->getAttribute()->getName() . ':' . $attribute->getValue();
            }
        }
        echo " Cantitate: ".$orderItem->getQuantity().' (buc) ';
        echo "<b> Total: " . $orderItem->getTotal() . '</b> lei';
        echo "<br/>";
        ?>

    <? } ?>
    <br/>
    Transport: <?= $order->getShipping_cost() ?> lei<br/><br/>
    <span style="color: #0011bf; font-weight: bold">Total General: <?= $order->getTotal() ?>  lei</span><br/><br/><br/>

    Va dorim toate cele bune,<br/>
    <b>Echipa Oringo</b><br/><br/>

    <b>Telefonul clientului:</b>  <span style="color: #7a0000">0725 680 311</span> (Luni-Vineri 09:00-18:00)<br/>
    Web: <a href="<?= URL ?>">www.oringo.ro</a><br/>
    E-mail: office@oringo.ro<br/>
</p>
