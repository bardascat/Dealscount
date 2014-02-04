<script>
    $(function() {
        $(".submitBtn").button();
    });
</script>

<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content homePage' style="background-color: #FFF;   border:1px solid #f0f0f0;">

                <!-- content -->
                <div class="inner_content" >

                    <form method="post" action="<?= URL ?>admin/pages/addHomeSlide" enctype="multipart/form-data" id="addFormSlide">
                        <table border="0" class="addHomeSlide" >
                            <tr>
                                <td>
                                    Nume
                                </td>
                                <td class="spaceRight" >
                                    <input type="text" name="name"/>
                                </td>
                                <td>
                                    URL
                                </td>
                                <td class="spaceLeft" >
                                    <input type="text" name="url"/>
                                </td>

                                <td class="spaceLeft" >
                                    Alege Poză
                                </td>
                                <td class="spaceRight">
                                    <input type="file" name="image"/>
                                </td>
                                <td  colspan="2" class="spaceLeft">
                                    <div onclick="$('#addFormSlide').submit()" class="submitBtn">Incarca</div>
                                </td>
                            </tr>
                        </table>
                    </form>


                    <div class="homeSlides">
                        <? foreach ($this->homeSlides as $homeSlide) { ?>
                            <div class="homeSlide">
                                <div class="img" style="float: left;">
                                    <img width="200" src="<?= URL . $homeSlide->getImage() ?>"/>
                                </div>
                                <form id="slide_form_<?=$homeSlide->getId_slide()?>" style="float: left;" enctype="multipart/form-data" method="post" action="<?=URL?>admin/pages/updateHomeSlide">
                                    <input type="hidden" name="id_slide" value="<?= $homeSlide->getId_slide() ?>"/>
                                    <div class="name"><input type="text" name="name" placeholder="Nume" value="<?= $homeSlide->getName() ?>"/></div>
                                    <div class="url"><input type="text" placeholder="URL" name="url" value="<?= $homeSlide->getUrl() ?>"/></div>
                                    <input style="width: 120px;" type="file" name="image"/>
                                    <div class="submitBtn" onclick="$('#slide_form_<?=$homeSlide->getId_slide()?>').submit()">Salveaza</div>
                                    <div class="submitBtn"><a href="<?= URL ?>admin/pages/deleteSlide/<?= $homeSlide->getId_slide() ?>">Sterge</a></div>
                                </form>
                            </div>
                        <? } ?>
                    </div>

                </div>
                <!-- end content -->
            </td>
        </tr>
    </table>

</div>