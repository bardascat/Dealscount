<?php /* @var  $offers \Dealscount\Models\Entities\Item */ $offers;
?>

<div id="content">
    <div class="offers_list">
        <?php
        if ($offers) {
            if (isset($_GET['q'])) {
                echo "<div style='margin-bottom:20px; font-weight:bold;'>Ati cautat \"" . $_GET['q'].'" ('.count($offers).' rezultate)</div>';
            }
            foreach ($offers as $offer) {
                $company = $offer->getCompany();
                $companyDetails = $company->getCompanyDetails();
                ?>
                <div class="offer">
                    <div class="image">
                        <div class="image_over">
                            <div class="time_left"><?php echo $offer->getRemainingHours() ?></div>
                        </div>
                        <div class="image_over" style="top: 37px; text-align: center;">-<?php echo $offer->getPercentageDiscount() ?>%</div>
                        <a href="<?php echo base_url('oferte/' . $offer->getSlug()) ?>">
                            <img width="233" src="<?php echo base_url($offer->getMainImage()) ?>"/>
                        </a>
                    </div>
                    <div class="info">
                        <?php echo $offer->getName() ?>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="price_details">
                        <tr>
                            <td style="padding-left: 20px;" width="30">
                                <a class="view" href="<?php echo base_url('oferte/' . $offer->getSlug()) ?>"></a>
                            </td>
                            <td width="120" class="price">

                                <span style="font-size: 22px;">
                                    <?php echo $offer->getVoucher_price() ?> <span>lei</span>
                                </span>
                                <span style="text-decoration: line-through">
                                    <?php echo $offer->getPrice() ?> lei
                                </span>
                            </td>
                            <td style="padding-left: 10px;">
                                <form id="buy_<?php echo $offer->getIdItem() ?>" method="post" action="<?php echo base_url('neocart/add_to_cart') ?>">
                                    <input type="hidden" name="quantity" value="1"/>
                                    <input type="hidden" name="id_item" value="<?php echo $offer->getIdItem() ?>"/>
                                    <a class="cart" href="javascript:<?php echo (count($offer->getItemVariants())>0 ? "javascript:add_to_cart(".$offer->getIdItem().",'mb')" : "$('#buy_".$offer->getIdItem()."').submit()")?>"></a>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
            }
        } else {
            if (isset($_GET['q'])) {
                echo "<h3>Nu am gasit nicio oferta. Incercati o cautare mai generala</h3>";
            } else {
                ?>
                Nu exista oferte active
            <?php }
        }
        ?>
    </div>
    <div id="clear"></div>
</div>
