<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="language" content="Romanian" />

        <meta http-equiv="Content-Language" content="ro" />
        <?php echo $this->view->getCss();?>
        <?php echo $this->view->getJs();?>

        <meta name="description" content=""/>

        <link rel="shortcut icon"  type="image/png"  href="<? echo URL ?>layout/favicon.ico">
    </head>

    <body>
        <?php echo  validation_errors();?>
       <?php echo form_open(base_url('account/login_submit'), array('id' => 'some_form_id')); ?>
            <input type="text" name="email" value="<?php echo set_value('email')?>" placeholder="email"/>
            <input type="password" value="<?php echo set_value('password')?>" name="password" placeholder="password"/>
            <input type="submit"/>
        </form>

