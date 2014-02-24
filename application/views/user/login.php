<div id="content">
    <div class="register">
        <div class="breadcrumbs">
            <h1>Logheaza-te in cont <span style="font-size: 13px; margin-left: 10px;">( nu ai cont ? <a style="color: #2d8bff" href="<?php echo base_url('account/register') ?>">creeaza unul</a> )</span></h1>
        </div>

        <form method="post" action="<?php echo base_url('account/login_submit') ?>">
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
                        <input type="text" name="username" value="<?php echo set_value('username') ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Parola:</label>
                    </td>
                    <td>
                        <input type="password" name="password"/>
                    </td>
                </tr>

                <tr>
                    <td  colspan="2">
                        <a style="color: #2d8bff" href="<?php echo base_url('account/forgot_password') ?>">Am uitat parola</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px;" colspan="2">
                        <input id="greenButton" type="submit" value="Login"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>