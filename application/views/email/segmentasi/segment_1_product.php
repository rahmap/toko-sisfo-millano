<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<title><?= APP_NAME ?> - <?= $judulEmail ?></title>
	<style type="text/css">

	@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
	@import url(https://fonts.googleapis.com/css?family=Hind:400,700);
	@import url(https://fonts.googleapis.com/css?family=Varela+Round);

	.ReadMsgBody { width: 100%; background-color: #ffffff; }
    .ExternalClass { width: 100%; background-color: #ffffff; }
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
	html { width: 100%; }
	body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }
	table { border-spacing: 0; border-collapse: collapse; }
	table td { border-collapse: collapse; }
	.yshortcuts a { border-bottom: none !important; }
	img { display: block !important; }
	a { text-decoration: none; color: #f27244; }

	/* Media Queries */

	@media only screen and (max-width: 640px) {
		body { width: auto !important; }
		table[class="table600"] { width: 450px !important; }
		table[class="table-container"] { width: 90% !important; }
		table[class="container2-2"] { width: 47% !important; text-align: left !important; }
		table[class="full-width"] { width: 100% !important; text-align: center !important; }
		img[class="img-full"] { width: 100% !important; height: auto !important; }
}

	@media only screen and (max-width: 479px) {
		body { width: auto !important; }
		table[class="table600"] { width: 290px !important; }
		table[class="table-container"] { width: 82% !important; }
		table[class="container2-2"] { width: 100% !important; text-align: left !important; }
		table[class="full-width"] { width: 100% !important; text-align: center !important; }
		img[class="img-full"] { width: 100% !important; }
}

	</style>

</head>

<body marginwidth="0" marginheight="0" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;" offset="0" topmargin="0" leftmargin="0">
	<!-- HEADLINE AND CONTENT -->
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" bgcolor="#ffffff">
				<table class="table600" width="600" border="0" cellpadding="0" cellspacing="0">

					<tr>
						<td height="50" style="font-size: 1px; line-height: 50px;">&nbsp;</td>
					</tr>

					<tr>
						<td align="center" style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 400; color: #888888; line-height: 24px; letter-spacing: 2px;">
							<?= $judulKecil ?>
						</td>
					</tr>

					<tr>
						<td height="15" style="font-size: 1px; line-height: 15px;">&nbsp;</td>
					</tr>

					<tr>
						<td align="center" style="font-family: 'Hind', sans-serif; font-size: 28px; font-weight: 700; color: #333333; line-height: 32px; letter-spacing: 2px;">
							<?= $judulBesar ?>
						</td>
					</tr>

					<!-- Underline -->
					<tr>
						<td align="center">
							<table width="75" border="0" cellpadding="0" cellspacing="0">
							<!-- Edit Underline -->
								<tr>
									<td height="20" style="border-bottom: 2px solid #f27244;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- End Underline -->


				</table>
			</td>
		</tr>
	</table>
	<!-- END HEADLINE AND CONTENT -->

	<!-- ARTICLE FULL WIDTH -->
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" bgcolor="#ffffff">
				<table class="table600" width="600" border="0" cellpadding="0" cellspacing="0">

					<tr>
						<td height="50" style="font-size: 1px; line-height: 50px;">&nbsp;</td>
					</tr>

					<tr>
						<td>
							<img class="img-full" src="<?= $urlGambar ?>" alt="img" width="600" height="250">
						</td>
					</tr>

					<tr>
						<td height="30" style="font-size: 1px; line-height: 30px;">&nbsp;</td>
					</tr>

					<tr>
						<td align="center" style="font-family: 'Hind', sans-serif; font-size: 24px; font-weight: 700; color: #333333; letter-spacing: 1px; line-height: 28px;">
							<?= $judulProduk ?>
						</td>
					</tr>

					<tr>
						<td height="20" style="font-size: 1px; line-height: 20px;">&nbsp;</td>
					</tr>	

					<tr>
						<td align="center" style="font-family: 'Varela Round', sans-serif; font-size: 13px; font-weight: 400; color: #8f96a1; line-height: 28px;">
							<?= $keteranganProduk ?>
						</td>
					</tr>

					<tr>
						<td height="20" style="font-size: 1px; line-height: 20px;">&nbsp;</td>
					</tr>

					<!-- Button -->
					<tr>
						<td align="center">
							<!-- Background Button -->
							<table align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#f27244" style="border-radius: 2px;">
								<tr>
									<td align="center" height="44" style="font-family: 'Montserrat', sans-serif; font-size: 12px; font-weight: 700; color: #ffffff; letter-spacing: 1px; line-height: 24px; padding-left: 30px; padding-right: 30px;">
										<a href="<?= $urlProduk ?>" style="text-decoration: none; color: #ffffff;">
											<?= $titleTombol ?>
										</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- End Button -->

					<tr>
						<td height="50" style="font-size: 1px; line-height: 50px;">&nbsp;</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
	<!-- END ARTICLE FULL WIDTH -->

		<!-- FOOTER -->
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<!-- Background -->
			<td align="center" bgcolor="#212121">
				<table class="table600" width="600" border="0" cellpadding="0" cellspacing="0">

					<tr>
						<td height="15" style="font-size: 1px; line-height: 15px;">&nbsp;</td>
					</tr>

					<tr>
						<td>

							<table class="full-width" width="350" align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

								<tr>
									<td style="font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 400; color: #ffffff; line-height: 24px;">
										© <?= date('Y') ?> <?= APP_NAME ?>. All Rights Reserved.
									</td>
								</tr>

							</table>

							<!-- SPACE -->
								<table class="full-width" width="1" align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" >
									<tr>
										<td width="1" height="15" style="font-size: 1px; line-height: 15px;"></td>
									</tr>
								</table>
							<!-- END SPACE -->

							<table class="full-width" width="115" align="right" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">

								

							</table>

						</td>
					</tr>

					<tr>
						<td height="15" style="font-size: 1px; line-height: 15px;">&nbsp;</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
	<!-- END FOOTER -->

</body>
</html>
