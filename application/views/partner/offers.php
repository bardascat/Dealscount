<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="offers_list">

            <?php
            $offers = $user->getItems();
            if (count($offers)) {
                ?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <?php foreach ($offers as $offer) { ?>
                            <tr>
                                <td width="150" class="offer_image">
                                    <a href="<?php echo base_url('oferte/detalii-oferta/' . $offer->getIdItem()) ?>">
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
                                    <a class="offers_details" href="<?php echo base_url('partener/detalii-oferta/' . $offer->getIdItem()) ?>"></a>
                                    <a class="red_button" style="color: #FFF; margin-top: 15px; margin-bottom: 15px;" 
                                       href="<?php echo ($offer->getActive() ? base_url('partener/suspenda-oferta/' . $offer->getIdItem()) : base_url('partener/activeaza-oferta/' . $offer->getIdItem())) ?>"><?php echo ($offer->getActive() ? "Suspenda" : "Reporneste"); ?></a>
                                    <select class="promoted" name="promoted">
                                        <option value="1">Promovata</option>
                                        <option value="0">Nepromovata</option>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>


        </div>


    </div>
    <div id="clear"></div>
</div>
