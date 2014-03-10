<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>
<div id="content">

    <div class="partner">

        <?php $this->load->view('partner/partner_menu'); ?>

        <div class="newsletters">
            <form method="POST" action="<?php echo base_url('partener/change_date_cont') ?>" enctype="multipart/form-data">
                <input type="hidden" name="role" value="<?php echo DLConstants::$USER_ROLE ?>"/>
                <input type="hidden" name="id_user" value="<?php echo $user->getId_user(); ?>"/>
                <table>
                    <tr>
                        <td colspan="2">
                            <?php if (isset($notification)) echo $this->view->show_message($notification) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nume firma/PFA:</label>
                        </td>
                        <td>
                            <input type="text" name="company_name" value="<?php echo $user->getCompanyDetails()->getCompany_name() ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Cod fiscal:</label>
                        </td>
                        <td>
                            <input type="text" name="cif" value="<?php echo $user->getCompanyDetails()->getCif(); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Registrul comertului:</label>
                        </td>
                        <td>
                            <input type="text" name="regCom" value="<?php echo $user->getCompanyDetails()->getRegCom(); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Adresa:</label>
                        </td>
                        <td>
                            <input type="text" name="address" value="<?php echo $user->getAddress(); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Telefon:</label>
                        </td>
                        <td>
                            <input type="text" name="phone" value="<?php echo $user->getPhone(); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Mail:</label>
                        </td>
                        <td>
                            <input type="text" name="email" value="<?php echo $user->getEmail() ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Banca:</label>
                        </td>
                        <td>
                            <input type="text" name="bank" value="<?php echo $user->getCompanyDetails()->getBank(); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>IBAN:</label>
                        </td>
                        <td>
                            <input type="text" name="iban" value="<?php echo $user->getCompanyDetails()->getIban() ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class='label'>
                            <label>Nume pers. contact</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo $user->getLastname() ?>" name='lastname'/>
                        </td>
                    </tr>
                    <tr>
                        <td class='label'>
                            <label>Prenume pers. contact</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo $user->getFirstname(); ?>" name='firstname'/>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;" colspan="2">
                            <input id="greenButton" type="submit" value="Salveaza"/>
                        </td>
                    </tr>
                </table>
            </form>
            <script>
                $(function() {
                    load_partner_editor();
                });
            </script>
            <h3>Date contact prentru pagina ofertei</h3>
            <form method="POST" action="<?php echo base_url('partener/change_date_cont_company') ?>" enctype="multipart/form-data">
                <input type="hidden" name="id_user" value="<?= $user->getId_user() ?>">
                <table  border='0' width='100%' id='add_table' style="margin-top: 15px;">
                    <tr>
                        <td class='label'>
                            <label>Logo Companie</label>
                        </td>
                        <td class='input' >
                            <input type='file' name='image[]'/>
                        </td>
                    </tr>

                    <tr>
                        <td class='label'>
                            <label>Nume Comercial(*)</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo $user->getCompanyDetails()->getCommercial_name(); ?>" name='commercial_name'/>
                        </td>
                    </tr>

                    <tr>
                        <td class='label'>
                            <label>Descriere</label>
                        </td>
                        <td class='input' >
                            <textarea id="description" name="description"><?php echo $user->getCompanyDetails()->getDescription(); ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td class='label'>
                            <label>Telefon</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo $user->getCompanyDetails()->getPhone() ?>" name='phone'/>
                        </td>
                    </tr>
                    <tr>
                        <td class='label'>
                            <label>Site</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo $user->getCompanyDetails()->getWebsite(); ?>" name='website'/>
                        </td>
                    </tr>

                    <tr>
                        <td class='label'>
                            <label>Adresa</label>
                        </td>
                        <td class='input' >
                            <input type='text' value="<?php echo $user->getCompanyDetails()->getAddress(); ?>" name='address'/>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;" colspan="2">
                            <input id="greenButton" type="submit" value="Salveaza"/>
                        </td>
                    </tr>
                </table>
            </form>

            <div class="separator"></div>
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