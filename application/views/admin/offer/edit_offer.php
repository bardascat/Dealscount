<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script>
    $(function() {
        $(document).tooltip({
            position: {
                my: "center bottom-20",
                at: "left+20 top",
                using: function(position, feedback) {
                    $(this).css(position);
                    $("<div>")
                            .addClass("arrow")
                            .appendTo(this);
                }
            }
        });
        $("#tabs").tabs();
        load_offer_editor();
        $("input[type=submit]").button();
        $("input[type=button]").button();

        $('.fancybox').fancybox({
            'transitionIn': 'fade',
            'height': 100,
            afterShow: function() {
                $(".fancybox-inner").css({'overflow-x': 'hidden'});

            }
        });
        $(".datepicker").datetimepicker({timeFormat: 'HH:mm:ss', dateFormat: "dd-mm-yy"});

    });
</script>

<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <?php $this->load->view('admin/left_menu'); ?>
            <td class='content index'>
                <!-- content -->
                <div>
                    <?php echo $this->session->flashdata('form_message'); ?>
                    <?php if (isset($notification)) echo $this->view->show_message($notification) ?>
                </div>

                <form id="addProductForm" method="post" action="<?= base_url() ?>admin/offer/editOfferDo" enctype="multipart/form-data">
                    <input type="hidden" name="id_item" value="<?=$item->getId_item()?>"/>
                    <div class="categoriesInput">
                    </div>
                    <div id="submit_btn_right">
                        <input onclick="addProduct()" type="button" value="Salveaza" />
                    </div>
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Detalii</a></li>
                            <li><a href="#tabs-2">Finante</a></li>
                            <li><a href="#tabs-3">Date</a></li>
                            <li><a href="#tabs-4">Galerie Foto</a></li>
                            <li><a href="#tabs-5">SEO</a></li>
                        </ul>
                        <div id="tabs-1">

                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>Nume</label>
                                    </td>
                                    <td class='input' >
                                        <input id="name" title="Maxim 90 de caractere" maxlength="90" type='text' value="<?php echo set_value('name') ?>" name='name'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Scurta descrierie</label>
                                    </td>
                                    <td class='input' >
                                        <input id="name" type='text' value="<?php echo set_value('brief') ?>" name='brief'/>
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
                        <div id="tabs-2">

                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class="label">
                                        Pret Intreg
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" value="<?php echo set_value('price') ?>" name="price"/>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="label">
                                        Pret cu cupon
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" value="<?php echo set_value('voucher_price') ?>" name="voucher_price"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        Pret Vanzare
                                    </td>
                                    <td class='small_input'>
                                        <input type="text"  value="<?php echo set_value('sale_price') ?>" name="sale_price"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        Comision
                                    </td>
                                    <td class='small_input'>
                                        <input value="<?php echo set_value('commission') ?>" type="text" name="commission"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        Incrementare vanzari
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" value="<?php echo set_value('startWith') ?>" name="startWith"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Categorie</label>
                                    </td>
                                    <td class='input'>
                                        <a class="fancybox" href="#alege_categorie">Modifica Categorie Produs (  
                                            <?php
                                            if ($item->getCategory())
                                                echo "Categorie Curenta: " . $item->getCategory()->getName();
                                            else
                                                echo "Nicio categorie aleasa";
                                            ?> )</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">
                                        Nume partener
                                    </td>
                                    <td class='small_input'>
                                        <input type="text" value="<?php echo set_value('company_name') ?>"  name="company_name"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Partener</label>
                                    </td>
                                    <td class='input'>
                                        <select name="id_company">
                                            <option value="">Alege partener</option>
                                            <?php
                                            if ($companies) {
                                                foreach ($companies as $company) {
                                                    $companyDetails = $company->getCompanyDetails();
                                                    ?>

                                                    <option value="<?= $company->getId_user(); ?>"><?= $companyDetails->getCompany_name() ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

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
                                    <td colspan="2"><b>Oferta</b></td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Data de Inceput</label>
                                    </td>
                                    <td class='small_input' >
                                        <input class="datepicker"  value="<?php echo set_value('start_date') ?>"  type="text" name="start_date"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Data de sfarsit</label>
                                    </td>
                                    <td class='small_input' >
                                        <input  class="datepicker" type="text" value="<?php echo set_value('end_date') ?>"  name="end_date"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"><b>Voucher</b></td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Data de Inceput</label>
                                    </td>
                                    <td class='small_input' >
                                        <input  class="datepicker" type="text" value="<?php echo set_value('voucher_start_date') ?>"  name="voucher_start_date"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Data de sfarsit</label>
                                    </td>
                                    <td class='small_input' >
                                        <input   class="datepicker" type="text" value="<?php echo set_value('voucher_end_date') ?>" name="voucher_end_date"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Nr. maxim vouchere</label>
                                    </td>
                                    <td class='small_input' >
                                        <input  type="text" value="<?php echo set_value('voucher_max_limit') ?>"  name="voucher_max_limit"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Nr. maxim vouchere user</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type="text" name="voucher_max_limit_user" value="<?php echo set_value('voucher_max_limit_user') ?>"/>
                                    </td>
                                </tr>


                                <tr>
                                    <td class='big_label'>
                                        <label>Latitudine</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' value="<?php echo set_value('latitude') ?>" name='latitude'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Longitudine</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' value="<?php echo set_value('longitude') ?>" name='longitude'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Zona</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' value="<?php echo set_value('location') ?>" name='location'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='big_label'>
                                        <label>Oras</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' value="<?php echo set_value('city') ?>" name='city'/>
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
                            <div class='new_image' onclick="new_image()">Poza Noua</div>
                            <table id="pictures_table" border="0" width="100%">
                                <?php
                                $photos = $item->getImages();
                                foreach ($photos as $photo) {
                                    ?>
                                    <tr id="<?php echo $photo->getId_image() ?>">
                                        <td width="400">
                                            <img height="150" src="<?php echo base_url($photo->getImage()) ?>"/>
                                        </td>
                                        <td style="vertical-align: top">
                                            <input id="princ_<?= $photo->getId_image() ?>" type="radio" <?php if ($photo->getPrimary()) echo "checked"; ?> name="primary_image" value="<?= $photo->getId_image() ?>"/>  <label for="princ_<?= $photo->getId_image() ?>">Poza Principala</label> 
                                            <a class="delete_photo" href="javascript:delete_image(<?= $photo->getId_image() ?>)">Sterge</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>

                        </div>

                        <div id="tabs-5">
                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>META Title</label>
                                    </td>
                                    <td class="input">
                                        <input type="text" name="meta_title"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>META Description</label>
                                    </td>
                                    <td class="input">
                                        <input type="text" name="meta_desc"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>TAG(separate prin virgula)</label>
                                    </td>
                                    <td class="input">
                                        <input type="text" 
                                               value="<?php
                                               if ($item->getTags()) {
                                                   $tags = '';
                                                   foreach ($item->getTags() as $tag)
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
                                    <td class="input">
                                        <input title="Atentie ! Daca modificati url-ul ofertei, vechiul url va fi inexistent." type="text" name="slug"/>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </form>
                <!-- end content -->
            </td>
        </tr>
    </table>


    <div id="alege_categorie" style="width: 600px;">
        <h1>Alege din ce categorii face parte acesta oferta (Categoria finala)</h1>
        <?php print_r($tree); ?>
    </div>

</div>