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
                                        <b><?php echo ($offer->getStats() ? $offer->getStats()->getViews() : 0); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Descarcate
                                    </td>
                                    <td>
                                        <b><?php echo ($offer->getStats() ? $offer->getStats()->getSales() : 0); ?></b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="actions" style="padding-left: 30px;">
                            <a style='margin-top: 15px;' class="offers_details editeaza" href="<?php echo base_url('partener/editeaza-oferta/' . $offer->getIdItem()) ?>"></a>
                            <a class="red_button" style="color: #FFF; margin-top: 25px; margin-bottom: 15px;" 
                               href="<?php echo ($offer->getActive() ? base_url('partener/suspenda-oferta/' . $offer->getIdItem()) : base_url('partener/activeaza-oferta/' . $offer->getIdItem())) ?>"><?php echo ($offer->getActive() ? "Suspenda" : "Reporneste"); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>


            <?php 
            /* @var $active_options \Dealscount\Models\Entities\SubscriptionOption */
            if ($active_options) { ?>
                <div class="options">
                    <?php foreach ($active_options as $option) { ?>
                        <div class="option">
                            <form id="schedule_form_<?php echo $option->getId_option() ?>"  method="post" action="<?php echo base_url('partener/apply_option') ?>">
                                <input type="hidden" name="id_offer" value="<?php echo $offer->getIdItem() ?>"/>
                                <input type="hidden" name="id_option" value="<?php echo $option->getId_option() ?>"/>

                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50">
                                            <img src="<?php
                                            switch ($option->getSlug()) {
                                                case DLConstants::$OPTIUNE_OFERTA_PROMOVATA:
                                                    echo base_url('../assets/images_fdd/fab_red_star.png');
                                                    break;
                                                case DLConstants::$OPTIUNE_OFERTA_PROMOVATA_CATEGORIE:
                                                    echo base_url('../assets/images_fdd/fab_yellow_star.png');
                                                    break;
                                                case DLConstants::$OPTIUNE_OFERTA_PROMOVATA_SUBCATEGORIE:
                                                    echo base_url('../assets/images_fdd/fab_orange_star.png');
                                                    break;
                                                case DLConstants::$OPTIUNE_PROMOVARE_NEWSLETTER:
                                                    echo base_url('../assets/images_fdd/fab_news_icon.png');
                                                    break;
                                                default:
                                                    echo base_url('../assets/images_fdd/fab_news_icon.png');
                                                    break;
                                            }
                                            ?>"
                                        </td>
                                        <td width="430">
                                            <table class="option_details" border="0" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="header">
                                                        <?php echo $option->getName() ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $scheduledOptions = $option->getScheduledOptions();
                                                        if ($scheduledOptions) {
                                                            echo "Oferta este promovata in datele ";
                                                            foreach ($scheduledOptions as $scheduledOption) {
                                                                echo $scheduledOption->getScheduled()->format("d-m-Y") . ' , ';
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="credit">
                                                        Ai <?php echo $option->getAvailable() ?> Credit(e)
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <div style="float: right">
                                                <?php if ($option->getAvailable()) { ?>
                                                    <div class="programeaza">
                                                        <input readonly="" style="width: 100px;" class="datepicker" type="text" name="scheduled"/>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td width="150" style="padding-left: 30px;">
                                            <?php if ($option->getAvailable()) { ?>
                                            <div onclick="$('#schedule_form_<?php echo $option->getId_option() ?>').submit()" style="float: right;"  id="greenButton">Programeaza</div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>



    </div>

    <div class="offer_details_stats">
        <h1>Statistici descarcari</h1>
        <table>
            <tr>
                <?php
                if (!$statsByCity && !$statsByAge && !$statsByGender) {
                    echo "Nu a fost descarcat niciun voucher";
                }
                if ($statsByCity) {
                    ?>
                    <td style="padding-right: 60px;">
                        <table>
                            <?php foreach ($statsByCity as $city) { ?>
                                <tr>
                                    <td>
                                        <?php echo $city['city'] ?>
                                    </td>
                                    <td>
                                        <?php echo $city['percentage'] ?>%
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                <?php } ?>
                <?php if ($statsByAge) { ?>
                    <td style="padding-right: 60px;">
                        <table>
                            <?php foreach ($statsByAge as $age) { ?>
                                <tr>
                                    <td>
                                        <?php echo $age['age'] ?> ani
                                    </td>
                                    <td>
                                        <?php echo $age['percentage'] ?>%
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                <?php } ?>
                <?php if ($statsByGender) { ?>
                    <td style="padding-right: 60px;">
                        <table>
                            <?php foreach ($statsByGender as $gender) { ?>
                                <tr>
                                    <td>
                                        <?php echo ($gender['gender'] == "f" ? "Feminin" : "Masculin"); ?>
                                    </td>
                                    <td>
                                        <?php echo $gender['percentage'] ?>%
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                <?php } ?>
            </tr>
        </table>
    </div>

    <div id="clear"></div>
</div>

<script type="text/javascript">
                                                $(document).ready(function() {
<?php $tomorrow = date("Y-n-d", strtotime(date("Y-n-d") . ' +1 day')); ?>
                                                    $(".datepicker").datepicker({dateFormat: "dd-mm-yy", minDate: new Date(<?php echo '"' . date("Y", strtotime($tomorrow)) . '"' ?>,<?php echo '"' . date("n", strtotime($tomorrow)) . '"' ?>,<?php echo '"' . date("d", strtotime($tomorrow)) . '"' ?>)});
                                                })
</script>
