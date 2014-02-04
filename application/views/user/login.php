<div class="content general_page">
    <div class="info_bar">
        <div class="breadcrumbs" style="clear: both;">
            Logheaza-te in cont
        </div>
    </div>

    
    <form action='<?= base_url('account/login_submit') ?>' method='POST' id="form">
        <table border="0" id="login_table">
            <tr>
                <td colspan="2">
                    <?php if(isset($notification)) echo $this->view->show_message($notification)?>
                </td>
            </tr>
            <tr>
                <td><label>Utilizator</label></td>
                <td> 
                    <input value="<?php echo set_value('username'); ?>" type='text'name='username' id='user_box'>
                </td>
            </tr>
            <tr>
                <td><label>Parola </label></td>
                <td>  <input type='password' class='tbTextbox' name='password'>

                </td>
            </tr>

            <tr>
                <td colspan="2"> <div onclick="$('#form').submit()" class="regular_button">Login</div></td>

            </tr>
            <tr>
                <td colspan="2"><a href='<?= base_url('acccount/forgot') ?>' style='float: left; text-decoration: none; color: rgb(0, 0, 0); font-size: 12px;'>Am uitat parola</a><br /></td>

            </tr>

        </table>

    </form>

</div>
