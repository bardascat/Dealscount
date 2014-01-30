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

        <link rel="shortcut icon"  type="image/png"  href="<? echo URL ?>layout/favicon.ico">
    </head>

    <body>


        <script type="text/javascript">
            $(document).ready(function() {


                $("#city_id").selectbox();


                windowWidth = $(window).width();
                var offers_width = windowWidth - 215;

                var nr_offers = parseInt(offers_width / 240.9);

                if (nr_offers >= 3) {
                    var width = 0;

                    var offers_real_width = $('.offers').width();
                    if (offers_real_width < 237 * nr_offers)
                        width = offers_real_width - 20;
                    else
                        width = 237 * nr_offers;

                    $('.header').width(width);
                    $('.info_bar').width(width);
                    $('.user_menu').width(width);

                }

            });
        </script>

        <body>
            <div id="wrapper">

                <div id="left_side">

                    <div class="logo">
                        <a  onmouseover="close_subcats()" href="http://{$project_url}">
                            <img src="<?php echo base_url().'/assets'?>/images_fdd/getadeal_logo.png" width="170" height="40"/>
                        </a>
                    </div>

                    <ul class="categorii">
                        categorii
                    </ul>

                    <table border="0" class="promo">
                        <tr>
                            <td>
                                <a href="cumperisicastigi.php">
                                    <img src="<?php echo base_url().'/assets'?>/images_fdd/cumperi&castigi.png" width="67" height="66"/>
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
                                    <img src="<?php echo base_url().'/assets'?>/images_fdd/punctegad.png" width="67" height="66"/>
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
                                    <img src="<?php echo base_url().'/assets'?>/images_fdd/happyhour.png" width="67" height="66"/>
                                </a>
                            </td>
                            <td style="border:0px;">
                                Reduceri la reduceri<br/>
                                Intra zilnic pe site<br/>
                                ca sa nu le ratezi!
                            </td>
                        </tr>
                    </table>

                    <div class="clienti">
                        <div style="color: #00a9e9">Asistenta clienti</div>
                        <div>021.230.50.30</div>
                        <div>info@getadeal.ro</div>
                        <div>Lu - Vi: 0900-1800</div>
                    </div>

                    <div class="form_comanda_btn">
                        <a href="form_comanda.php?offerId=home">
                            <img src="<?php echo base_url().'/assets'?>/images_fdd/form_comanda.png"/>
                        </a>
                    </div>

                </div>


                <div id="right_side">

                    <div class="header">

                        <div class="search_bar">
                            <form method="post" action="index.php?">
                                <input type="text" name="query" class="query_field" value="Cauta" 
                                       onfocus="if (this.value == 'Cauta') {
                    this.value = '';
                }" onblur="if (this.value == '') {
                    this.value = 'Cauta';
                }" />
                                <input type="hidden" name="search" value="true" />
                                <input type="submit" value="" class="search_submit" />
                            </form>
                        </div>


                        <div style="float: left;margin-left: 20px;margin-top: 8px;">
                            <a href="cadou=1">
                                <img src="<?php echo base_url().'/assets'?>/images_fdd/love-is-in-the-air.png"/>
                            </a>
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
                                <a
                                    style="display:block; display:block; margin:0px; padding:0px; width:80px;"
                                    href="javascript:login">

                                    <div class="icon"style=" background-image:url('<?php echo base_url().'/assets'?>/images_fdd/sir.png');margin-top:8px; height:29px ">
                                    </div>
                                </a>

                                <a href="javascript:contul_meu()">Contul meu</a>
                                <div class="contul_meu_container">
                                    <a style="padding-right:0px;" href="my_orders.php">Voucherele mele</a>
                                    <a style="padding-right:0px;" href="account.php">Contul meu</a>
                                    <a style="padding-right:0px;" href='/xadmin_index.php'>Admin</a>
                                    <a style="padding-right:0px;" href="logout.php">Logout</a>
                                </div>
                                <div id="login_form">
                                    <form method="post" action="login.php">
                                        <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>Login</td>
                                                <td align="right">
                                                    <img src="<?php echo base_url().'/assets'?>/images_fdd/icon_om.png"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="text" value="User" onblur="if (this.value == '') {this.value = 'User';}" onfocus="if (this.value == 'User') {this.value = '';}" name="user_box">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="password" value="password" onblur="if (this.value == '') {
                    this.value = 'password';
                }" onfocus="if (this.value == 'password') {
                    this.value = '';
                }" name="pass_box">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="register.php" style="padding: 0px; margin: 0px;display:block; width:74px; float: left; *margin-top:3px;">
                                                        <img src="<?php echo base_url().'/assets'?>/images_fdd/cont_nou.png"/>
                                                    </a>
                                                </td>
                                                <td>
                                                    <input type="submit" value="" style="width: 0px; height: 0px; visibility:hidden; position: absolute;"/>
                                                    <div  type="submit" onclick="$('#login_form form').submit()"
                                                          class="login_btn">
                                                        <img src="<?php echo base_url().'/assets'?>/images_fdd/login.png"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><a style="padding: 0px; margin: 0px; width:auto; float:none; color:#FFF;display:inline;" 
                                                                   href="http://fddlab.getadeal.ro/forgot.php">Am uitat parola</a></td>

                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </li>
                        </ul>
                  </div>
        