<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>VWR Supplier Central</title>
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/basic_ie.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/common.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/basic.js"></script>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.simplemodal.js"></script>
		<script type="text/javascript">
			jQuery(function($) {
				$('div#skip-link a').html('');
			});
			var sanitizeHTML = function(str) {
				var temp = document.createElement('div');
				temp.textContent = str;
				return temp.innerHTML;
			}

			function triggermails() {
				var emailid = $.trim($("#email_id").val());
				if (emailid == '') {
					$('#reseterror').html('Please enter your email address').show();
					return false;
				} else if (!validateEmail(emailid)) {
					$('#reseterror').html('Please enter valid email address').show();
					return false;
				}
				$.ajax({
					type: "POST",
					url: baseurl + 'trigger/mails/action/confirm',
					data: "emailid=" + emailid,
					success: function(res) {
						if (res == 'send') {
							var backupcontent = $('<div/>', {
								html: sanitizeHTML($('#page-container').html())
							}).text();
							$('#page-container h3').html('Sending Emails...');
							$('#page-container-body').html('<div align="center" style="text-align:center; margin:25px 10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /><br /><br />Sending mails...</div>');
							$.ajax({
								type: "POST",
								url: baseurl + 'trigger/mails/action/send',
								data: "emailid=" + emailid,
								success: function(result) {
									if (result == 'success') {
										$('#page-container h3').html('Action completed');
										$('#page-container-body').html('Thank you. Emails sent successfully.');
									} else if (result == 'noneed') {
										$('#page-container h3').html('Action completed');
										$('#page-container-body').html('Thank you. No emails found without credentials.');
									} else {
										$("#page-container").html($('<div/>', {
											html: sanitizeHTML(backupcontent)
										}));
										$('#reseterror').html('Sorry for inconvenience. Error in sending emails').show();
									}
								}
							});
						} else {
							$('#reseterror').html('Sorry! you are not authorized for this action').show();
						}
					}
				});
			}
		</script>
	</head>
	<?php drupal_set_title("Mail Trigger"); ?>

	<body>
		<div class="wrapper">
			<div class="header">
				<div class="logo"><a href="<?php echo base_path(); ?>"><img src="<?php echo base_path() . path_to_theme(); ?>/images/logo.jpg" alt="VWR" width="272" height="72" /></a></div>
				<div class="header_right">
					<div class="top_links">
						
					</div>
					<div class="slog"><img src="<?php echo base_path() . path_to_theme(); ?>/images/slog.jpg" width="229" height="30" alt="vwr" /></div>
				</div>
				<div class="menu">
					<ul>
						<li><a href="#"></a></li>
					</ul>
				</div>
			</div>
			<div class="content_container clearfix">
				<div class="content_container clearfix" id="internal_reg">
					<div class="bread_crumb"></div>
					<div class="welcome" id="page-container">
						<h3>Mail Confirmation</h3>
						<div class="reg_form" id="page-container-body" style="padding:10px 20px;">
							<form id="reg_form" method="post">
								<div style="clear:both; font-weight:bold; margin:10px 10px 20px 5px;">Please provide your Email Id and click OK to proceed with one time password reset URL</div>
								<div class="error" id="reseterror" style="display:none"></div>
								<div class="reg_labl"><span>*</span>
									<label style="display:inline-block;">Email Id:</label>
								</div>
								<div class="reg_inpt">
									<input type="email" id="email_id" name="email_id" tabindex="1" />
								</div>
								<div class="reg_btn">
									<input type="button" class="button" value="OK" onclick="triggermails();" tabindex="2" />
									<input type="button" class="button" value="Reset" onclick="$('#email_id').val(''); $('#reseterror').hide();" tabindex="3" />
								</div>
							</form>
						</div>
					</div>

				</div>
				<?php
				$query = db_query("SELECT legal_text,legal_link FROM {legal_details}");
				$number_of_rows = $query->rowCount();
				if ($number_of_rows != '') {
					foreach ($query as $record) {
						$legal_text = $record->legal_text;
						$legal_link = $record->legal_link;
					}
				} else {
					$legal_text = 'Legal Notice';
				}
				?>
				<div class="footer">
					<div class="copy">&copy; VWR International, LLC. All rights reserved.</div>
					<div class="footer_links"><a href="<?php echo $legal_link; ?>" rel="noopener" target="_blank"><?php echo $legal_text; ?></a></div>
					<?php
					$google_analytics = variable_get('google_analytics_UA');
					?>
					<script type="text/javascript">
						var _gaq = _gaq || [];
						_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
						_gaq.push(['_trackPageview']);

						(function() {
							var ga = document.createElement('script');
							ga.type = 'text/javascript';
							ga.async = true;
							ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
							var s = document.getElementsByTagName('script')[0];
							s.parentNode.insertBefore(ga, s);
						})();
					</script>
				</div>
			</div>
		</div>
	</body>

	</html>