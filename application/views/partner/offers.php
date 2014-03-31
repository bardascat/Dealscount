<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="offers_list">

            <div class="search_offers" style="float: left; margin-bottom:20px;">
                <form method="get" action="<?php base_url('partener/oferte/search') ?>">
                    <table cellpadding="0" cellspacing="0" border="0" width="950">
                        <tr>
                            <td>
                                <input type="text" placeholder="Cauta dupa nume oferta sau categorie" name="query" value="<?php echo $this->input->get('query')?>" class="query_field" value="<?php echo $this->input->get("voucher") ?>" />
                                <input type="submit" value=""/>
                            </td>
                            <td style="padding-left: 30px; font-size: 14px;">
                                Interval:
                            </td>
                            <td width="200">
                                <div class="programeaza">
                                    <input value="<?php echo $this->input->get('start_date')?>"  class="datepicker" placeholder="data start"  value="<?php echo set_value('start_date') ?>"  type="text" name="start_date"/>
                                </div>
                            </td>
                            <td>
                                -
                            </td>
                            <td width="200" style="padding-left: 10px;">
                                <div class="programeaza">
                                    <input value="<?php echo $this->input->get('end_date')?>"  placeholder="data final" class="datepicker"  value="<?php echo set_value('start_date') ?>"  type="text" name="end_date"/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <?php
            if (count($offers)) {
                ?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <?php foreach ($offers as $offer) { ?>
                            <tr>
                                <td width="150" class="offer_image">
                                    <a href="<?php echo base_url('partener/detalii-oferta/' . $offer->getIdItem()) ?>">
                                        <img style="display: block;" src="<?php echo base_url($offer->getMainImage()) ?>" width="154"/>
                                    </a>
                                </td>
                                <td width="260" class="brief">
                                    <?php echo $offer->getBrief() ?>
                                </td>
                                <td width="300" class="inner_table">
                                    <table  border="0" width="100%">
                                        <tr>
                                            <td width="150">
                                                Platit pe site
                                            </td>
                                            <td>
                                                <b><?php echo $offer->getSale_price() ?></b> lei
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Platit la furnizor
                                            </td>
                                            <td>
                                                <b> <?php echo $offer->getVoucher_price() ?></b> lei
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Perioada
                                            </td>
                                            <td>
                                                <b> <?php echo date("d.m.Y", strtotime($offer->getStart_date())) . '-' . date("d.m.Y", strtotime($offer->getEnd_date())) ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Vizualizari
                                            </td>
                                            <td>
                                                <b><?php echo ($offer->getStats() ? $offer->getStats()->getViews() : 0) ?></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Descarcate
                                            </td>
                                            <td>
                                                <b><?php echo ($offer->getStats() ? $offer->getStats()->getSales() : 0) ?></b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="actions" style="padding-left: 30px;">
                                    <a style='margin-top: 15px;' class="offers_details" href="<?php echo base_url('partener/detalii-oferta/' . $offer->getIdItem()) ?>"></a>
                                    <a class="red_button" style="color: #FFF; margin-top: 25px; margin-bottom: 15px;" 
                                       href="<?php echo ($offer->getActive() ? base_url('partener/suspenda-oferta/' . $offer->getIdItem()) : base_url('partener/activeaza-oferta/' . $offer->getIdItem())) ?>"><?php echo ($offer->getActive() ? "Suspenda" : "Reporneste"); ?></a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h4 style="margin-top:40px; clear: both; float: left; font-weight: normal;">Nu am gasit nicio oferta.</h4>
            <?php } ?>


        </div>


    </div>
    <div id="clear"></div>
</div>
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
    })
</script>