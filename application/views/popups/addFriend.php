<div id="popup">
    <div class="addFriend">
        <table width="100%" border="0">
            <tr>
                <td style="padding-right: 35px;" width="125">
                    <img src="<?= URL ?>images/trimite_cadou.png"/>
                </td>
                <td style="vertical-align: top;">
                    <form id="addFriendForm" method="post" action="<?= URL ?>cart/add_to_cart_friend">
                        <input type="hidden" name="id_item" value="<?= $this->id_item ?>"/>
                        <table class="innerTable" border="0">
                            <tr>
                                <td colspan="2">
                                    <h1>Trimite Cadou</h1>
                                    <h2>Completează datele prietenului</h2>
                                </td>
                            </tr>
                            <? if (isset($this->errors)) { ?>
                                <tr>
                                    <td colspan="2" style="color: #f00;">
                                        <?= $this->errors ?> 
                                    </td>
                                </tr>
                                <?
                            }
                            if (isset($this->nr_friends)) {
                                for ($i = 0; $i < $this->nr_friends; $i++) {
                                    ?>
                                    <tr>
                                        <td width="50"><label>Nume</label></td>
                                        <td><input value="<?= $this->post['name'][$i] ?>" type="text" name="name[]"/></td>
                                    </tr>
                                    <tr>
                                        <td><label>Email</label></td>
                                        <td><input value="<?= $this->post['email'][$i] ?>" type="text" name="email[]"/></td>
                                    </tr>
                                    <?
                                }
                            } else {
                                ?>
                                <tr>
                                    <td width="50"><label>Nume</label></td>
                                    <td><input value="<?= $this->post['name'][$i] ?>" type="text" name="name[]"/></td>
                                </tr>
                                <tr>
                                    <td><label>Email</label></td>
                                    <td><input value="<?= $this->post['email'][$i] ?>" type="text" name="email[]"/></td>
                                </tr>
                            <? } ?>

                        </table>
                    </form>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 20px;">
                    <div id="blueButton" onclick="addNewFriend()">Adauga inca un prieten</div>

                    <div onclick="$('#addFriendForm').submit()" style="margin-left: 65px; padding-left: 8px; padding-right: 8px;" id="blueButton">Ok</div>
                </td>

            </tr>
        </table>
    </div>
</div>
<script>

                        function addNewFriend() {
                            var html = '<tr><td style="padding-top:10px;" width="50"><label>Nume</label></td><td style="padding-top:10px;"><input type="text" name="name[]"/></td></tr><tr><td><label>Email</label></td><td><input type="text" name="email[]"/></td></tr>';
                            $('.innerTable').append(html);
                             var height=$('.innerTable').height()+100;
                            parent.updateFbDimension(0, height);
                            parent.jQuery.fancybox.reposition();
                        }
</script>