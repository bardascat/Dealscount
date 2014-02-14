<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Oringo Voucher</title>
	<style type="text/css">
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
<body style="background-color: #fff;">
<div style="width:100% !important; margin:0; padding:0; background-color: #fff;" id="voucher">
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="border-collapse:collapse; margin:0; padding:0; width:100% !important; line-height: 100% !important; font-family: Arial; font-size: 14px; color: #4f5153;" align="center">
	<tr>
		<td valign="top">
		<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" cellpadding="0" cellspacing="0" border="0" align="center" width="600">
			<tr>
				<td style="border-collapse: collapse; background-color: #f2f2f2; width: 100%; height: 56px;	text-align: center; padding-top: 10px; padding-bottom: 10px;" valign="middle" id="header">					<img class="image_fix" src="" alt="Your alt text" style="display:block; outline:none; text-decoration:none;  display: inline; margin-top: 5px;" />
				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="background-color: #fff; border-collapse:collapse;">
			<tr>
				<td width="200" valign="top"> &nbsp; </td>
				<td width="200" valign="top"> &nbsp; </td>
				<td width="200" valign="top"> &nbsp; </td>
			</tr>
		</table>

		<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse; font-family: Arial;">
			<tr>
				<td valign="top" style="font-size: 21px; font-family: Arial; color: #4f5153; line-height: 21px; padding-left: 20px; padding-right: 20px; padding-bottom: 10px;">
					<b> echo $voucher['nume_oferta']; ?></b><br />
					<span style="font-size: 0.8em;"> echo $voucher['excerpt']; ?></span>
				</td>
			</tr>
		</table>

		<table cellpadding="10" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse;  echo (!$voucher['valabil_de_la'] && !$voucher['valabil_pana_la'] ? 'border-bottom: 1px solid #ECECEC;' : ''); ?> font-family: Arial; font-size: 14px; color: #4f5153;">
			<tr>
				<td width="200" valign="top" style="padding-left: 20px; padding-right: 0px;">
					<img src=" echo $voucher['photo']; ?>" width="243" height="184">
				</td>
				<td width="50">&nbsp;</td>
				<td width="350" valign="middle" style="padding-left: 10px;">
                    <table style="text-align: center;" cellpadding="0" cellspacing="0" border="0" width="350">
						<tr>
							<td>Valoarea voucherului<br/></td>
						</tr>
						<tr>
							<td height="5"></td>
						</tr>
						<tr> <!-- modificari
                                                    <span class="valoare" style="font-size: 80px; text-align: center;"> echo round($voucher['valoare'], 2); ?></span>
                                                    -->
							<td>
								
								<span class="valoare" style="font-size: 80px; text-align: center;">Gratuit</span>
								<span class="lei" style="text-align: center; display: none;">lei</span>
							</td>
						</tr>
                    </table><br/><br/>
                    <table style="border-top: 1px solid #ECECEC;" cellpadding="0" cellspacing="0" border="0" width="350">
						<tr>
							<td style="text-align: left;">
								<br /><span style="font-weight: bold; float: left;"> echo $voucher['nume']; ?></span>
							</td>
							<td style="text-align: right;"><br />
								<span style="float: right; margin-right: 10px;">
									Numar vouchere:  echo $voucher['quantity']; ?>
								</span>
							</td>
						</tr>
                    </table>
				</td>
			</tr>
		</table>

		<table cellpadding="10" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse; font-family: Arial; font-size: 14px; color: #4f5153;">
			<tr>
				<td valign="top">
					 if ($voucher['valabil_de_la'] || $voucher['valabil_pana_la']) { ?>
					<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse; font-family: Arial; border-bottom: 1px solid #ECECEC; border-top: 1px solid #ECECEC;  ">
						<tr>
							<td class="valabilitate" colspan="3" align="center" style="padding-top: 15px; padding-bottom: 15px;">
								VALABILITATE | DE LA:  echo $voucher['valabil_de_la']; ?> | PANA LA  echo $voucher['valabil_pana_la']; ?></td>
						</tr>
					</table>
					 } ?>

					<table cellpadding="10" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse; font-family: Arial; color: #000;">
						<tr style="border-bottom: 1px solid #ECECEC; padding-bottom: 20px;">
							 if($voucher['company_logo']!=''):?>
							<td width="120" valign="top" style="padding-left: 0px;">
								<img width="120px" src=" echo base_url('images/admin/logo_furnizori/mici/'.$voucher['company_logo']); ?>">
							</td>
							 endif;?>
							<td valign="top">
								<table style="font-size: 13px;" border="0" celpadding="5" cellspacing="0">
									<tr><td><b> echo $voucher['company_name']; ?></b></td></tr>
									<tr><td height="5"></td></tr>
									 if ($voucher['company_site']) { ?><tr><td><b>site:</b>  echo str_replace('http://','',$voucher['company_site']); ?></td></tr> } ?>
		                             if ($voucher['company_email']) { ?><tr><td><b>email:</b>  echo $voucher['company_email']; ?></td></tr> } ?>
		                             if ($voucher['company_phone']) { ?><tr><td><b>telefon:</b>  echo $voucher['company_phone']; ?></td></tr> } ?>
		                             if ($voucher['company_adresa']) { ?><tr><td><b>adresa:</b>  echo $voucher['company_adresa']; ?></td></tr> } ?>
								</table>
							</td>
						</tr>
					</table>

					<table cellpadding="10" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse; color: #000; font-family: Arial;">
						<tr>
							<td colspan="2" class="descriere">
		                        <h1 style="font-size: 16px; margin-bottom: 15px; margin-top: 15px;">Serie voucher</h1><br />
		                        <span class="text_voucher" style="font-size: 13px; font-weight: bold;">
		                            
										$voucher_num = strlen($voucher['codes'])/9-1;
										for($i=0; $i<strlen($voucher['codes'])/9; $i++)
											echo substr($voucher['codes'], $i*9, 8).($i!=$voucher_num ? '; ' : '');
		                             ?>
		                        </span>
		                    </td>
						</tr>
					</table>

					<table cellpadding="10" cellspacing="0" border="0" align="center" width="600" style="background-color: white; border-collapse:collapse; color: #000; font-family: Arial;">
						<tr>
							<td colspan="2" class="descriere">
		                        <h1 style="font-size: 16px; margin-bottom: 15px; margin-top: 15px;">Beneficii</h1><br />
		                        <span class="text_voucher" style="font-size: 13px;">
		                             echo $voucher['nume_oferta']; ?>:  echo $voucher['excerpt']; ?> ( echo $voucher['quantity']; ?> buc)<br />
		                             echo $voucher['beneficii']; ?>
		                        </span><br/><br/>

		                        <h1 style="font-size: 16px; margin-bottom: 15px; margin-top: 15px;">Termenii Voucherului</h1><br />
		                        <span class="text_voucher" style="font-size: 13px;">
		                             echo $voucher['nume_oferta']; ?>:  echo $voucher['excerpt']; ?> ( echo $voucher['quantity']; ?> buc)<br />
		                             echo $voucher['termeni']; ?>
		                        </span><br/><br/>
		                    </td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<!-- End of wrapper table -->
</div>
z</body>
</html>
