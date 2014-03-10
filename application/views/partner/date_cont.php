<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="newsletters">
            <form method="POST" action="<?php echo base_url('partener/change_date_cont') ?>" enctype="multipart/form-data">
                <input type="hidden" name="role" value="<?php echo DLConstants::$USER_ROLE ?>"/>
                <input type="hidden" name="id_user"/>
                <table>
                    <tr>
                        <td colspan="2">
                            <?php if (isset($notification)) echo $this->view->show_message($notification) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Logo Companie</label>
                        </td>
                        <td class='input' >
                            <input type='file' name='image[]'/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nume firma/PFA:</label>
                        </td>
                        <td>
                            <input type="text" name="company_name" value="<?php echo set_value('company_name') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Cod fiscal:</label>
                        </td>
                        <td>
                            <input type="text" name="cif" value="<?php echo set_value('cif') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Registrul comertului:</label>
                        </td>
                        <td>
                            <input type="text" name="regCom" value="<?php echo set_value('regCom') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Adresa:</label>
                        </td>
                        <td>
                            <input type="text" name="address" value="<?php echo set_value('address') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Telefon:</label>
                        </td>
                        <td>
                            <input type="text" name="phone" value="<?php echo set_value('phone') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mail:</label>
                        </td>
                        <td>
                            <input type="text" name="email" value="<?php echo set_value('email') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Banca:</label>
                        </td>
                        <td>
                            <input type="text" name="bank" value="<?php echo set_value('bank') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>IBAN:</label>
                        </td>
                        <td>
                            <input type="text" name="iban" value="<?php echo set_value('iban') ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class='label'>
                            <label>Nume pers. contact</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo set_value('nume') ?>" name='lastname'/>
                        </td>
                    </tr>
                    <tr>
                        <td class='label'>
                            <label>Prenume pers. contact</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo set_value('prenume') ?>" name='firstname'/>
                        </td>
                    </tr>
                    <td style="padding-top: 20px;" colspan="2">
                        <input id="greenButton" type="submit" value="Salveaza"/>
                    </td>
                    </tr>
                </table>
            </form>

            <div id="change_password" class="change_settings" style="margin-top:30px;">
                <form method="post" action="<?php echo base_url('partener/partener_change_password') ?>">
                    <input type="hidden" name="role" value="<?php echo DLConstants::$USER_ROLE ?>"/>
                    <input type="hidden" name="id_user"/>
                    <table>
                        <tr>
                            <td colspan="2" style="padding-bottom: 0px;">
                                <b>Schimba parola</b>
                            </td>
                        </tr>
                        <?php if (isset($notification_password)) { ?>
                            <tr>
                                <td colspan="2">
                                    <?php echo $this->view->show_message($notification_password) ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="padding-top: 25px;">
                                <label>Parola Veche:</label>
                            </td>
                            <td style="padding-top: 25px;">
                                <input type="password" name="old_password"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Parola Noua:</label>
                            </td>
                            <td>
                                <input type="password" name="new_password"/>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-top: 20px;" colspan="2">
                                <input id="greenButton" type="submit" value="Schimba"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>


        </div>


    </div>
    <div id="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datetimepicker({timeFormat: 'HH:mm', dateFormat: "dd-mm-yy"});
    })
</script>