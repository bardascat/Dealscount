test cornel
okay's
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
        
        <?php // for($i=0;$i<=40;$i++) { ?>
        <div class="box">
            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="title">
                            <div class="name">
                                Nume comapnie
                            </div>
                            <div class="location">
                                Zona
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>

                        <div class="abs_info" style="z-index: 990">
                            <div class="info_pos black">
                                4 ore
                            </div>
                            <div class="info_pos cart">
                                123
                            </div>
                            <div class="info_pos">
                                -20%
                            </div>
                            <div class="info_pos grey">
                                <span style="text-decoration: line-through">129 lei</span>
                            </div>

                        </div>

                        <a href="/offer.php?offer_id={$tvars.offer.id}">
                            <img
                                id="12"
                                onmouseover="main_img_mouseover(this)"
                                class="lazy" src='http://getadeal.ro/offers_ug/29940/photo_26351.jpg' 
                                data-original="" title="" width="222" height="180" />

                            <img class="lupa_hover"  onmouseout="main_img_mouseleave(this)" id="anim_12" style="position: absolute; z-index: 999; display: none;" src="<?php echo base_url() . 'assets' ?>/images_fdd/hover_poza.png"/>
                            <noscript><img src="http://getadeal.ro/offers_ug/29940/photo_26351.jpg" width="222" height="180"></noscript>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="desc">
                        <div style="float: left;  height: 50px; overflow: hidden">
                            <a style="color: #434343" href="/offer.php?offer_id={$tvars.offer.id}">     
                                Denumire titlu
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 7px; padding-top: 0px;">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="cost" width="112">
                                    <span class="price">23</span>
                                    <span class="currency">lei</span>
                                </td>

                                <td style="vertical-align: bottom">
                                    <a href="/offer.php?offer_id={$tvars.offer.id}">
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
        <?php // } ?>

        <!--
        <a href="#wrapper" id="back_top">
            <img src="<?php echo base_url() . 'assets' ?>/images_fdd/up.png"/>
        </a>
        -->

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
        $("img.lazy").lazyload({
            effect: "fadeIn"
        });
        $("img.lazy").show().lazyload();
        $('<a title="" href="template/templates/show_popup.php?iframe=true&width=620&height=356"></a>').prettyPhoto().click()
    });
    function closeBox() {

        jQuery.prettyPhoto.close();

    }



</script>


