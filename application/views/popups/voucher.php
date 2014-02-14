<?php
/* @var $offer \Dealscount\Models\Entities\Item */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Oringo Voucher</title>
        <style type="text/css">
            *{font-family: Arial;}
            #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
            body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
            /* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/
            .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            /* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
            #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            /* End reset */
            /* Some sensible defaults for images
            Bring inline: Yes. */
            img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
            a img {border:none;}
            .image_fix {display:block;}

            /* Yahoo paragraph fix
            Bring inline: Yes. */
            p {margin: 1em 0;}

            /* Hotmail header color reset
            Bring inline: Yes. */
            h1, h2, h3, h4, h5, h6 {color: black !important;}

            h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}

            h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
                color: red !important; /* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
            }

            h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
                color: purple !important; /* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
            }

            table td {border-collapse: collapse;}

            table { border-collapse:collapse; }

            /* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
            Bring inline: Yes. */
            a {color: orange;}

            @media only screen and (max-device-width: 480px) {
                /* Part one of controlling phone number linking for mobile. */
                a[href^="tel"], a[href^="sms"] {
                    text-decoration: none;
                    color: blue; /* or whatever your want */
                    pointer-events: none;
                    cursor: default;
                }

                .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                    text-decoration: default;
                    color: orange !important;
                    pointer-events: auto;
                    cursor: default;
                }

            }

            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
                /* You guessed it, ipad (tablets, smaller screens, etc) */
                /* repeating for the ipad */
                a[href^="tel"], a[href^="sms"] {
                    text-decoration: none;
                    color: blue; /* or whatever your want */
                    pointer-events: none;
                    cursor: default;
                }

                .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                    text-decoration: default;
                    color: orange !important;
                    pointer-events: auto;
                    cursor: default;
                }
            }

            @media only screen and (-webkit-min-device-pixel-ratio: 2) {
                /* Put your iPhone 4g styles in here */
            }

            /* Android targeting */
            @media only screen and (-webkit-device-pixel-ratio:.75){
                /* Put CSS for low density (ldpi) Android layouts in here */
            }
            @media only screen and (-webkit-device-pixel-ratio:1){
                /* Put CSS for medium density (mdpi) Android layouts in here */
            }
            @media only screen and (-webkit-device-pixel-ratio:1.5){
                /* Put CSS for high density (hdpi) Android layouts in here */
            }
            /* end Android targeting */

        </style>
    </head>
    <body>
        <div style="width:100% !important; margin:0; padding:0; background-color: #fff;" id="voucher">
            <table width="700"  cellspacing="0">
                <tr>
                    <td style=" background-color: #f2f2f2; width: 100%; height: 56px;text-align: center;" valign="middle">					
                        <img src="<?= base_url() ?>images/blue-oringo-logo.jpg" alt="Oringo"  />
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="font-size: 20px; color: #4f5153; line-height: 21px; padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px;">
                        <b><?php echo $offer->getName() ?></b><br />
                        <span style="font-size: 17px;"><?php echo $offer->getBrief(); ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 20px;">
                        <table border="0">
                            <tr>
                                <td width="243" valign="top" style="padding-left: 20px; padding-right: 0px;">
                                    <img src="<?php echo base_url($offer->getMainImage()) ?>" style="width: 243px; height: 184px;">
                                </td>
                                <td style="width: 350px;">

                                    <table style="text-align: center; width: 350px; height: 200px; " cellpadding="0" cellspacing="0" border="0">
                                        <?php if ($offer->getSale_price()): ?>
                                            <tr>
                                                <td style="padding-bottom: 15px;"><span style="font-size: 16px;">Valoarea voucherului</span></td>
                                            </tr>
                                            <tr>
                                                <td width="350" style="width: 350px;">
                                                    <table width='100%'>
                                                        <tr>
                                                            <td> <div  style="font-size: 80px;"><?php echo round($offer->getSale_price(), 2); ?> </div></td>
                                                            <td style="padding-top: 30px;">
                                                                <div  style="font-size: 30px; width: 30px; text-align: left; padding-top: 20px;">lei</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td style="padding-bottom: 15px;"><span style="font-size: 60px;">Gratuit</span></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td style="padding-top: 10px;">
                                                <span style="font-weight: bold; font-size: 18px;">Beneficiar: <?php echo $voucher->getRecipientName() ?></span>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>

                    <td class="valabilitate" align="center" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #ECECEC; border-top: 1px solid #ECECEC; ">
                        VALABILITATE | DE LA: <?php echo $offer->getVoucher_start_date() ?> | PANA LA <?php echo $offer->getVoucher_end_date() ?>
                    </td>

                </tr>
                <tr>
                    <td class="valabilitate" align="center" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #ECECEC; ">
                        <span style="font-weight: bold; font-size: 18px;">Serie Voucher: <?php echo $voucher->getCode() ?></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 30px; padding-left: 20px;">
                        <table>
                            <tr>
                                <?php if ($companyDetails->getImage()) { ?>
                                    <td  valign="top" style="padding-left: 0px; width: 120px;">
                                        <img height="110" src="<?php echo base_url($companyDetails->getImage()) ?>">
                                    </td>
                                <?php } ?>
                                <td style="padding-left: 20px;">
                                    <table style="font-size: 15px;" border="0" celpadding="5" cellspacing="0">
                                        <tr><td><b><?php echo $companyDetails->getCompany_name() ?></b></td></tr>
                                        <tr><td height="5"></td></tr>
                                        <?php if ($companyDetails->getWebsite()) { ?><tr><td><b>site:</b> <?php echo str_replace('http://', '', $companyDetails->getWebsite()); ?></td></tr><?php } ?>
                                        <tr><td><b>email:</b> <?php echo $company->getEmail() ?></td></tr>
                                        <?php if ($companyDetails->getPhone()) { ?><tr><td><b>telefon:</b> <?php echo $companyDetails->getPhone() ?></td></tr><?php } ?>
                                        <?php if ($companyDetails->getAddress()) { ?><tr><td><b>adresa:</b> <?php echo $companyDetails->getAddress() ?></td></tr><?php } ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>

                    <td style="padding-top: 30px; padding-left: 20px;">
                        <h1 style="font-size: 20px; margin-bottom: 15px; margin-top: 15px;">Beneficii</h1><br />
                        <span class="text_voucher" style="font-size: 13px;">
                            <?php echo $offer->getName() ?>: <?php echo $offer->getBrief() ?><br />
                            <?php echo $offer->getBenefits() ?>
                        </span><br/><br/>

                        <h1 style="font-size: 20px; margin-bottom: 15px; margin-top: 15px;">Termeni</h1><br />
                        <span class="text_voucher" style="font-size: 13px;">
                            <?php echo $offer->getName() ?>: <?php echo $offer->getBrief() ?><br />
                            <?php echo $offer->getTerms() ?>
                        </span><br/><br/>


                    </td>

                </tr>
            </table>
        </div>
    </body>
</html>