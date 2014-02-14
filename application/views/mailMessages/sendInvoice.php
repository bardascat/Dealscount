<?
/* @var $user \NeoMvc\Models\Entity\User */
/* @var $order \NeoMvc\Models\Entity\Order */
$user=$order->getUser();
?>
<style>
    *{font-size: 13px; color: #001e63; font-family: Arial;}
    html{font-size: 13px; color: #001e63; font-family: Arial;}
</style>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Bună <? if ($user->getNume()) echo $user->getNume() . ' ' . $user->getPrenume() ?>,<br/><br/>

    Vă anuțăm că factura pentru comanda <?= $order->getOrderNumber() ?> a fost generată.<br/><br/>


    Va dorim toate cele bune,<br/>
    <b>Echipa Oringo</b><br/><br/>

    <b>Telefonul clientului:</b>  <span style="color: #7a0000">0725 680 311</span> (Luni-Vineri 09:00-18:00)<br/>
    Web: <a href="<?= URL ?>">www.oringo.ro</a><br/>
    E-mail: office@oringo.ro<br/>
</p>
