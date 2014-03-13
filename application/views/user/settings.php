<?php
/* @var $user Dealscount\Models\Entities\User */ $user
?>

<div id="content">

    <div class="account">
        <div class="breadcrumbs">
            <h1>Date cont</h1>
        </div>
        <?php $this->load->view('user/user_menu'); ?>

        <div class="username">Ciau <?php echo ($user->getFirstname() ? $user->getFirstname() . ' ' . $user->getLastname() : $user->getLastname()) ?></div>

        <div class="change_settings">
            <form method="post" action="<?php echo base_url('account/change_settings') ?>">
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
                            <label>Nume:</label>
                        </td>
                        <td>
                            <input type="text" name="lastname" value="<?php echo set_value('lastname') ?>"/>
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
                            <label>Email:</label>
                        </td>
                        <td>
                            <input type="text" name="email" value="<?php echo set_value('email') ?>"/>
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
                            <label>Oras:</label>
                        </td>
                        <td>
                            <select style="width:208px;" name="city">
                                <?php foreach ($cities as $city) { ?>
                                    <option value="<?php echo $city->getDistrict() ?>"><?php echo $city->getDistrict() ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Varsta:</label>
                        </td>
                        <td>
                            <select style="width: 207px;" name="age">
                                <option value="18-25">18-25</option>
                                <option value="25-30">25-30</option>
                                <option value="30-40">30-40</option>
                                <option value=">40">>40</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Sex:</label>
                        </td>
                        <td>
                            <select style="width:208px;" name="gender">
                                <option value="M">Masculin</option>
                                <option value="F">Feminin</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 20px;" colspan="2">
                            <input id="greenButton" type="submit" value="Salveaza"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div id="change_password" class="change_settings" style="margin-top:30px;">
            <form method="post" action="<?php echo base_url('account/change_password') ?>">
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
    <div id="clear"></div>
</div>
