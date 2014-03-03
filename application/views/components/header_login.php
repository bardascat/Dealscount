<div id="header_login">
    <div class = "pointing_arrow"></div>
    <div class="inner">
        <h2>Login</h2>
        <form method="post" action="<?php echo base_url('account/login_submit') ?>">
            <input type="hidden" name="role" value="<?php echo DLConstants::$USER_ROLE ?>"/>
            <input type='submit' value='' style='border:0px; background: transparent; width: 0px; height: 0px;'/>
            <table class="login_table" width="100%">
                <tr>
                    <td style="padding-bottom: 5px;" colspan="2">
                        <input type="text" name="username" placeholder="Email"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="password" name="password" placeholder="Parola"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a class="fb_login" href=""></a>
                        <a class="login_btn" href="javascript:login_header()"></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 6px;">
                        <a style=" color: #161616; font-size: 13px;" href="<?php echo base_url('account/forgot_password') ?>">Ai uitat parola?</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 3px;" colspan="2">
                        <img src="<?php echo base_url('assets/images_fdd/fab_or_bar.png') ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a class="new_account" href="<?php echo base_url('account/register') ?>"></a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
