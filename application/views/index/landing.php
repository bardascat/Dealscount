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
                            <div class="time_left">3h 12min</div>
                        </div>
                        <div class="image_over" style="top: 37px;">-50%</div>
                        <img src="<?php echo base_url('assets/images_fdd/sample_offer.png') ?>"/>
                    </div>
                    <div class="info">
                        Ecografie mamara bilaterala + Consultatie mamara bilaterala + Buletin ecografic scris + 
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="price_details">
                        <tr>
                            <td style="padding-left: 20px;" width="30">
                                <a class="view" href=""></a>
                            </td>
                            <td width="120" class="price">
                                123 <span>lei</span>
                            </td>
                            <td style="padding-left: 10px;">
                                <a class="cart" href="cart"></a>
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
