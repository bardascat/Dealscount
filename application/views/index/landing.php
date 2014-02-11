<?php /* @var  $offers \Dealscount\Models\Entities\Item */ $offers; ?>
<div class="content" style="margin-left: 194px;">
    <!-- infobar -->
    <div class="info_bar">
        <div class="breadcrumbs">
            Toate Categoriile
        </div>


        <table class="filtre" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table border="0">
                        <tr>
                            <td style="padding-right: 5px;">
                                Pret
                            </td>
                            <td style="padding-right: 2px;">
                                <a href="" >
                                    <img src="<?php echo base_url() . 'assets' ?>/images_fdd/filtru_up.png"/>
                                </a>
                            </td>
                            <td>
                                <a href="" >
                                    <img src="<?php echo base_url() . 'assets' ?>/images_fdd/filtru_down.png"/>
                                </a>
                            </td>

                        </tr>
                    </table>
                </td>
                <td>
                    <table border="0" style="margin-left: 20px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding-right: 5px;">
                                <a href="" style="color: #000;" class="oferte_noi">
                                    Oferte noi
                                </a>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <!-- end infobar -->

    <div class="offers" style="clear: both;">

        <?php
        if ($offers) {
            foreach ($offers as $offer) {
                $company=$offer->getCompany();
                $companyDetails=$company->getCompanyDetails();
                ?>
                <div class="box">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <div class="title">
                                    <div class="name">
                                        <?php  echo ($offer->getCompany_name() ? $offer->getCompany_name() : $companyDetails->getCommercial_name() )?>
                                    </div>
                                    <div class="location">
                                       <?php  echo $offer->getLocation()?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>

                                <div class="abs_info" style="z-index: 990">
                                    <div class="info_pos black">
                                        <?php echo $offer->getRemainingHours()?> ore
                                    </div>
                                    <div class="info_pos cart">
                                        123
                                    </div>
                                    <div class="info_pos">
                                        <?php echo $offer->getPercentageDiscount()?>%
                                    </div>
                                    <div class="info_pos grey">
                                        <span style="text-decoration: line-through"><?php echo $offer->getPrice()?> lei</span>
                                    </div>

                                </div>

                                <a href="<?php echo base_url('oferte/'.$offer->getSlug())?>">
                                    <img
                                        alt="<?php echo $offer->getName()?>"
                                        id="<?php echo $offer->getIdItem()?>"
                                        onmouseover="main_img_mouseover(this)"
                                        src='<?php echo base_url($offer->getMainImage())?>' 
                                        title="" width="222" height="180" />

                                    <img class="lupa_hover"  onmouseout="main_img_mouseleave(this)" id="anim_<?php echo $offer->getIdItem()?>" style="position: absolute; z-index: 999; display: none;" src="<?php echo base_url() . 'assets' ?>/images_fdd/hover_poza.png"/>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="desc">
                                <div style="float: left;  height: 50px; overflow: hidden">
                                    <a style="color: #434343" href="<?php echo base_url('oferte/'.$offer->getSlug())?>">     
                                        <?php echo $offer->getName()?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 7px; padding-top: 0px;">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="cost" width="112">
                                            <span class="price"><?php echo $offer->getPrice()?></span>
                                            <span class="currency">lei</span>
                                        </td>

                                        <td style="vertical-align: bottom">
                                            <a href="<?php echo base_url('oferte/'.$offer->getSlug())?>">
                                                <img 
                                                    onmouseover="mouse_over_img(this)"
                                                    onmouseout="mouse_out_img(this)"
                                                    src="<?php echo base_url() . 'assets' ?>/images_fdd/lupa_1.png"/>
                                            </a>
                                        </td>
                                        <td style="vertical-align: bottom">

                                            <a href="/buy.php?offer_id={{$tvars.offer.id}}">
                                                <img 
                                                    onmouseover="mouse_over_img_cumpara(this)"
                                                    onmouseout="mouse_out_img_cumpara(this)"
                                                    src="<?php echo base_url() . 'assets' ?>/images_fdd/carucior_1.png"/>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>

            <!--
            <a href="#wrapper" id="back_top">
                <img src="<?php echo base_url() . 'assets' ?>/images_fdd/up.png"/>
            </a>
            -->
        <?php } else { ?>
            <div id="no_offers"><?php echo $no_data ?></div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
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

                                        $(document).ready(function() {
                                            
                                            //$('<a title="" href="template/templates/show_popup.php?iframe=true&width=620&height=356"></a>').prettyPhoto().click()
                                        });
                                        function closeBox() {

                                            jQuery.prettyPhoto.close();

                                        }



</script>


