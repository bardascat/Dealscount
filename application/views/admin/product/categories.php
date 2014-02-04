<script>
    $(function() {
        $("#tabs").tabs();
        $("#tabs_add").tabs();
        $("input[type=submit]").button();
    });
</script>

<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index' style="background-color: #FFF;   border:1px solid #f0f0f0;">

                <!-- content -->
                <div class="inner_content">

                    <a id="add_category_trigger" href="#add_category" class="fancybox"></a>
                    <a  id="update_category_trigger" href="#update_category" class="update_category_trigger"></a>

                    <div id="add_main_category"
                         onclick="add_category(0)">Adauga categorie principala
                    </div>  
                    <div id="category_tree">
                        <? echo $this->CategoriesAdminMenu; ?>  
                    </div>
                    <div id="clear"></div>


                    <div id="add_category" >  
                        <form method="post" id="add_category_form"
                              action="<? echo URL ?>admin/categories/add_category" enctype="multipart/form-data">   
                            <input type="hidden" class="parent_id" name="id_parent"/>     
                            <input type="hidden" value="product" name="item_type"/>     
                            <table>
                                <tr>
                                    <td> <label>Nume</label>    </td>
                                    <td><input class="name" type="text" name="category_name"/> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Thumbnail(Optional)</label>  
                                    </td>
                                    <td>
                                        <input type="file" name="thumb[]"/>     
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Cover(Optional)</label>  
                                    </td>
                                    <td>
                                        <input type="file" name="cover[]"/>     
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Imagine Menu(Optional)</label>  
                                    </td>
                                    <td>
                                        <input type="file" name="menuImage[]"/>     
                                    </td>
                                </tr>
                                <tr>
                                    <td>Layout</td>
                                    <td>
                                        <select name="layout">
                                            <option value="list">Lista</option>
                                            <option value="thumb">Thumbnails</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Categorie Agregat</label>    
                                    </td>
                                    <td>
                                        <input style="width: auto" type="checkbox" name="aggregate"/>  
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" width="750" class="filters_table">
                                        <div id="tabs_add">
                                            <ul>
                                                <li><a href="#tabs2_add">Specificatii</a></li>
                                            </ul>

                                            <div id="tabs2_add">
                                                <table border="0" width="100%">
                                                    <tr>
                                                        <td><a href="javascript:addSpecCategory(0)"><span style="color: #006dcc">Adauga</a> o categorie de specificatii</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="variant_list">
                                                            <ol style="padding-left: 10px;">

                                                            </ol>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <div onclick="submit_add_category()" id="submitBtn">Adauga</div> 
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>

                    <div id="remove_category"> 

                        <form method="post" action="<? echo URL ?>admin/categories/deleteCategory">  
                            <input class="id_category" name="id_category" type="hidden"/> 
                        </form>
                    </div>

                    <div id="update_category">  
                        <form method="post" action="<? echo URL ?>admin/categories/updateCategory" enctype="multipart/form-data">  
                            <input type="hidden" class="parent_id" name="id_parent"/>   
                            <input type="hidden" class="category_id" name="id_category"/>  
                            <input type="hidden" name="item_type" value="product"/>  
                            <table width="100%">
                                <tr>
                                    <td>
                                        <label>Nume Categorie</label>      
                                    </td>
                                    <td  >
                                        <input class="name" type="text" name="category_name"/> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Poza(Optional)</label>    
                                    </td>
                                    <td >
                                        <input type="file" name="thumb[]"/>  
                                        <span class="update_thumb"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Cover(Optional)</label>    
                                    </td>
                                    <td >
                                        <input type="file" name="cover[]"/>  
                                        <span class="update_cover"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Imagine Menu(O)</label>    
                                    </td>
                                    <td >
                                        <input type="file" name="menuImage[]"/>  
                                        <span class="menuImage"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Layout</td>
                                    <td>
                                        <select name="layout">
                                            <option value="list">Lista</option>
                                            <option value="thumb">Thumbnails</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Categorie Agregat</label>    
                                    </td>
                                    <td>
                                        <input style="width: auto" type="checkbox" name="aggregate"/>  
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" width="750" class="filters_table">
                                        <div id="tabs">
                                            <ul>
                                                <li><a href="#tabs2">Specificatii</a></li>
                                            </ul>
                                            <div id="tabs2">
                                                <table border="0" width="100%">
                                                    <tr>
                                                        <td><a href="javascript:addSpecCategory(1)"><span style="color: #006dcc">Adauga</a> o categorie de specificatii</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="variant_list">
                                                            <ol style="padding-left: 10px;">

                                                            </ol>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <div onclick="submit_update_category()" id="submitBtn">Save</div>    
                                    </td>
                                </tr>

                            </table>
                        </form>

                    </div>
                </div>
                <!-- end content -->
            </td>
        </tr>
    </table>

</div>