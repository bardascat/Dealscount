<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $offer Dealscount\Models\Entities\Item */
?>

<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="offers_list offer_details">

            <table border="0" class="summary_table" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td width="150" class="offer_image">
                            <a href="<?php echo base_url('oferte/' . $offer->getSlug()) ?>">
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
                                        <b><?php echo $offer->getSale_price() ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Platit la furnizor
                                    </td>
                                    <td>
                                        <b> <?php echo $offer->getVoucher_price() ?></b>
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
                                        <b><?php echo $offer->getStats()->getViews() ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Descarcate
                                    </td>
                                    <td>
                                        <b><?php echo $offer->getStats()->getSales() ?></b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="actions" style="padding-left: 30px;">
                            <a class="offers_details editeaza" href="<?php echo base_url('partener/editeaza-oferta/' . $offer->getIdItem()) ?>"></a>
                            <a class="red_button" style="color: #FFF; margin-top: 15px; margin-bottom: 15px;" 
                               href="<?php echo ($offer->getActive() ? base_url('partener/suspenda-oferta/' . $offer->getIdItem()) : base_url('partener/activeaza-oferta/' . $offer->getIdItem())) ?>"><?php echo ($offer->getActive() ? "Suspenda" : "Reporneste"); ?></a>
                            <select class="promoted" name="promoted">
                                <option value="1">Promovata</option>
                                <option value="0">Nepromovata</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>


            <div class="options">
                <div class="option">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="50">
                                <img src="<?php echo base_url('../assets/images_fdd/fab_red_star.png') ?>"
                            </td>
                            <td width="430">
                                <table class="option_details" border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="header">
                                            Oferta promovata
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
            </div>

        </div>



    </div>

    <div class="offer_details_stats">
        <h1>Statistici descarcati</h1>
        
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                Bucuresti
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Bucuresti
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Bucuresti
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                18-25 ani
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                25-30 ani
                            </td>
                            <td>
                                10%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 25-30 ani
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                18-25 ani
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                25-30 ani
                            </td>
                            <td>
                                10%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 25-30 ani
                            </td>
                            <td>
                                50%
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div id="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
    })
</script>
