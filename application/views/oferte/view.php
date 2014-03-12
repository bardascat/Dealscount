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

<div id="content">
    <div class="oferta_view">
        <div class="row row_one">
            <h1><?php echo $offer->getName() ?></h1>

            <div class="brief">
                <?php echo $offer->getBrief(); ?>
            </div>

            <div class="oferta_detalii">
                <div class="image">
                    <img height="384" src="<?php echo base_url($offer->getMainImage('image')) ?>" alt="<?php echo $offer->getName() ?>"/>
                </div>
                <div class="price_block">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <span class="price"><?php echo $offer->getVoucher_price() ?></span>
                                <span class="currency">lei</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form id="cart_form" method="post" action="<?php echo base_url('neocart/add_to_cart') ?>">
                                    <input type="hidden" name="id_item" value="<?php echo $offer->getIdItem() ?>"/>
                                    <input type="hidden" name="quantity" value="1"/>
                                    <a class="cumpara_btn" href="javascript:add_to_cart()"></a>

                                    <?php if ($this->view->getUser() && $this->view->getUser()['role'] == DLConstants::$ADMIN_ROLE) : ?>

                                        <a href='javascript:triggerAddOfferPopup()' style='margin-left: 0px; float: left;' class='greenButton '>Adaugă la Comandă</a>
                                        <a class="fancybox.iframe adminAdaugaItem" id="triggerAddItemPopup" href=""></a>

                                    <?php endif; ?>

                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" class="sales_details" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="100">
                                            Cumparate:
                                        </td>
                                        <td>
                                            <b>
                                                <?php
                                               echo ($offer->getStats() ? $offer->getStats()->getSales() : 0);
                                                ?>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Reducere:
                                        </td>
                                        <td>
                                            <b>-<?php echo $offer->getPercentageDiscount() ?>%</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Pret intreg:
                                        </td>
                                        <td>
                                            <span style="text-decoration: line-through"><b><?php echo $offer->getPrice() ?> lei</b></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Share:
                                        </td>
                                        <td>
                                            <table border="0">
                                                <tr>

                                                    <td style="border:0px;">
                                                        <div class="fb-like" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div>
                                                    </td>

                                                    <td style="border:0px;">
                                                        <g:plusone size="medium" annotation="none"></g:plusone>
                                                     </td>   

                                                   <td style="border:0px;">
                                                         <a href="https://twitter.com/share" data-count="none" class="twitter-share-button"></a>
                                                         <script>!function(d, s, id) {
                                                            var js, fjs = d.getElementsByTagName(s)[0];
                                                            if (!d.getElementById(id)) {
                                                                js = d.createElement(s);
                                                                js.id = id;
                                                                js.src = "//platform.twitter.com/widgets.js";
                                                                fjs.parentNode.insertBefore(js, fjs);
                                                            }
                                                        }(document, "script", "twitter-wjs");</script>
                                                    </td>
                                                </tr>
                                            </table>

                            </td>
                        </tr>
                    </table>
                    </td>
                    </tr>
                    </table>
                </div>
            </div>

            <div class="descriere">
                <h2>Despre Oferta</h2>
                <div class="info">
                    <?php echo $offer->getBenefits() ?>
                </div>
            </div>
        </div>

        <div class="row row_two">
            <div class="termeni">
                <h2>Termeni Oferta</h2>
                <div class="info">
                    <?php echo $offer->getTerms(); ?>
                </div>
            </div>
        </div>

        <div class="row row_three">
            <div class="company">

                <div class="info">
                    <table  width="100%" height="200" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="442">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="20">
                                            <h2><?php echo ($offer->getCompany_name() ? $offer->getCompany_name() : $companyDetails->getCommercial_name()) ?></h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="175">
                                            <?php if ($companyDetails->getImage()) { ?>
                                                <div style="margin-bottom: 10px;">
                                                    <img src="<?php echo base_url($companyDetails->getImage()) ?>"/>
                                                </div>
                                            <?php } ?>

                                            <?php if ($companyDetails->getAddress()) { ?>

                                                <label><b>Adresa:</b></label>

                                                <?php echo $companyDetails->getAddress() ?>

                                            <?php } ?>
                                            <?php if ($companyDetails->getWebsite()) { ?>

                                                <div>
                                                    <label><b>Site:</b></label>
                                                    <?php echo $companyDetails->getWebsite() ?>
                                                </div>
                                            <?php } ?>
                                            <div>
                                                <label><b>Email:</b></label>

                                                <?php echo $company->getEmail() ?>
                                            </div>
                                            <div>
                                                <label><b>Telefon:</b></label>

                                                <?php echo $companyDetails->getPhone() ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <?php if ($offer->getLongitude() && $offer->getLatitude()) { ?>
                                    <div class="googlemap" style="float: right;">
                                        <div style="width: 430px; height: 200px" id="map_canvas"></div>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>

                    <div class="compay_details">
                        <?php echo $companyDetails->getDescription() ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>  

<div id="fb-root"></div>
<!--
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
-->

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

<?php if ($offer->getLongitude() && $offer->getLatitude()) { ?>
            displayMap("<?php echo $offer->getLatitude() ?>", "<?php echo $offer->getLongitude() ?>");
<?php } ?>
        $(".adminAdaugaItem").fancybox({width: 550, height: 250, autoResize: false, autoSize: false, openEffect: 'none', closeEffect: 'none'});
        increment_offer_view(<?php echo $offer->getIdItem() ?>);
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

    function add_to_cart() {
        $('#cart_form').submit();
    }

</script>
