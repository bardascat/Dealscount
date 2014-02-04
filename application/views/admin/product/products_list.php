<script type="text/javascript">
    $(document).ready(function() {
        $('.list_buttons').buttonset();
    });
</script>
<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index product_list'>
                <!-- content -->

                <div class="paginator">
                    <form method="get" action="?" class="paginateForm">
                        Pagina: <input style="width: 20px; text-align: center; padding: 2px; font-size: 15px;" type="text" name="page" value="<? if (isset($_GET['page'])) echo $_GET['page'] ?>"/>
                        din  <?= $this->totalPages ?>
                        <input type="hidden" name="filter" value="<?if(isset($_GET['filter'])) echo $_GET['filter']?>"/>
                    </form>

                    <div class="searchForm" style="float: left;">
                        <form method="get" action="<?= URL ?>admin/product/searchProducts">
                            <input type="text" value="<? if (isset($_GET['search'])) echo $_GET['search'] ?>" name="search" placeholder="Cauta dupa nume produs sau cod furnizor"/>
                        </form>
                    </div>

                    <div class="filters" style="float: right; width: 200px;">
                        <table style="float: right;">
                            <tr>
                                <td style="padding-top: 3px;">
                                    <label>Selectie: </label>
                                </td>
                                <td>

                                    <form id="filter_form" method="get" action="<?=URL?>admin/product/products_list">
                                        <select name="filter" style="width: 100px;" onchange="$('#filter_form').submit()">
                                            <option>nimic</option>
                                            <option <?if(isset($_GET['filter']) && $_GET['filter']=="blackfriday") echo "selected";?> value="blackfriday">Blackfriday</option>
                                            <option <?if(isset($_GET['filter']) && $_GET['filter']=="christmas") echo "selected";?> value="christmas">Craciun</option>
                                            <option <?if(isset($_GET['filter']) && $_GET['filter']=="ascuns") echo "selected";?> value="ascuns">Ascuns</option>
                                            <option <?if(isset($_GET['filter']) && $_GET['filter']=="noi") echo "selected";?> value="noi">Noi</option>
                                            <option <?if(isset($_GET['filter']) && $_GET['filter']=="recommended") echo "selected";?> value="recommended">Recomandat</option>
                                            <option <?if(isset($_GET['filter']) && $_GET['filter']=="discount") echo "selected";?> value="discount">Reducere</option>
                                            
                                        </select>
                                        
                                    </form>

                                </td>
                            </tr>
                        </table>


                    </div>

                </div>
                <table width="100%" border="0" id="list_table" cellpadding="0" cellspcing="0">
                    <tr>
                        <th width="100" class="cell_left">
                            Id 
                        </th>
                        <th>
                            Nume
                        </th>
                        <th style="padding-left: 20px;">
                            Partener
                        </th>
                        <th >
                            Pret
                        </th>
                        <th >
                            Data
                        </th>
                        <th>
                            Ascuns
                        </th>
                        <th>
                            Recomandat
                        </th>
                        <th>
                            Nou
                        </th>
                        <th>
                            Craciun
                        </th>
                        <th class="cell_right">

                        </th>

                    </tr>
                    <?
                    foreach ($this->products as $product) {
                        $productDetails = $product->getProduct();
                        $furnizor = $product->getCompany();
                        if (!$furnizor)
                            $company = null;
                        else
                            $company = $furnizor->getCompanyDetails();
                        if (!$productDetails) {
                            exit("<b>EROARE: Item-ul " . $product->getId_item() . ' nu are niciun produs/oferta asociata</b>');
                        }
                        ?>
                        <tr>
                            <td width="5%"><a href="<?= URL ?>admin/product/edit_product/<?= $product->getId_item() ?>"><?= $product->getId_item() ?></a></td>
                            <td width="25%"><?= $product->getName() ?></td>
                            <td style="padding-left: 20px;" width="20%"><?
                                if (!$company)
                                    echo "Nu are furnizor";
                                else
                                    echo $company->getCompany_name()
                                    ?></td>

                            <td width="8%"><?= $productDetails->getPrice() ?> ron</td>
                            <td wdith="8%"><?= $product->getCreatedDate() ?></td>
                            <td width="5%">
                                <input onclick="hideItem(<?= $product->getId_item() ?>)" style="padding-left: 15px;" type="checkbox" <? if (!$product->getActive()) echo "checked='checked'" ?> value="<?= $product->getId_item() ?>" name="hide"/>
                            </td>
                            <td width="5%">
                                <input onclick="setRecommended(<?= $product->getId_item() ?>)" style="padding-left: 15px;" type="checkbox" <? if ($product->getRecommended()) echo "checked='checked'" ?> value="<?= $product->getId_item() ?>" name="recommended"/>
                            </td>
                            <td width="5%">
                                <input onclick="excludeNew(<?= $product->getId_item() ?>)" style="padding-left: 15px;" type="checkbox" <? if ($product->getInclude_new_slider()) echo "checked='checked'" ?> value="<?= $product->getId_item() ?>" name="exclude_new"/>
                            </td>
                            <td width="5%" style="display: none">
                                <input onclick="setBF(<?= $product->getId_item() ?>)" style="padding-left: 15px;" type="checkbox" <? if ($product->getBlackfriday()) echo "checked='checked'" ?> value="<?= $product->getId_item() ?>" name="blackfriday"/>
                            </td>
                            <td width="5%" >
                                <input onclick="setChristmas(<?= $product->getId_item() ?>)" style="padding-left: 15px;" type="checkbox" <? if ($product->getChristmas()) echo "checked='checked'" ?> value="<?= $product->getId_item() ?>" name="christmas"/>
                            </td>
                            <td width="15%" class="list_buttons cell_right">
                                <a href="<?= URL ?>admin/product/edit_product/<?= $product->getId_item() ?>">Editeaza</a>

                                <a  href="javascript:triggerDeleteConfirm('.delete_<?= $product->getId_item() ?>',1)">Sterge</a>

                                <a style='display: none;' class="delete_<?= $product->getId_item() ?>" href="<?= URL ?>admin/product/delete_product/<?= $product->getId_item() ?>">Sterge</a>
                            </td>
                        </tr>
                    <? } ?>
                </table

                <!-- end content -->
            </td>
        </tr>
    </table>

</div>
