<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $subscriptions Dealscount\Models\Entities\SubscriptionOption */
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="pagina_abonamente">

            <h1>Abonamente</h1>

            <div  class="info">

                <?php
                //prima data cand activeaza contul, sau abonamentul este expirat
                if (!$user->getCompanyDetails()->getAvailable_from() || $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d") < date("Y-m-d")) {
                    ?>
                    <?php if (!$user->getCompanyDetails()->getAvailable_from()): ?>
                        Pentru a posta oferte este necesar sa alegeti un tip de abonament.
                    <?php else : ?>
                        Abonamentul dumneavoastra a expirat. Va rugam prelungiti-l.
                    <?php endif; ?>

                    <div class="prelungeste">
                        <h1 style="font-weight: bold">Alege abonament</h1>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <th style="text-align: left; padding-left: 5px;">
                                    Valabilitate
                                </th>
                                <th>
                                    Pret
                                </th>
                                <th>
                                    Metoda de plata
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                            <?php foreach ($subscriptions as $sub) { ?>
                                <tr>
                                    <td width="25%" style="padding-left: 5px;">
                                        <?php echo $sub->getName() ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php if ($sub->getPrice() > $sub->getSale_price()) { ?>
                                            <span class="sale_price_discount"><?php echo $sub->getSale_price() ?></span> lei
                                            <span class="price"><?php echo $sub->getPrice() ?></span> lei
                                        <?php } else { ?>
                                            <span class="sale_price"><?php echo $sub->getSale_price() ?></span> lei
                                        <?php }
                                        ?>
                                    </td>
                                    <td>
                                        <form  id="buy_<?php echo $sub->getId_option() ?>" method="post" action="<?php echo base_url('partener/buy_option') ?>">
                                            <input type="hidden" name="id_option" value="<?php echo $sub->getId_option() ?>"/>
                                            <input type="hidden" name="quantity" value="1"/>
                                            <div class="payment_method">
                                                <select name="payment_method">
                                                    <option value="<?php echo DLConstants::$PAYMENT_METHOD_CARD ?>">
                                                        Plata cu Card
                                                    </option>
                                                    <option value="<?php echo DLConstants::$PAYMENT_METHOD_OP ?>">
                                                        Plata prin OP
                                                    </option>
                                                </select>
                                            </div>
                                        </form>
                                    </td>
                                    <td style="padding-right: 5px;">
                                        <div style="float: right;" id="greenButtonSmall" onclick="$('#buy_<?php echo $sub->getId_option() ?>').submit()">Cumpara</div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                <?php } else {
                    ?>
                    Contul tau este valabil pana la <b><?php echo $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d") ?></b>

                <?php } ?>

            </div>

            <?php 
            
            //afisam optiuniule pentru abonament activ
            if ($user->getCompanyDetails()->getAvailable_from() && $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d") >= date("Y-m-d")) { ?>
                <div class="prelungeste">
                    <h1 style="font-weight: bold">Prelungeste abonament</h1>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <th style="text-align: left; padding-left: 5px;">
                                Valabilitate
                            </th>
                            <th>
                                Pret
                            </th>
                            <th>
                                Metoda de plata
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                        <?php foreach ($subscriptions as $sub) { ?>
                            <tr>
                                <td width="25%" style="padding-left: 5px;">
                                    <?php echo $sub->getName() ?>
                                </td>
                                <td style="text-align: center">
                                    <?php if ($sub->getPrice() > $sub->getSale_price()) { ?>
                                        <span class="sale_price_discount"><?php echo $sub->getSale_price() ?></span> lei
                                        <span class="price"><?php echo $sub->getPrice() ?></span> lei
                                    <?php } else { ?>
                                        <span class="sale_price"><?php echo $sub->getSale_price() ?></span> lei
                                    <?php }
                                    ?>
                                </td>
                                <td>
                                    <form  id="buy_<?php echo $sub->getId_option() ?>" method="post" action="<?php echo base_url('partener/buy_option') ?>">
                                        <input type="hidden" name="id_option" value="<?php echo $sub->getId_option() ?>"/>
                                        <input type="hidden" name="quantity" value="1"/>
                                        <div class="payment_method">
                                            <select name="payment_method">
                                                <option value="<?php echo DLConstants::$PAYMENT_METHOD_CARD ?>">
                                                    Plata cu Card
                                                </option>
                                                <option value="<?php echo DLConstants::$PAYMENT_METHOD_OP ?>">
                                                    Plata prin OP
                                                </option>
                                            </select>
                                        </div>
                                    </form>
                                </td>
                                <td style="padding-right: 5px;">
                                    <div style="float: right;" id="greenButtonSmall" onclick="$('#buy_<?php echo $sub->getId_option() ?>').submit()">Cumpara</div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>


                <div class="options">
                    <h1 style="font-size: 15px; font-weight: bold; margin-bottom: 10px; margin-top:40px; margin-bottom: 20px;">Optiuni</h1>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="330" style="text-align: left; padding-left: 49px;">
                                Detalii
                            </th>
                            <th width="100">
                                Pret
                            </th>
                            <th width="100">
                                Ai
                            </th>
                            <th width="100">
                                Plata
                            </th>
                            <th width="100">
                                Cant
                            </th>
                            <th width="166">
                                &nbsp;
                            </th>
                        </tr>
                        <?php
                        $icons = array('fab_red_star.png', 'fab_yellow_star.png', 'fab_orange_star.png', 'fab_news_icon.png', 'fab_news_icon.png', 'fab_red_star.png');
                        foreach ($options as $key => $option) {
                            ?>
                            <form id="buy_option_<?php echo $option->getId_option() ?>" method="post" action="<?php echo base_url('partener/buy_option') ?>">
                                <tr>
                                    <td>
                                        <input type="hidden" name="id_option" value="<?php echo $option->getId_option(); ?>"/>
                                        <table class="optionWrapper">
                                            <tr>
                                                <td style="vertical-align: top;" >
                                                    <img src="<?php echo base_url('../assets/images_fdd/' . $icons[$key]) ?>"
                                                </td>
                                                <td style="padding-top: 0px; padding-left: 7px; padding-bottom: 0px;" width="430">
                                                    <table class="option_details" border="0" width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="header">
                                                                <?php echo $option->getName() ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 13px; padding: 0px;">
                                                                <?php echo $option->getDescription() ?>
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <?php if ($option->getPrice() > $option->getSale_price()) { ?>
                                            <span class="sale_price_discount"><?php echo $option->getSale_price() ?></span> lei
                                            <span class="price"><?php echo $option->getPrice() ?>  lei</span>
                                        <?php } else { ?>
                                            <span class="sale_price"><?php echo $option->getSale_price() ?> lei</span> 
                                        <?php }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $option->getAvailable() ?>
                                    </td>
                                    <td>
                                        <div class="payment_method">
                                            <select style="padding: 3px; border: 1px solid #ccc; width: 110px;" name="payment_method">
                                                <option value="<?php echo DLConstants::$PAYMENT_METHOD_CARD ?>">
                                                    Plata Card
                                                </option>
                                                <option value="<?php echo DLConstants::$PAYMENT_METHOD_OP ?>">
                                                    Plata OP
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="quantity" value="1"/>
                                    </td>
                                    <td width="150" style="padding-right: 5px;">
                                        <div onclick="$('#buy_option_<?php echo $option->getId_option() ?>').submit()" style="float: right;"  id="greenButtonSmall">Cumpara</div>
                                    </td>
                                </tr>
                            </form>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
        </div>


    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
                                    $(document).ready(function() {
                                        $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy"});
                                    })
</script>