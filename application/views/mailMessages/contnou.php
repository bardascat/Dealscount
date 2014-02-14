<? /* @var $user \NeoMvc\Models\Entity\User */ ?>
<style>
    *{font-size: 13px; color: #001e63; font-family: Arial;}
    html{font-size: 13px; color: #001e63; font-family: Arial;}
</style>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Bună <? if ($user->getNume()) echo $user->getNume() . ' ' . $user->getPrenume() ?>,<br/><br/>
    <?if($user->getFromFb()):?>
    Datele de login:<br/>
    Email: <?=$user->getEmail()?><br/>
    Parola: <?=$user->getRealPassword()?><br/><br/>
    <?endif;?>
    Va multumim pentru inregistrarea pe <a href="<?= URL ?>">www.oringo.ro </a> . <br/>
    Acum puteti comanda cu usurinta orice produs din gama noastra de Carti, Electronice, Articole & Jucarii pentru copii si Echipamente sportive.<br/><br/>
    Prin intermediul contului Oringo puteti:<br/>
</p>
<ul style="font-size: 13px; color: #001e63; font-family: Arial;">
    <li>Adauga/Modifica datele personale</li>
    <li>Urmari starea comenzilor dvs.</li>
    <li>Descarca facturile fiscale aferente comenzilor</li>
    <li>Administra preferintele newsletter-ului</li>
</ul>

<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    <br/>
    Va uram bun venit si va stam la dispozitie pentru orice intrebari ati avea despre produsele de pe oringo.ro .<br/><br/>


    Va dorim toate cele bune,<br/>
    <b>Echipa Oringo</b><br/><br/>

    <b>Telefonul clientului:</b>  <span style="color: #7a0000">0725 680 311</span> (Luni-Vineri 09:00-18:00)<br/>
    Web: <a href="<?= URL ?>">www.oringo.ro</a><br/>
    E-mail: office@oringo.ro<br/>
</p>
