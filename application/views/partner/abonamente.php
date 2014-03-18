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
                //prima data cand activeaza contul
                if (!$user->getCompanyDetails()->getAvailable_from() || $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d") < date("Y-m-d")) {
                    ?>
                    <?php if (!$user->getCompanyDetails()->getAvailable_from()): ?>
                        Pentru a posta oferte este necesar sa alegeti un tip de abonament.
                    <?php else : ?>
                        Abonamentul dumneavoastra a expirat. Va rugam prelungiti-l.
                    <?php endif; ?>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th>
                                Tip
                            </th>
                            <th>
                                Pret
                            </th>
                            <th>

                            </th>
                        </tr>
                        <?php foreach ($subscriptions as $sub) { ?>
                            <tr>
                                <td>
                                    <?php echo $sub->getName() ?>
                                </td>
                                <td>
                                    <?php if ($sub->getPrice() > $sub->getSale_price()) { ?>
                                        <span class="sale_price_discount"><?php echo $sub->getSale_price() ?></span> lei
                                        <span class="price" style="text-decoration: line-through"><?php echo $sub->getPrice() ?></span> lei
                                    <?php } else { ?>
                                        <span class="sale_price"><?php echo $sub->getSale_price() ?></span> lei
                                    <?php }
                                    ?>
                                </td>
                                <td>
                                    <form style="float: right;" id="buy_<?php echo $sub->getId_option() ?>" method="post" action="<?php echo base_url('partener/buy_option') ?>">
                                        <input type="hidden" name="id_option" value="<?php echo $sub->getId_option() ?>"/>
                                        <input type="hidden" name="quantity" value="1"/>
                                        <select name="payment_method">
                                            <option value="<?php echo DLConstants::$PAYMENT_METHOD_CARD ?>">
                                                Plata cu Card
                                            </option>
                                            <option value="<?php echo DLConstants::$PAYMENT_METHOD_OP ?>">
                                                Plata prin OP
                                            </option>
                                        </select>
                                        <div id="greenButton" onclick="$('#buy_<?php echo $sub->getId_option() ?>').submit()">Cumpara</div>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>

                <?php } else {
                    ?>
                    Contul tau este valabil pana la <b><?php echo $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d") ?></b>

                <?php } ?>

            </div>

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

                        </th>
                    </tr>
                    <?php foreach ($options as $option) { ?>
                        <tr>
                            <td>
                                <table class="optionWrapper">
                                    <tr>
                                        <td style="vertical-align: top;" >
                                            <img src="<?php echo base_url('../assets/images_fdd/fab_red_star.png') ?>"
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
                                <?php echo $option->getPrice() ?> lei
                            </td>
                            <td>
                                2
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
                                <div style="float: right;"  id="greenButtonSmall">Cumpara</div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <!--
                <div class="option">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="50">
                                <img src="<?php echo base_url('../assets/images_fdd/fab_orange_star.png') ?>"
                            </td>
                            <td width="430">
                                <table class="option_details" border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="header">
                                            Oferta promovata in categorie
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Oferta este promovata in datele de 14.03, 18.03, 22.04
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="credit">
                                            Ai 10 Credite
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <div style="float: right">
                                    <div class="programeaza">
                                        <input style="width: 100px;" class="datepicker" type="text" name="scheduled"/>
                                    </div>
                                </div>
                            </td>
                            <td width="150" style="padding-left: 30px;">
                                <div style="float: right;"  id="greenButton">Programeaza</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="option">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="50">
                                <img src="<?php echo base_url('../assets/images_fdd/fab_yellow_star.png') ?>"
                            </td>
                            <td width="430">
                                <table class="option_details" border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="header">
                                            Oferta promovata  in subcategorie
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Oferta este promovata in datele de 14.03, 18.03, 22.04
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="credit">
                                            Ai 10 Credite
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <div style="float: right">
                                    <div class="programeaza">
                                        <input style="width: 100px;" class="datepicker" type="text" name="scheduled"/>
                                    </div>
                                </div>
                            </td>
                            <td width="150" style="padding-left: 30px;">
                                <div style="float: right;"  id="greenButton">Programeaza</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="option">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="50">
                                <img src="<?php echo base_url('../assets/images_fdd/fab_news_icon.png') ?>"
                            </td>
                            <td width="430">
                                <table class="option_details" border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="header">
                                            Oferta promovata in newsletter
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Oferta este promovata in datele de 14.03, 18.03, 22.04
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="credit">
                                            Ai 10 Credite
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <div style="float: right">
                                    <div class="programeaza">
                                        <input style="width: 100px;" class="datepicker" type="text" name="scheduled"/>
                                    </div>
                                </div>
                            </td>
                            <td width="150" style="padding-left: 30px;">
                                <div style="float: right;"  id="greenButton">Programeaza</div>
                            </td>
                        </tr>
                    </table>
                </div>
                -->
            </div>



        </div>


    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
                                            $(document).ready(function() {
                                                $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy"});
                                            })
</script>