<? /* @var $user \NeoMvc\Models\Entity\User */ ?>
<style>
    *{font-size: 13px; color: #001e63; font-family: Arial;}
    html{font-size: 13px; color: #001e63; font-family: Arial;}
</style>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Bună <? if ($user->getNume()) echo $user->getNume() . ' ' . $user->getPrenume() ?>,<br/><br/>
   
    Contul dumneavoastra de partener a fost creat. <br/>
    Datele de login:<br/>
    Email: <?=$user->getEmail()?><br/>
    Parola: <?=$user->getRealPassword()?><br/><br/>
    
</p>


<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    <br/>

    Va dorim toate cele bune,<br/>
    <b>Echipa Oringo</b><br/><br/>
    Web: <a href="<?= URL ?>">www.oringo.ro</a><br/>
    E-mail: office@oringo.ro<br/>
</p>
