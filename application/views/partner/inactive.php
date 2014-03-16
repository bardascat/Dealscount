<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="partner">


        <?php $this->load->view('partner/partner_menu'); ?>
        <div style="margin-top:50px; float: left; font-size: 19px;">
            <?php if (isset($message)) { ?>
                <div>
                    <?php echo $message ?><br/>
                </div>
                <?php
            } else
                switch ($user->getCompanyDetails()->getStatus()) {
                    case DLConstants::$PARTNER_PENDING: {
                            ?>
                            <div>
                                Contul dumneavoastra inca nu este activat. <br/>
                            </div>
                            <?php
                        }break;
                    case DLConstants::$PARTNER_SUSPENDED: {
                            ?>
                            <div>
                                Contul dumneavoastra este suspendat.
                            </div>
                            <?php
                        }break;
                    default: {
                            ?>
                            <div>
                                Eroare, va rugam contactati administratorul, statusul contului este <?php echo $user->getCompanyDetails()->getStatus(); ?>
                            </div>
                            <?php
                        }break;
                }
            ?>

        </div>
    </div>
    <div id="clear"></div>
</div>
