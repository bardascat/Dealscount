<?php
/* @var $item \Dealscount\Models\Entities\Item */
$variants = $item->getItemVariants();
if (count($variants) < 1)
    show_404();
?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/multiplebuy_popup.css') ?>"/>

<div id='mb_container' style='float: left;  min-height: 150px;'>
    <table width="650" cellpadding="0" cellspacing="0" id="multipleBuyTable" border="0">
        <tr>
            <th width="230" class="option">Optiune</th>
            <th class="">Pret Intreg</th>
            <th class="discount">Reducere</th>
            <th class="sale_price">Platesti</th>
            <th width="170"></th>
        </tr>
        <?php //pe langa variante trebuie sa adaugam si posibilitatea sa cumpere produsul origina ?>

        <tr>
            <td class="optionTd">
                <?php echo $item->getName(); ?>
            </td>
            <td class="price">
                <?php echo $item->getPrice(); ?> lei
            </td>
            <td>
                <?php echo $item->getPercentageDiscount(); ?>%
            </td>
            <td class="youPay">
                <?php echo $item->getVoucher_price(); ?> lei
            </td>
            <td>
                <form method="post" action="<?php echo base_url('neocart/add_to_cart') ?>">
                    <input type="hidden" name="id_item" value="<?php echo $item->getIdItem() ?>"/>
                    <input type="hidden" name="quantity" value="1"/>
                    <div onclick="$(this).parents('form:first').submit()" id="greenButtonSmall">Cumpara</div>
                </form>
            </td>
        </tr>


        <?php
        foreach ($variants as $variant) {
            ?>
            <tr>
                <td class="optionTd">
                    <?php echo $variant->getDescription(); ?>
                </td>
                <td class="price">
                    <?php echo $variant->getPrice(); ?> lei
                </td>
                <td>
                    <?php echo $variant->getPercentageDiscount(); ?>%
                </td>
                <td class="youPay">
                    <?php echo $variant->getVoucher_price(); ?> lei
                </td>
                <td>
                    <form method="post" action="<?php echo base_url('neocart/add_to_cart') ?>">
                        <input type="hidden" name="id_item" value="<?php echo $item->getIdItem() ?>"/>
                        <input type="hidden" name="id_variant" value="<?php echo $variant->getId_variant() ?>"/>
                        <input type="hidden" name="quantity" value="1"/>
                        <div onclick="$(this).parents('form:first').submit()" id="greenButtonSmall">Cumpara</div>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
