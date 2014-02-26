<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="Romanian" />
        <meta http-equiv="Content-Language" content="ro" />
        <title><?php echo $this->view->getMetaTitle() ?></title>
        <meta name="description" content="<?php echo $this->view->getMetaDesc() ?>"/>
        <meta name="keywords" content="<?php echo $this->view->getMetaKeywords() ?>"/>
        <?php echo $this->view->getCss(); ?>
        <link href='http://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
            <?php echo $this->view->getJs(); ?>
            <?php echo $this->view->getNotification() ?>
            <?php echo $this->view->getPopulate_form() ?>
            <link rel="shortcut icon"  type="image/png"  href="<?php echo base_url() ?>assets/images_fdd/favicon.ico">
                </head>
                <body>

                    <div id="wrapper">
                        <div id="header">
                            <div class="center_header">
                                <div class="logo">
                                    <a href="<?php echo base_url() ?>">
                                        <img src="<?php echo base_url('assets/gad_images_fdd/getadeal_logo.png') ?>"/>
                                    </a>
                                </div>
                                <div class="header_search">
                                    <form method="get" action="">
                                        <input type="text" name="q"/>
                                        <input type="submit" value=""/>
                                    </form>
                                </div>
                                <ul class="header_menu">
                                    <li class="my_account">
                                        <a href="">Contul Meu</a>
                                    </li>
                                    <li  class="shopping_cart">
                                        <a href="<?php echo base_url('cart') ?>">Cosul meu (<?php echo $this->view->getCartModel()->getNrItems(); ?>)</a>
                                         <?php $this->load->view('components/cart_summary.php'); ?>
                                    </li>
                                </ul>

                                <ul class="header_categories">
                                    <?php
                                    foreach ($this->view->getCategories() as $category) {
                                        $parent = $category['parent'];
                                        ?>
                                        <li id="parent_<?php echo $parent['id_category'] ?>">
                                            <a onmouseover = "show_subcats(<?php echo $parent['id_category'] ?>)"
                                               href = "<?php echo base_url('categorii/' . $parent['slug']) ?>"><?php echo $parent['name'] ?></a>
                                               <?php if ($this->uri->segment(2) == $parent['slug']) { ?>
                                                <div class="elipse"></div>
                                            <?php } ?>
                                            <div id="<?php echo $parent['id_category'] ?>" class="subcats">
                                                <ul>
                                                    <?php foreach ($category['childs'] as $category) { ?>
                                                        <li>
                                                            <div><a  href="<?php echo base_url('categorii/' . $parent['slug'] . '/' . $category['category_slug']) ?>"><?php echo $category['category_name'] ?></a></div>
                                                        </li>
                                                    <?php } ?>
                                                    <li class="footer_end"></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="bullet"></li>
                                        <?php }
                                        ?>


                                </ul>
                            </div>
                        </div>