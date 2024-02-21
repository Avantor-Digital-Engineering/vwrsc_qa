<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>VWR Supplier Central</title>
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/basic_ie.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/common.css" rel="stylesheet" type="text/css" />
		<!-- IE6 "fix" for the close png image -->
		<!--[if lt IE 7]>
		<link type='text/css' href='css/basic_ie.css' rel='stylesheet' media='screen' />
		<![endif]-->
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/basic.js"></script>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.simplemodal.js"></script>
		<script type="text/javascript">
			jQuery(function($) {
				$('.welcome').css('min-height', '246px');
			});
		</script>
	</head>
	<?php
	drupal_set_title("Reset Password");
	$email = arg(2);
	?>

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
					<div class="welcome">
						<h3>Reset Password</h3>
						<div class="reg_form">
							<form id="reg_form" method="post">
								<div class="error" id="reseterror" style="display:none"></div>
								<div class="reg_labl"><span>*</span>
									<label style="display:inline-block;">Password :</label>
								</div>
								<div class="reg_inpt">
									<input type="password" id="res_password" name="res_password" tabindex="1" />
								</div>
								<div class="reg_labl"><span>*</span>
									<label style="display:inline-block;">Confirm Password:</label>
								</div>
								<div class="reg_inpt">
									<input type="password" id="reset_confirm" name="reset_confirm" tabindex="2" />
								</div>
								<div style="clear:both;"></div>
								<div style="line-height:25px">&nbsp;</div>
								<div class="reg_btn">
									<input type="hidden" name="resetemail" id="resetemail" value="<?php echo $email; ?>">
									<input type="button" class="button" value="Submit" onclick="resetpassword();" tabindex="3" />
									<input type="button" class="button" value="Reset" onclick="resetclear();" tabindex="4" />
								</div>
							</form>
						</div>
					</div>
				</div>

				<div id="basic-modal-content1" style="display:none">
					<div class="pop_head">
						<div class="pop_logo"><img src="<?php echo $front_page . $directory ?>/images/pop_logo.png" width="153" height="46" alt="logo" /></div>
						<div class="pop_slog"><img src="<?php echo $front_page . $directory ?>/images/pop_slog.jpg" width="136" height="23" alt="slog" /></div>
					</div>
					<div class="pop_cont">
						<h3>Forgotten your password?</h3>
						<div class="poptxt" id="forget_password">
							<label>Enter email address :</label><input type="text" id="forget_email" />
							<span class="err_icons" id="forget_email_icon" style="display:none;float:right;"><img src="<?php echo base_path() . path_to_theme(); ?>/images/success_ico.png" width="32" height="32" alt="icon" /></span>
							<br />
						</div>
						<div class="forget_error" style="display:none"></div>
						<div class="popBut">
							<input type="button" class="button" value="Submit" onclick="forgetpassword();" />
							<input type="button" class="button simplemodal-close" value="Cancel" />
						</div>
					</div>
					<div style="display:none; color: #000000;padding:30px 0px 0px 50px" id="popFogotFinal">
						An Email has been sent to you with a link to reset password.<br><br>
						<div style='padding:5px 0px 0px 150px;float:left;margin-bottom:10px'>
							<input type='button' class='button simplemodal-close' value='OK'>
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
				<div style="clear:both;"></div>
			</div>
		</div>