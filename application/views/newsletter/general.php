<?php
/* @var  $offer Dealscount\Models\Entities\Item */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <style>
            img{
                border:0;

                line-height:100%;
                outline:none;
                text-decoration:none;
            }
            body{
                width:100% !important;
            }
            .ReadMsgBody{
                width:100%;
            }
            .ExternalClass{
                width:100%;
            }
            body{
                -webkit-text-size-adjust:none;
            }
            body{
                margin:0;
                padding:0;
                font-family: Arial;
            }
        </style>
    </head>
    <body  bgcolor="#eeeeee">
        <table bgcolor="#eeeeee" width="670" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td>
                    <table bgcolor=""  width="670" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td style="padding-top: 20px; padding-bottom: 30px;">
                                <table border='0' width='100%' cellpadding="0" cellspacing='0'>
                                    <tr>
                                        <td style='padding-left:10px;'>
                                            <a style="display: block;" href="<?php echo base_url() ?>">
                                                <img alt="<?php DLConstants::$WEBSITE_COMMERCIAL_NAME ?>" src="<?php echo base_url('assets/images_fdd/logo.png') ?>"/>
                                            </a>
                                        </td>
                                        <td style='text-align: right; padding-right: 10px;'>
                                            <?php echo date("d-m-Y") ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        foreach ($offers as $offer) {
                            ?>

                            <tr>
                                <td style="padding-bottom: 10px;  ">
                                    <table bgcolor="#FFFFFF" width="100%" cellpadding="0" border="0" cellspacing="0">
                                        <tr>
                                            <td width="102">
                                                <a href="<?php echo base_url('oferte/' . $offer->getSlug()) ?>">
                                                    <img style="display: block;" width="102" height="83" src="<?php echo base_url($offer->getMainImage()) ?>"/>
                                                </a>
                                            </td>
                                            <td width="329" style="padding-left: 16px; padding-right: 6px; color: #161616; font-size: 14px;">
                                                <?php
                                                echo substr($offer->getBrief(), 0, 185) . '...';
                                                ?>
                                            </td>
                                            <td height="78" width="117">
                                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td height="70" style="text-align: center;border-left: 1px solid #ccc; border-right: 1px solid #ccc;">
                                                            <span style='font-size: 27px;'><?php echo $offer->getVoucher_price() ?></span>
                                                            <span>lei</span>
                                                            <span style="font-size: 15px; color:#909090; text-decoration: line-through "> <?php echo $offer->getPrice() ?></span>

                                                        </td>
                                                    </tr>
                                                </table> 
                                            </td>
                                            <td width="83" style="text-align: center">
                                                <a href="<?php echo base_url('oferte/' . $offer->getSlug()) ?>">
                                                    <img src="<?php echo base_url('assets/images_fdd/fab_newsletter_icon_lupa.png') ?>"/>
                                                </a>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                        <?php } ?>

                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>