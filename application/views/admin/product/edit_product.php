<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <!-- content -->

                <form id="addProductForm" method="post" action="<?= URL ?>admin/product/editProductDo" enctype="multipart/form-data">
                    <input type="hidden" name="id_item" value="<?= $this->item->getId_item() ?>"/>
                    <div class="categoriesInput"></div>
                    <div id="submit_btn_right">
                        <input onclick="return addProduct()"  type="button" value="Salveaza" />
                        <a class="jqueryButton" target="_blank" href="<?= URL . $this->item->getSlug() ?>">Vizualizare produs</a>
                    </div>
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Detalii</a></li>
                            <li><a href="#tabs-2">Specificatii</a></li>
                            <li><a href="#tabs-3">Variante</a></li>
                            <li><a href="#tabs-4">Galerie Foto</a></li>
                        </ul>
                        <div id="tabs-1">

                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>Nume</label>
                                    </td>
                                    <td class='input' >
                                        <input id="name" type='text' name='name'/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Pret Furnizor</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' name='price'/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Cod Furnizor</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' name='code'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Pret Vanzare</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' name='sale_price'/>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Discount</label>
                                    </td>
                                    <td class='small_input'>
                                        <select style="width: 100px;" name="discount">

                                            <option  value="0">Nu</option>
                                            <option value="1">Da</option>
                                        </select>
                                        <input type="text" placeholder="Pretul redus" style="margin-left: 15px;" name="reduced_price"/> lei
                                        <span style="padding-left: 20px;">Adauga in slideru-ul de reduceri(home)? </span><input type="checkbox" <? if ($this->item->getInclude_discount_slider()) echo "checked='checked'"; ?> style="width: auto;" name="include_discount_slider" <? ?> value="1"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Garantie</label>
                                    </td>
                                    <td class='small_input' >
                                        <input type='text' name='warranty'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Stoc</label>
                                    </td>
                                    <td class='small_input' >
                                        <select name="stock_status">
                                            <option value="">
                                                Nespecificat
                                            </option>
                                            <option value="S1">
                                                In stoc Furnizor
                                            </option>
                                            <option value="S2">
                                                Intrebati Stoc
                                            </option>
                                            <option value="S3">
                                                In curand
                                            </option>
                                            <option value="S4">
                                                Precomanda
                                            </option>
                                            <option value="S6">
                                                La comandă
                                            </option>
                                            <option value="S5">
                                                Indisponibil 
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Categorie</label>
                                    </td>
                                    <td class='input'>
                                        <a class="fancybox" href="#alege_categorie">Modifica Categorie Produs (  <?
                                            if ($this->item->getCategory())
                                                echo "Categorie Curenta: " . $this->item->getCategory()->getName();
                                            else
                                                echo "Nicio categorie aleasa";
                                            ?> )</a>
                                    </td>
                                </tr>
                                
                                <?if($this->item->getChristmas()) {?>
                                <tr>
                                    <td class='label'>
                                        <label>Pachete craciun</label>
                                    </td>
                                    <td class='input'>
                                        <select name="id_package">
                                            <option value="">Alege pachete</option>
                                            <?
                                            foreach ($this->special_packages as $package) {
                                                ?>
                                                <option value="<?= $package['id_package'];   ?>" <?if($package['id_package']==$this->special_package) echo ' selected ';?> ><?= $package['name']; ?></option>
                                            <? } ?>
                                        </select>
                                    </td>
                                </tr>
                                <? } ?>

                                <tr>
                                    <td class='label'>
                                        <label>Furnizor</label>
                                    </td>
                                    <td class='input'>
                                        <select name="id_company">
                                            <option value="">Alege partener</option>
                                            <?
                                            foreach ($this->companies as $company) {
                                                $companyDetails = $company->getCompanyDetails();
                                                ?>

                                                <option value="<?= $company->getId_user(); ?>"><?= $companyDetails->getCompany_name() ?></option>
                                            <? } ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class='label'>
                                        <label>Descriere</label>
                                    </td>
                                    <td class='input'>
                                        <textarea id='description' name='description'></textarea>
                                    </td>
                                </tr>

                            </table>

                        </div>

                        <div id="tabs-2">


                            <table  border='0' width='100%' id='add_table' class="specs_table">
                                <tr>
                                    <td>

                                        <?
                                        if ($this->specsCategory) {
                                            $index = 1;
                                            ?>
                                            <div id="tabsInner">
                                                <ul>
                                                    <? foreach ($this->specsCategory as $name => $specs) { ?>
                                                        <li><a href="#innerTab_<?= $index ?>"><?= $name ?></a></li>
                                                        <?
                                                        $index++;
                                                    }
                                                    ?>
                                                </ul>


                                                <?
                                                $index = 1;
                                                foreach ($this->specsCategory as $specs) {
                                                    ?>
                                                    <div id="innerTab_<?= $index ?>">
                                                        <table>
                                                            <?
                                                            foreach ($specs as $spec) {
                                                                ?> 

                                                                <tr>    
                                                                    <td class="label">
                                                                        <label>
                                                                            <?= $spec['spec_name'] ?> 
                                                                            <?
                                                                            if ($spec['isFilter'])
                                                                                echo "<span style='color:green'>(filtru)</span>";
                                                                            if ($spec['isHidden'])
                                                                                echo "<span style='color:green'>(ascuns)</span>";
                                                                            ?>
                                                                        </label>
                                                                        <input type="hidden" name="id_spec_value[]" value="<?= $spec['id'] ?>"/>
                                                                        <input type="hidden" name="id_specification[]" value="<?= $spec['id_spec'] ?>"/>

                                                                    </td>
                                                                    <td class="small_input <?= $spec['id_spec'] ?>">
                                                                        <div class="neoSelectInput">
                                                                            <textarea style="width:220px; height: 40px;" name="<?= $spec['id_spec'] ?>"></textarea>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                    <?
                                                    $index++;
                                                }
                                                ?>
                                            </div>
                                            <?
                                        } else {
                                            ?>
                                    <tr>
                                        <td><h2>Categoria produsului nu contine specificatii</h2></td>
                                    </tr>
                                <? } ?>

                                </td>
                                </tr>
                            </table>


                        </div>
                        <div id="tabs-3">
                            <table  id='add_table' border="0" class="variants_table" width="100%">
                                <tr>
                                    <td colspan="4" style="padding-bottom: 25px; font-size: 11px;"><b>Atentie:</b>
                                        Toate variantele produsului trebuie sa contina acelasi set de atribute.<br/> Ex: daca prima varianta are( Marime, Culoare) , celelalte variante trebuie sa aiba tot (Marime,Culoare) in aceeasi ordine.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 30px;"  colspan="4"><div onclick="addVariant()"  class="jqueryButton">Adaugă Variantă:</div> </td>
                                </tr>
                                <tr>
                                    <td class="variant_list">
                                        <ol style="padding-left: 10px;">

                                            <?
                                            if ($this->item->getProductVariants()) {
                                                $variants = $this->item->getProductVariants();
                                                /* @var $variant \NeoMvc\Models\Entity\ProductVariant */
                                                foreach ($variants as $variant) {
                                                    $attributes = $variant->getAttributes();
                                                    ?>
                                                    <li id="variant_<?= $variant->getId_variant() ?>">
                                                        <table width = "500" border = "0" class = "attributesTable">
                                                            <tr>
                                                                <td colspan = "3" class = "variantTdHeader" width = "80">
                                                                    <div class = "variantHeader" > Varianta  <? if (!$variant->getActive()) echo "Inactiva" ?> </div>
                                                                    <div class = "removeVariant" onclick = "removeVariant(<?= $variant->getId_variant() ?>,<?
                                            if ($variant->getActive())
                                                echo "'inactive'";
                                            else
                                                echo "'active'"
                                                        ?>)"> <?
                                                                         if (!$variant->getActive())
                                                                             echo "Activeaza";
                                                                         else
                                                                             echo "Sterge"
                                                                             ?> Varianta </div>
                                                                    <a href = "<?= URL ?>admin/product/loadProductAttributes/<?= $variant->getId_variant() ?>"
                                                                       class = "addAttributes fancybox.iframe"> Adauga Atribute 
                                                                    </a>
                                                                    <input type="hidden" name="id_variant[]" value="<?= $variant->getId_variant() ?>"/>
                                                                </td>
                                                            </tr>
                                                            <? foreach ($attributes as $attribute) { ?>
                                                                <tr id="id_attribute_<?= $attribute->getId() ?>">
                                                                    <td width="90">
                                                                        <label><?= $attribute->getAttribute()->getName() ?></label>
                                                                    </td>
                                                                    <td class="input">
                                                                        <input type="hidden" name="id_attribute[]" value="<?= $attribute->getId_attribute() ?>"/>
                                                                        <input type="hidden" name="id_attribute_value[]" value="<?= $attribute->getId() ?>"/>
                                                                        <input type="text" name="attribute_value[]" value="<?= $attribute->getValue() ?>"/>
                                                                    </td>
                                                                    <td>

                                                                    </td>
                                                                </tr>
                                                            <? } ?>
                                                        </table>
                                                    </li>
                                                    <?
                                                } //end foreach
                                            } //end if
                                            ?>

                                        </ol>
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
                                <?
                                $photos = $this->item->getImages();
                                foreach ($photos as $photo) {
                                    ?>
                                    <tr id="<?= $photo->getId_image() ?>">
                                        <td width="400">
                                            <img height="150" src="<?= $photo->getImage() ?>"/>
                                        </td>
                                        <td style="vertical-align: top">
                                            <input id="princ_<?= $photo->getId_image() ?>" type="radio" <? if ($photo->getPrimary()) echo "checked"; ?> name="primary_image" value="<?= $photo->getId_image() ?>"/>  <label for="princ_<?= $photo->getId_image() ?>">Poza Principala</label> 
                                            <a class="delete_photo" href="javascript:delete_image(<?= $photo->getId_image() ?>)">Sterge</a>
                                        </td>
                                    </tr>
                                <? } ?>
                            </table>

                        </div>

                    </div>
                </form>
                <!-- end content -->
            </td>
        </tr>
    </table>


    <div id="alege_categorie" style="width: 600px;">
        <h1>Alege din ce categorii face parte acest produs (Categoria finala)</h1>
        <? print_r($this->tree); ?>
    </div>

</div>


<script>
<?
if ($this->item->getCategory())
    $allSpecs = $this->item->getCategory()->getSpecifications();

if ($allSpecs)
    foreach ($allSpecs as $spec) {
        ?>
                                    $('.<?= $spec->getId_specification() ?>').neoSelectInput({id_filter: "<?= $spec->getId_specification() ?>", url: "http://www.oringo.ro/admin/product/getSpecsValues"});
    <? } ?>

                            $(function() {
                                $("#tabs").tabs();
                                $("#tabsInner").tabs();

                                load_produs_editor();
                                $("input[type=submit]").button();
                                $("input[type=button]").button();
                                $(".jqueryButton").button();
                                $('.fancybox').fancybox({
                                    'transitionIn': 'fade',
                                    'height': 100,
                                    afterShow: function() {
                                        $(".fancybox-inner").css({'overflow-x': 'hidden'});
                                    },
                                    beforeClose: function() {
                                        load_filters();
                                    }
                                });

                                $(".addAttributes").fancybox({width: 530, height: 350, autoResize: false, autoSize: false, openEffect: 'none', closeEffect: 'none'});
                            });

</script>