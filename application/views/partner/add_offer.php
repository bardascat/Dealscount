<?php
/* @var $user Dealscount\Models\Entities\User */
/* @var $offer Dealscount\Models\Entities\Item */;
?>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?sensor=false'></script>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="edit_offer">

            <h1></h1>

            <div class="offer_form">
                <form id="saveForm" method="post" action="<?= base_url() ?>partener/addOfferDo" enctype="multipart/form-data">
                    <div id="tabs">

                        <div id="tabs-1">

                            <table  border='0' width='100%'>
                                <tr>
                                    <td colspan="2">
                                        <div>
                                            <?php echo $this->session->flashdata('form_message'); ?>
                                            <?php if (isset($notification)) echo $this->view->show_message($notification) ?>
                                        </div>
                                    </td>
                                </tr>
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
                                        <textarea  id="name" title="Acest titlu va aparea in pagina ofertei. Nu trebuie sa depaseasca 6 randuri" name='brief'><?php echo set_value('brief') ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Categorie</label>
                                    </td>
                                    <td class='input'>
                                        <select onchange="selectSubcategory(this)" name="category">
                                            <?php foreach ($categories as $category) { ?>
                                                <option  value="<?php echo $category['id_category'] ?>"><?php echo $category['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Subcategorie</label>
                                    </td>
                                    <td class='input'>
                                        <select name="subcategory">
                                            <?php
                                            
                                            if ($parent) {
                                                $childs = $parent->getChildren();
                                                foreach ($childs as $child) {
                                                    echo "<option value='" . $child->getId_category() . "'>" . $child->getName() . "</option>";
                                                }
                                            } else
                                                echo "<option value='0'>Fara subcategorii</option>"
                                                ?>
                                        </select>
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
                                        <input title="Dati click pe harta google si alegeti locatia" class="lat" type='text' value="<?php echo set_value('latitude') ?>" name='latitude'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Longitudine</label>
                                    </td>
                                    <td class='' >
                                        <input class="lng" type='text' value="<?php echo set_value('longitude') ?>" name='longitude'/>
                                        <a style="position: absolute; margin-left: 50px; margin-top:-30px;" id="inline" href="#data"><img height="50" src="<?php echo base_url('assets/images_fdd/gmap.jpg') ?>"/></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Incepe</label>
                                    </td>
                                    <td class='' >
                                        <div class="programeaza">
                                            <input style="width: 230px;" readonly="" class="datepicker"  value="<?php echo set_value('start_date') ?>"  type="text" name="start_date"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Se termina</label>
                                    </td>
                                    <td class=''>
                                        <div class="programeaza">
                                            <input  style="width: 230px;"  readonly="" class="datepicker" type="text" value="<?php echo set_value('end_date') ?>"  name="end_date"/>
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
                                                        <input style="width: 80px;" readonly=""  class="datepickersimple" type="text" value="<?php echo set_value('voucher_start_date') ?>"  name="voucher_start_date"/>
                                                    </div>
                                                </td>
                                                <td style="padding-bottom: 0px; padding-left: 10px;">
                                                    -
                                                </td>
                                                <td style="padding-left: 10px; padding-bottom: 0px;" class="">
                                                    <div class="programeaza" style="">
                                                        <input style="width: 80px;" readonly="" class="datepickersimple" type="text" value="<?php echo set_value('voucher_end_date') ?>" name="voucher_end_date"/>    
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
                                        <input type="text" value="<?php echo set_value('price') ?>" name="price"/> lei
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        Pret Redus
                                    </td>
                                    <td class=''>
                                        <input type="text" value="<?php echo set_value('voucher_price') ?>" name="voucher_price"/> lei
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
                                <input type="hidden" name="id_company" value="<?php echo $user->getId_user()?>"/>

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
                            <h2>Imagini </h2>
                            <div style="margin-top: 25px;" class='add_images'>
                                <div class='image_group'>
                                    <input type='file'  name='image[]'/>
                                </div>

                            </div>
                            <div class="plusButton" onclick="new_image()"></div>
                            <div class="pictures">
                                
                            </div>
                            <div id="clear"></div>

                        </div>

                        <div id="tabs-5">
                            <h2>SEO</h2>
                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>META Title</label>
                                    </td>
                                    <td class="big_input">
                                        <input type="text" value="<?php echo set_value('meta_title') ?>" name="meta_title"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>META Description</label>
                                    </td>
                                    <td class="big_input">
                                        <input value="<?php echo set_value('meta_desc') ?>" title="Recomandam sa fie sub 150 de caractere" type="text" name="meta_desc"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Keywords</label>
                                    </td>
                                    <td class="big_input">
                                        <input value="<?php echo set_value('tags') ?>" title="Separati cuvintele cheie prin virgula ex: reducere tenis, oferta pizza" type="text" 
                                               name="tags"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Link Oferta</label>
                                    </td>
                                    <td class="big_input">
                                        <input value="<?php echo set_value('slug') ?>" title="Atentie ! Daca modificati url-ul ofertei, vechiul url va fi inexistent." type="text" name="slug"/>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="tabs-6">
                            <table>
                                <tr>
                                    <td style="padding-top: 45px;">
                                        <div onclick="$('#saveForm').submit()" id="greenButton">Creeaza Oferta</div>
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
<style>
    .ui-dialog{font-size: 10px;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        selectSubcategory($('select[name="category"]'));

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
        $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy",minDate: new Date(), maxDate: new Date(<?php echo date("Y", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>,<?php echo date("m", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>,<?php echo date("d", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>)});
        $(".datepickersimple").datepicker({dateFormat: "dd-mm-yy",minDate: new Date(), maxDate: new Date(<?php echo date("Y", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>,<?php echo date("m", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>,<?php echo date("d", strtotime($user->getCompanyDetails()->getAvailable_to()->format("Y-m-d"))) ?>)});

    })
    $(document).ready(function() {
        $('#inline').fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            beforeShow: function() {
                google.maps.event.trigger(map, "resize");
                map.setCenter(new google.maps.LatLng('44.435511213939165','26.1025071144104')); 
            }
        });
        globalZoom=12;
        displayPartnerMap('44.435511213939165','26.1025071144104');
    });

</script>
<div style="display:none">
    <div id="data">
        <div class="googlemap" style="float: right;">
            <div style="width: 530px; height: 400px" id="map_canvas"></div>
        </div>
    </div>
</div>
