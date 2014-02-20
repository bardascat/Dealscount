<?php /* @var  $offers \Dealscount\Models\Entities\Item */ $offers;
?>

<div id="content">
    <div class="offers_list">
        <?php
        if ($offers) {
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
                                <?php echo $offer->getSale_price() ?> <span>lei</span>
                            </td>
                            <td style="padding-left: 10px;">
                                <a class="cart" href="<?php echo base_url('') ?>"></a>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
            }
        } else {
            ?>
            Nu exista oferte active
        <?php } ?>
    </div>
    <div id="clear"></div>
</div>
