<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $offer Dealscount\Models\Entities\Item */;
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="edit_offer">

            <h1><?php echo $offer->getName() ?></h1>

            <div class="offer_form">
                <form id="addProductForm" method="post" action="<?= base_url() ?>admin/offer/editOfferDo" enctype="multipart/form-data">
                    <input type="hidden" name="id_item" value="<?= $offer->getId_item() ?>"/>
                    <div id="tabs">

                        <div id="tabs-1">

                            <table  border='0' width='100%'>
                                <tr>
                                    <td class='label'>
                                        <label>Titlu homepage</label>
                                    </td>
                                    <td class='big_input' >
                                        <input id="name" maxlength="90"  title="Maxim 90 de caractere" maxlength="90" type='text' value="<?php echo set_value('name') ?>" name='name'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Titlu Oferta</label>
                                    </td>
                                    <td class='big_input' >
                                        <input id="name" title="Acest titlu va aparea in pagina ofertei. Nu trebuie sa depaseasca 6 randuri"  type='text' value="<?php echo set_value('brief') ?>" name='brief'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Categorie</label>
                                    </td>
                                    <td class='input'>
                                        <a class="fancybox" href="#alege_categorie">Modifica Categorie Produs (  
                                            <?php
                                            if ($offer->getCategory())
                                                echo "Categorie Curenta: " . $offer->getCategory()->getName();
                                            else
                                                echo "Nicio categorie aleasa";
                                            ?> )</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Oras</label>
                                    </td>
                                    <td class='' >
                                        <input type='text' value="<?php echo set_value('city') ?>" name='city'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Zona</label>
                                    </td>
                                    <td class='' >
                                        <input type='text' value="<?php echo set_value('location') ?>" name='location'/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Latitudine</label>
                                    </td>
                                    <td class='' >
                                        <input type='text' value="<?php echo set_value('latitude') ?>" name='latitude'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Longitudine</label>
                                    </td>
                                    <td class='' >
                                        <input type='text' value="<?php echo set_value('longitude') ?>" name='longitude'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Incepe</label>
                                    </td>
                                    <td class='' >
                                        <div class="programeaza">
                                            <input style="width: 230px;" class="datepicker"  value="<?php echo set_value('start_date') ?>"  type="text" name="start_date"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Se termina</label>
                                    </td>
                                    <td class=''>
                                        <div class="programeaza">
                                            <input  style="width: 230px;"  class="datepicker" type="text" value="<?php echo set_value('end_date') ?>"  name="end_date"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        Valabilitate Voucher
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td class="" style="padding-bottom: 0px;">
                                                    <div class="programeaza">
                                                        <input style="width: 80px;"  class="datepicker" type="text" value="<?php echo set_value('voucher_start_date') ?>"  name="voucher_start_date"/>
                                                    </div>
                                                </td>
                                                <td style="padding-bottom: 0px; padding-left: 10px;">
                                                    -
                                                </td>
                                                <td style="padding-left: 10px; padding-bottom: 0px;" class="">
                                                    <div class="programeaza" style="">
                                                        <input style="width: 80px;"  class="datepicker" type="text" value="<?php echo set_value('voucher_end_date') ?>" name="voucher_end_date"/>    
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="tabs-2">

                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class="label">
                                        Pret Intreg
                                    </td>
                                    <td class=''>
                                        <input type="text" value="<?php echo set_value('price') ?>" name="price"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        Pret Redus
                                    </td>
                                    <td class=''>
                                        <input type="text" value="<?php echo set_value('voucher_price') ?>" name="voucher_price"/>
                                        <input type="hidden"  value="0" name="sale_price"/>
                                        <input value="0" type="hidden" name="commission"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Nr. total vouchere</label>
                                    </td>
                                    <td class='' >
                                        <input  type="text" value="<?php echo set_value('voucher_max_limit') ?>"  name="voucher_max_limit"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Vouchere/Persoana</label>
                                    </td>
                                    <td class=''>
                                        <input type="text" name="voucher_max_limit_user" value="<?php echo set_value('voucher_max_limit_user') ?>"/>
                                    </td>
                                </tr>
                                <input type="hidden" value="<?php echo set_value('company_name') ?>"  name="company_name"/>
                                <input type="hidden" name="id_company"/>

                            </table>

                        </div>
                        <div id="tabs-3">
                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>Vizibila? </label>
                                    </td>
                                    <td class='input' >
                                        <select name="active">
                                            <option value="1">Da</option>
                                            <option value="0">Nu</option>
                                        </select>
                                    </td>
                                </tr>


                                <tr>
                                    <td class='label'>
                                        <label>Beneficii/Descriere</label>
                                    </td>
                                    <td class='input'>
                                        <textarea id='benefits' name='benefits'><?php echo set_value('benefits') ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Termeni</label>
                                    </td>
                                    <td class='input'>
                                        <textarea id='terms' name='terms'><?php echo set_value('terms') ?></textarea>
                                    </td>
                                </tr>

                            </table>

                        </div>
                        <div id="tabs-4">
                            <div class='add_images'>
                                <div class='image_group'>
                                    <input type='file' name='image[]'/>
                                </div>
                            </div>
                            <div class="pictures">
                                <?php
                                $photos = $offer->getImages();
                                foreach ($photos as $photo) {
                                    ?>
                                    <div class="image">
                                        <img height="130" src="<?php echo base_url($photo->getImage()) ?>"/>
                                    </div>
                                <?php } ?>
                            </div>
                            <div id="clear"></div>

                        </div>

                        <div id="tabs-5">
                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>META Title</label>
                                    </td>
                                    <td class="big_input">
                                        <input type="text" name="meta_title"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>META Description</label>
                                    </td>
                                    <td class="big_input">
                                        <input type="text" name="meta_desc"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Keywords</label>
                                    </td>
                                    <td class="big_input">
                                        <input type="text" 
                                               value="<?php
                                               if ($offer->getTags()) {
                                                   $tags = '';
                                                   foreach ($offer->getTags() as $tag)
                                                       $tags.=$tag->getValue() . ',';
                                                   $tags = substr($tags, 0, -1);
                                                   echo $tags;
                                               }
                                               ?>"
                                               name="tags"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>URL</label>
                                    </td>
                                    <td class="big_input">
                                        <input title="Atentie ! Daca modificati url-ul ofertei, vechiul url va fi inexistent." type="text" name="slug"/>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('input').tooltip({
            position: {
                my: "center bottom-20",
                at: "left+20 top",
                using: function(position, feedback) {
                    $(this).css(position);
                    $("<div style>")
                            .addClass("arrow")
                            .appendTo(this);
                }
            }
        });


        load_offer_editor();
        $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy"});
    })
</script>