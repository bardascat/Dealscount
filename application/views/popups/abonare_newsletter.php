<? $success = \NeoMvc\Libs\Session::get_flash_data("success"); ?>
<div id="popup">

    <div class="newsletter">
        <? if (!$success) { ?>
            <div class="newsletter_title">
                Newsletter
            </div>

            <?
            $errors = \NeoMvc\Libs\Session::get_flash_data("errors");
            if ($errors):
                ?>
                <div class="errors">
                    <? echo $errors; ?>
                </div>
            <? endif; ?>

            <div class="info">
                Alege categoriile de oferte care te intereseaza si cu care vrei sa fii la curent
            </div>

            <div class="categorii">
                <?
                if ($this->offers_categories):
                    foreach ($this->offers_categories as $category):
                        ?>
                        <span id="select_<?= $category['id_category'] ?>" class="categorie" onclick="addCategory(<?= $category['id_category'] ?>, '<?= $category['name'] ?>')">
                            <span class="blueButton">
                                <?= $category['name'] ?>
                            </span>
                        </span>
                        <?
                    endforeach;
                endif;
                ?>
            </div>
            <div class="clearfix" style="clear: both;"></div>
            <div class="contine">
                <div class="title">Newsletter-ul tau contine</div>
            </div>

            <form method="post" id="categoriesForm" action="<?= URL ?>newsletter/add_subscribe_submit">
                <? if ($this->logged_user): ?>
                    <input type="hidden" name="id_user" value="<?= $this->logged_user['id_user'] ?>"/>
                <? endif; ?>
                <div class="categoriiAlese">         
                </div>

                <div class="setEmail">
                    <table border="0" cellpadding="0" cellspacing="0" class="emailTable">
                        <tr>
                            <td><label>Email</label></td>
                            <td><input type="text" name="email" placeholder=""/></td>
                        </tr>

                    </table>
                </div>


                <div  onclick="$('#categoriesForm').submit()"class="submitForm blueButton">Salvează</div>
            </form>
        <? } else { ?>

            <!-- Google Code for Newsletter Conversion Page -->
            <script type="text/javascript">
                    /* <![CDATA[ */
                    var google_conversion_id = 997185351;
                    var google_conversion_language = "ro";
                    var google_conversion_format = "2";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "pLwECMHhkAcQx66_2wM";
                    var google_conversion_value = 0;
                    var google_remarketing_only = false;
                    /* ]]> */
            </script>
            <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/997185351/?value=0&amp;label=pLwECMHhkAcQx66_2wM&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>

            <div class="success">
                <?= $success ?>
            </div>
        <? } ?>
    </div>
</div>

<script>

    function addCategory(id_category, categorie) {

        var htmlAdd = ' <span id="addCategory_' + id_category + '" onclick="removeCategory(' + id_category + ')" class="categorie_aleasa"><span class="blueButton">' + categorie + '</span><input type="hidden" name="categories[]" value="' + id_category + '"/></span>';
        $('.categoriiAlese').append(htmlAdd);
        $('#select_' + id_category).fadeOut(100);
    }

    function removeCategory(id_category) {
        $('#addCategory_' + id_category).remove();
        $('#select_' + id_category).fadeIn(100);
    }

</script>