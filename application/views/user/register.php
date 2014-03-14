<div id="content">
    <div class="register">
        <div class="breadcrumbs">
            <h1 style="height: 30px;">
            
                <div style="float: left"><?php echo ($form_type=="client_form" ? "Cont nou client" : "Cont nou partener")?></div>
                <div style="float: right; margin-top: 5px;">
                    <a style="color: #2d8bff; font-size: 19px;" href="<?php echo base_url('account/register'.($form_type=="client_form" ? "/company" :false)) ?>"><?php echo ($form_type=="client_form" ? "Cont nou partener":"Cont nou client")?></a>
                </div>
            </h1>
            <div id="clear"></div>
        </div>

        <?php
        $this->load->view($form);
        ?>
    </div>
    <div id="clear"></div>
</div>