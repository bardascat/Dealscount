<?php /* @var $user \Dealscount\Models\Entities\User */ ?>
<style>
    *{font-size: 13px; color: #001e63; font-family: Arial;}
    html{font-size: 13px; color: #001e63; font-family: Arial;}
</style>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Bună <?php $user->getLastname() ?>,<br/><br/>

    Parola dumneavoastră a fost resetată.<br/><br/>

<u>Noua parolă: <?php $user->getRealPassword() ?></u>
<br/>
Puteti sa modificati parola din contul dumneavoastră, secțiunea "Date personale".
<br/><br/>


<br/>
Web: <a href="<?php echo base_url() ?>"><?php echo DLConstants::$WEBSITE_COMMERCIAL_NAME ?></a><br/>
E-mail: <?php echo DLConstants::$OFFICE_EMAIl ?><br/>
</p>

