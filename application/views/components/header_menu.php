<div class="subcats">
    <ul>
        <?php if ($this->view->getUser()) { ?>

            <?php
            switch ($this->view->getUser()['role']) {
                case DLConstants::$PARTNER_ROLE: {
                        echo "<li><div><a href='" . base_url('account') . "'>Cont Client</a></div></li>";
                        echo "<li><div><a href='" . base_url('partener') . "'>Cont Partener</a></div></li>";
                    }break;

                case DLConstants::$ADMIN_ROLE: {
                        echo "<li><div><a href='" . base_url('account') . "'>Cont Client</a></div></li>";
                        echo "<li><div><a href='" . base_url('admin') . "'>Admin</a></div></li>";
                    }break;

                case DLConstants::$OPERATOR_ROLE: {
                        echo "<li><div><a href='" . base_url('account') . "'>Cont Client</a></div></li>";
                        echo "<div><a href='" . base_url('admin') . "'>Operator</a></div>";
                    }break;
                default: {
                        echo "<li><div><a href='" . base_url('account') . "'>Vouchere comandate</a></div></li>";
                        echo "<li><div><a href='" . base_url('account/orders') . "'>Date cont</a></div></li>";
                    }break;
            }
            ?>

        <?php } ?>
        <li>
            <div><a href="<?php echo base_url('account/logout') ?>">Logout</a></div>
        </li>

        <li class="footer_end"></li>
    </ul>
</div>