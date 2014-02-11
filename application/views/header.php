<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="Romanian" />
        <meta http-equiv="Content-Language" content="ro" />
        <?php echo $this->view->getCss(); ?>
        <link href='http://fonts.googleapis.com/css?family=Oxygen&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <?php echo $this->view->getJs(); ?>
            <meta name="description" content=""/>
            <link rel="shortcut icon"  type="image/png"  href="<?php echo base_url() ?>assets/images_fdd/favicon.ico">
                </head>
                <body>
                    <div id="wrapper">

                        <div id="left_side">

                            <div class="logo">
                                <a  onmouseover="close_subcats()" href="<?php echo base_url() ?>">
                                    <img src="<?php echo base_url() . '/assets' ?>/images_fdd/getadeal_logo.png" width="170" height="40"/>
                                </a>
                            </div>
                            <div class="left_side_inner_content">
                                <ul class="categorii">
                                    <?php
                                    foreach ($this->view->getCategories() as $category) {
                                        $parent = $category['parent'];
                                        ?>
                                        <li class = "main_<?php echo $parent['id_category'] ?>" class = "cat_selected">
                                            <a onmouseover = "show_subcats(<?php echo $parent['id_category'] ?>)" style = "width:100%;" href = "<?php echo base_url('categorii/' . $parent['slug']) ?>"><?php echo $parent['name'] ?></a>
                                        </li>

                                        <ul id="<?php echo $parent['id_category'] ?>" class="subcats">
                                            <div class="arrow"></div>
                                            <?php foreach ($category['childs'] as $category) { ?>
                                                <li><a style="display: block; width:100%;" href="<?php echo base_url('categorii/' . $parent['slug'] . '/' . $category['category_slug']) ?>"><?php echo $category['category_name'] ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </ul>
                                <table border="0" class="promo">
                                    <tr>
                                        <td>
                                            <a href="cumperisicastigi.php">
                                                <img src="<?php echo base_url() . '/assets' ?>/images_fdd/cumperi&castigi.png" width="67" height="66"/>
                                            </a>
                                        </td>
                                        <td style="">
                                            <span>Ultimul castigator</span>
                                            <span style="font-size:12px;">Bardas Catalin</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="banii_inapoi.php">
                                                <img src="<?php echo base_url() . '/assets' ?>/images_fdd/punctegad.png" width="67" height="66"/>
                                            </a>
                                        </td>
                                        <td style="">
                                            Cumperi produse si<br/>
                                            primesti bani inapoi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:0px;">
                                            <a href="happyhour.php">
                                                <img src="<?php echo base_url() . '/assets' ?>/images_fdd/happyhour.png" width="67" height="66"/>
                                            </a>
                                        </td>
                                        <td style="border:0px;">
                                            Reduceri la reduceri<br/>
                                            Intra zilnic pe site<br/>
                                            ca sa nu le ratezi!
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="clienti">
                                <div style="color: #00a9e9">Asistenta clienti</div>
                                <div>021.230.50.30</div>
                                <div>info@getadeal.ro</div>
                                <div>Lu - Vi: 0900-1800</div>
                            </div>

                            <div class="form_comanda_btn">
                                <a href="form_comanda.php?offerId=home">
                                    <img src="<?php echo base_url() . '/assets' ?>/images_fdd/form_comanda.png"/>
                                </a>
                            </div>

                        </div>


                        <div id="right_side">

                            <div class="header">

                                <div class="search_bar">
                                    <form method="post" action="index.php?">
                                        <input type="text" name="query" class="query_field" value="Cauta" 
                                                           onfocus="if (this.value == 'Cauta') {                                             this.value = '';
                                                                   }" onblur="if (this.value == '') {                                             this.value = 'Cauta';
                                                               }" />
                                        <input type="hidden" name="search" value="true" />
                                        <input type="submit" value="" class="search_submit" />
                                    </form>
                                </div>

                                <ul class="meniu">
                                    <a href="">
                                        <li class="oferte">
                                            <div class="icon"></div>
                                            <span>Oferte</span>
                                        </li>
                                    </a>

                                    <a href="">
                                        <li class="shop">
                                            <div class="icon"></div>
                                            <span>Produse</span>
                                        </li>
                                    </a>

                                    <li class="contul_meu">
                                        <?php
                                        $user = $this->view->getUser();
                                        ?>
                                        <a
                                            style="display:block; display:block; margin:0px; padding:0px; width:80px;"
                                            href="javascript:login">
                                            <div class="icon"style="<?php if (isset($user['gender'])) { ?>background-image:url('<?php echo base_url() . '/assets' ?>/images_fdd/<?php echo (strtoupper($user['gender'] == "F") ? "lady.png" : "sir.png") ?>'); <?php
                                                if (strtoupper($user['gender'] == "F"))
                                                    echo "width: 23px";
                                                else
                                                    echo "margin-top:8px; height:29px";
                                            }
                                            ?>">
                                            </div>
                                        </a>

                                        <?php if ($this->view->getUser()) { ?>
                                            <a href="javascript:contul_meu()">Contul meu</a>
                                            <div class="contul_meu_container">
                                                <a style="padding-right:0px;" href="<?= base_url('account/orders') ?>">Voucherele mele</a>
                                                <a style="padding-right:0px;" href="<?= base_url('account') ?>">Contul meu</a>
                                                <a style="padding-right:0px;" href='<?= base_url('admin') ?>'>Admin</a>
                                                <a style="padding-right:0px;" href="<?= base_url('account/logout') ?>">Logout</a>
                                            </div>
                                        <?php } else { ?>
                                            <a href="javascript:login()">Contul meu</a>
                                        <?php } ?>

                                        <div id="login_form">
                                            <form method="post" action="<?= base_url('account/login_submit') ?>">
                                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>Login</td>
                                                        <td align="right">
                                                            <img src="<?php echo base_url() . '/assets' ?>/images_fdd/icon_om.png"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="text"  placeholder="utilizator" name="username"/>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="password" placeholder="password" name="password"/>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="register.php" style="padding: 0px; margin: 0px;display:block; width:74px; float: left; *margin-top:3px;">
                                                                <img src="<?php echo base_url() . '/assets' ?>/images_fdd/cont_nou.png"/>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <input type="submit" value="" style="width: 0px; height: 0px; visibility:hidden; position: absolute;"/>
                                                            <div  type="submit" onclick="$('#login_form form').submit()"
                                                                  class="login_btn">
                                                                <img src="<?php echo base_url() . '/assets' ?>/images_fdd/login.png"/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><a style="padding: 0px; margin: 0px; width:auto; float:none; color:#FFF;display:inline;" 
                                                                           href="<?php echo base_url('account/forgot') ?>">Am uitat parola</a></td>

                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
