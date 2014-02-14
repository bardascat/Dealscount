<?
/* @var $order \NeoMvc\Models\Entity\Order */
?>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Buna <?= $order->getShippingAddress()->getShipping_name() ?>,<br/><br/>
    Comanda dvs. cu numarul <b><?= $order->getOrderNumber() ?></b> a fost procesata si va fi ridicata de catre curier. <br/>
    O data ridicata comanda de catre curier, puteti urmari starea acesteia in contul dvs Oringo sau apasand acest <a href="<?= URL ?>cont/comenzi">link</a>.<br/>
    Curierul Cargus va lua legatura cu dvs. pentru a stabili detaliile de livrare a comenzii.<br/><br/>
    
    Factura fiscala va fi comunicata in format electronic pe adresa dvs. de e-mail si in contul dvs. Oringo la momentul livrarii.
    <br/><br/>

    Va dorim toate cele bune,<br/>
    <b>Echipa Oringo</b><br/><br/>

    <b>Telefonul clientului:</b>  <span style="color: #7a0000">0725 680 311</span> (Luni-Vineri 09:00-18:00)<br/>
    Web: <a href="<?= URL ?>">www.oringo.ro</a><br/>
    E-mail: office@oringo.ro<br/>
</p>