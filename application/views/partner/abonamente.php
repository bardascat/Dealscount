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
                if (!$user->getCompanyDetails()->getAvailable_from()) {
                    ?>

                    Pentru a posta oferte este necesar sa alegeti un tip de abonament.

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
                    
                    Contul tau este valabil pana la <b><?php echo $user->getCompanyDetails()->getAvailable_to()->format("Y-m-d")?></b>
                    
                <?php } ?>

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