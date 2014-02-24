<?php /* @var $user \Dealscount\Models\Entities\User */ ?>
<style>
    *{font-size: 13px; color: #001e63; font-family: Arial;}
    html{font-size: 13px; color: #001e63; font-family: Arial;}
</style>
<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    Bună <?php $user->getLastname() ?>,<br/><br/>

    Va multumim pentru inregistrarea pe <a href="<?php echo base_url() ?>"> <?php echo DLConstants::$WEBSITE_COMMERCIAL_NAME ?> </a> . <br/>

    <?php if ($user->getFromFb()): ?>
        Datele de login:<br/>
        Email: <?php echo $user->getEmail() ?><br/>
        Parola: <?php echo $user->getRealPassword() ?><br/><br/>
    <?php endif; ?>

</p>

<p style="font-size: 13px; color: #001e63; font-family: Arial;">
    <br/>
    Web: <a href="<?php echo base_url() ?>"><?php echo DLConstants::$WEBSITE_COMMERCIAL_NAME ?></a><br/>
    E-mail: <?php echo DLConstants::$OFFICE_EMAIl ?><br/>
</p>
