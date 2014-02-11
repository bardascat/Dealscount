<?php
/* @var  $offer \Dealscount\Models\Entities\Item */ $offer;
$company = $offer->getCompany();
$companyDetails = $company->getCompanyDetails();
$images = $offer->getImages();
?>
<style>
    .beneficii a{color:#000;}
</style>
<script type='text/javascript' src='<?php echo base_url('assets/js/jquery.innerfade.js') ?>'></script>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>

<div class="content offer_page">
    <div class="info_bar">
        <div class="breadcrumbs">
            <?php echo ($offer->getCompany_name() ? $offer->getCompany_name() : $companyDetails->getCommercial_name()) ?>
        </div>
        <div class="location">
            <?php echo $offer->getLocation() ?>
        </div>
    </div>

    <div class="offer">
        <table border="0" height="200" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="vertical-align: top;">

                    <div class="short_desc">
                        <table border="0">
                            <tr>
                                <td>
                                    <?php echo $offer->getBrief() ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <table border="0" width="412" height="95" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">



                                    <tr>
                                        <td class="title_off" width="107">

                                            Timp ramas: <?php echo $offer->getRemainingHours() ?> ore
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="title_off" width="107">Cumparate: 5</td>

                                    </tr>
                                    <tr>
                                        <td class="title_off"  width="107">Reducere: - <?php echo $offer->getPercentageDiscount() ?>%</td>

                                    </tr>
                                    <tr>
                                        <td class="title_off"  width="107">Pret intreg: <span style="text-decoration: line-through"><?php echo $offer->getPrice() ?> lei</span></td>

                                    </tr>

                                </table>

                            </td>

                            <td height="200" class="buy_offer_container" rowspan="4">
                                <table border="0" width="100%" class="price_table">
                                    <tr>

                                        <td class="real_price">
                                            <?php echo $offer->getSale_price() ?>
                                            <span style="font-size: 20px;">lei</span>

                                        </td>

                                        <td>

                                            <!-- <h2 style="color:#D00; margin-right:20px;">Sold Out</h2> -->


                                            <a class="cumpara_btn" href="<?= base_url('oferte/' . $offer->getIdItem()) ?>"></a>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="0" cellspacing="0" height="55" style="font-size: 13px;" class="info_table" width="100%">
                        <tr>
                            <td id="beneficii_td" class="selected">
                                <a style="color:#000" href="javascript:toggle_info('beneficii')">Beneficii</a>
                            </td>

                            <td id="termeni_td">
                                <a style="color:#000" href="javascript:toggle_info('termeni')">Termeni</a>
                            </td>

                            <td id="partener_td">
                                <a style="color:#000" href="javascript:toggle_info('partener')">Partener</a>
                            </td>

                            <td id="telefon_td" width="81">
                                <a style="color:#000" href="javascript:toggle_info('telefon')">Contact</a>
                            </td>
                        </tr>
                    </table>

                </td>
                <td width="393" style="text-align: center">
                    <div id="fader" style="width:393px;height:312px;overflow:hidden;padding-left:0px;">
                        <ul id="the_fade">
                            <?php foreach ($images as $image) { ?>
                                <li><img src="<?php echo base_url($image->getImage()) ?>" width="393" height="312"></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <script type="text/javascript">
                        /*   $("#the_fade").innerfade({
                         timeout: 6000
                         }); */
                    </script>

                </td>
            </tr>

            <tr  style="font-size: 13px;">
                <td class="desc" colspan="2">
                    <div class="beneficii">
                        <?php echo $offer->getBenefits() ?>
                    </div>
                    <div class="termeni" style="display: none;">
                        <?php echo $offer->getTerms() ?>
                    </div>

                    <div class="partener" style="display: none;">
                        <?php echo $companyDetails->getDescription() ?>
                    </div>

                    <div class="telefon" style="display: none;">
                        <table width="100%">
                            <tr>
                                <td style=" ">
                                    <b>Adresa</b><?php echo $companyDetails->getAddress() ?></br>
                                    <b>Site</b><?php echo $companyDetails->getWebsite() ?></br>
                                    <b>Email</b><?php echo $company->getEmail() ?></br>
                                    <b>Telefon</b><?php echo $companyDetails->getPhone() ?></br>
                                </td>



                                <td style="padding-left: 15px;">
                                    <div style="width: 340px;display:block;float: right; margin-top:0px;">
                                        <div class="offer_box_head"></div>
                                        <div class="offer_detalii">
                                            <?php if ($offer->getLongitude() && $offer->getLatitude()) { ?>
                                                <div class="googlemap">
                                                    <div style="width: 360px; height: 285px; margin-top:10px;" id="map_canvas"></div>
                                                    <span  style=" font-size:11px;">Vezi <a class="harta_popup" href="" style="color:#0000FF;text-align:left" target="_blank">harta mai mare</a> </span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {
<?php if ($offer->getLongitude() && $offer->getLatitude()) { ?>
            displayMap("<?php echo $offer->getLatitude() ?>", "<?php echo $offer->getLongitude() ?>");
<?php } ?>
    })
    function optBox(id) {
        var html = $('#offer_' + id).html();

        $.fancybox.open({
            content: html,
            width: 580,
            autoSize: true,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });
    }

    function toggle_info(info) {

        var current_selected = $('.info_table .selected');

        if (info + '_td' != current_selected.attr('id')) {
            var id = $(current_selected).attr('id');
            var myArray = id.split('_');

            $('.' + myArray[0]).fadeOut(100, function() {
                $(current_selected).removeClass("selected");
                $('#' + info + "_td").addClass("selected");
                $('.' + info).fadeIn(100, function() {
                    google.maps.event.trigger(map, 'resize');
                    map.setCenter(new google.maps.LatLng('<?=$offer->getLatitude()?>','<?=$offer->getLongitude()?>'));
                })
            });



        }


    }

</script>