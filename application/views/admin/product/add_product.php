<script>
    $(function() {
        $('#tabs').tabs();
        load_produs_editor();
        $("input[type=submit]").button();
        $("input[type=button]").button();
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

<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <!-- content -->

                <form id="addProductForm" method="post" action="<?= URL ?>admin/product/addProductDo" enctype="multipart/form-data">
                    <div class="categoriesInput">
                    </div>
                    <div id="submit_btn_right">
                        <input onclick="addProduct()" type="button" value="Salveaza" />
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
                                        <span style="padding-left: 20px;">Adauga in slideru-ul de reduceri(home)? </span><input type="checkbox"  style="width: auto;" name="include_discount_slider"  value="1"/>
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
                                            <option value="S5">
                                                Indisponibil 
                                            </option>
                                            <option value="S6">
                                                La comandă
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Categorie</label>
                                    </td>
                                    <td class='input'>
                                        <a class="fancybox" href="#alege_categorie">Alege Categorie Produs</a>
                                    </td>
                                </tr>
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

                                <?
                                //adaugam filtrele daca a fost un insert nereusit
                                $has_info = false;
                                if ($this->specs)
                                    foreach ($this->specs as $spec) {
                                        ?>
                                        <tr>
                                            <td class="label"><label><? echo $spec->getName();
                                if ($spec->getIsFilter()) echo "(<span style='color:green'>filtru</span>)"; ?></label></td>
                                            <td class="input"><input type="text" name="<?= $spec->getId_specification() ?>" value=""/></td>
                                        </tr>
                                        <?
                                    } else {
                                    ?>
                                    <tr>
                                        <td><h2>Alege intai categoria produsului pentru a adauga specificatii</h2></td>
                                    </tr>
<? } ?>

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
                                    <td style="padding-bottom: 30px;"  colspan="4"><input type="button" style="width: 150px;" onclick="addVariant()" value="Adaugă Variantă:"/> </td>
                                </tr>
                                <tr>
                                    <td class="variant_list">
                                        <ol style="padding-left: 10px;">


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