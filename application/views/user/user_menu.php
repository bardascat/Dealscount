<ul class="user_menu">
    <li>
        <a href="<?php echo base_url('account/logout') ?>">
            Logout
        </a>
    </li>

    <li class="vouchere">
        <a href="<?php echo base_url('account/orders') ?>">
            Vouchere
        </a>
    </li>
    <li class="date_cont">
        <a href="<?php echo base_url('account') ?>">
            Date cont
        </a>
    </li>
    <?php if ($user->getAclRole()->getName() == DLConstants::$PARTNER_ROLE) { ?>
        <li class="date_cont">
            <a href="<?php echo base_url('partener') ?>">
                Cont Partener
            </a>
        </li>
    <?php } ?>

</ul>