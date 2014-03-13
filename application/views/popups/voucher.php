<?php
/* @var $offer \Dealscount\Models\Entities\Item */
/* @var $voucher \Dealscount\Models\Entities\OrderVoucher */
/* @var $companyDetails \Dealscount\Models\Entities\Company */
/* @var $company \Dealscount\Models\Entities\User */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php DLConstants::$WEBSITE_COMMERCIAL_NAME?> Voucher</title>
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
        <div style="width:100% !important; margin:0; padding:0; background-color: #fff; padding-left: 15px;" id="voucher">
            <table width="1000" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" style="padding-top: 30px;">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding-left: 20px;" width="500">
                                    <img width="200" src="<?php echo base_url('assets/images_fdd/logo.png') ?>"/>
                                </td>
                                <td style="font-size:18px; ">
                                    <div><?php echo strtoupper($voucher->getRecipientName()) ?></div>
                                    <div>Serie: <?php echo $voucher->getCode() ?></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 30px; vertical-align: top">
                        <img width="313" src="<?php echo base_url($offer->getMainImage()) ?>"/>
                    </td>
                    <td width="400" style="padding-top: 30px; font-size: 17px; padding-left: 20px; vertical-align: top;">
                        <?php echo $offer->getBrief() ?>

                        <table>
                            <tr>
                                <td  style="padding-top: 20px;padding-bottom: 8px; border-bottom: 1px solid #d3d3d3; width:250px;">
                                    <span style="font-size: 42px;"><?php echo $offer->getVoucher_price() ?></span><span style="font-size: 18px;">lei</span>
                                </td>
                            </tr>
                            <tr>
                                <td  style="padding-top: 7px; padding-bottom: 7px; border-bottom: 1px solid #d3d3d3; width:250px;">
                                    <span style="font-size: 14px;">Reducere: </span> <span style="font-size: 18px; font-weight: bold;"><?php echo $offer->getPercentageDiscount() ?>%</span>
                                </td>
                            </tr>
                            <tr>
                                <td  style="padding-top: 7px; padding-bottom: 7px; border-bottom: 1px solid #d3d3d3; width:250px;">
                                    <span style="font-size: 14px;">Pret intreg: </span> <span style="font-size: 18px; font-weight: bold;"><?php echo $offer->getPrice() ?></span><span style="font-size: 16px;"> lei</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 20px; vertical-align: top; padding-right: 10px;">
                        <h1 style="font-size: 20px;  font-weight: normal;">Despre Oferta</h1>
                        <br/>
                        <?php echo $offer->getBenefits() ?>
                    </td>
                    <td style="padding-left: 20px;padding-right: 10px; padding-top: 20px;  vertical-align: top; ">
                        <h1 style="font-size: 20px; font-weight: normal;">Termeni Oferta</h1>
                        <br/>
                        <?php echo $offer->getTerms() ?>

                        <br/>
                        <h1 style="font-size: 18px;  font-weight: normal;"><?php echo ($companyDetails->getCommercial_name() ? $companyDetails->getCommercial_name() : $companyDetails->getCompany_name()) ?></h1>
                        <br/>
                        <?php if ($companyDetails->getAddress()) { ?>
                            <div>
                                <b>Adresa</b>
                                <?php echo $companyDetails->getAddress(); ?>
                            </div>
                        <?php } ?>
                        <?php if ($companyDetails->getAddress()) { ?>
                            <div>
                                <b>Site</b>
                                <?php echo $companyDetails->getWebsite(); ?>
                            </div>
                        <?php } ?>
                        <?php if ($company->getEmail()) { ?>
                            <div>
                                <b>Email</b>
                                <?php echo $company->getEmail(); ?>
                            </div>
                        <?php } ?>
                        <?php if ($companyDetails->getPhone()) { ?>
                            <div>
                                <b>Adresa</b>
                                <?php echo $companyDetails->getPhone(); ?>
                            </div>
                        <?php } ?>

                    </td>
                </tr>


            </table>
        </div>
    </body>
</html>