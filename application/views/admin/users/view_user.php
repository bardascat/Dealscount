<script>
    $(function() {
        $("#tabs").tabs();

        $("input[type=submit]").button();
    });
</script>

<div id="admin_content">

    <table id='main_table' border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>

            <? require_once('views/admin/left_menu.php'); ?> 

            <td class='content index'>
                <!-- content -->

                <form method="post" action="<?= URL ?>admin/users/editUser"  enctype="multipart/form-data">
                    <input type="hidden" name="id_user" value="<?= $this->user->getId_user() ?>"/>
                    <div id="submit_btn_right">
                     
                    </div>
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Detalii Utilizator</a></li>
                            <li><a href="#tabs-2">Detalii Adrese</a></li>
                        </ul>
                        <div id="tabs-1">

                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <td class='label'>
                                        <label>Nume </label>
                                    </td>
                                    <td class='input' >
                                        <input type='text' name='nume'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Prenume</label>
                                    </td>
                                    <td class='input' >
                                        <input type='text' name='prenume'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Email(*)</label>
                                    </td>
                                    <td class='input' >
                                        <input type='text' name='email'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Parola(*)</label>
                                    </td>
                                    <td class='input' >
                                        <input type='text' name='real_password'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Telefon</label>
                                    </td>
                                    <td class='input' >
                                        <input type='text' name='phone'/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label'>
                                        <label>Dată creare</label>
                                    </td>
                                    <td class='input' >
                                        <input disabled="" type='text' name='created_date'/>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div id="tabs-2">
                            <table  border='0' width='100%' id='add_table'>
                                <tr>
                                    <? $shippingAddresses = $this->user->getShippingAddresses() ?>
                                    <td class='label'>
                                        <h3>Adrese de livrare</h3>
                                        <?
                                        foreach ($shippingAddresses as $address): ?>
                                        
                                        <div style="margin-top: 50px;">
                                            <?=$address->getFullAddress().', Judet: '.$address->getShipping_district().'<br/> Telefon:'.$address->getShipping_phone().'<br/> CNP:'.$address->getShipping_cnp()?>
                                        </div>
                                            
                                        <? endforeach; ?>
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

</div>