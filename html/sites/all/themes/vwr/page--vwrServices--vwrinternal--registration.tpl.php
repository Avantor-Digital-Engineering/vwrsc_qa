<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>VWR Supplier Central</title>
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_path() . path_to_theme(); ?>/styles/common.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jquery.simplemodal.js"></script>
		<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/basic.js"></script>
		<script src="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/js/jquery-min-datepicker.js"></script>
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>
	<?php
	$style_dispaly = "display: block";
	$style_none = "display:none";
	$errors = array();
	if (isset($_POST['registration']) && ($_POST['registration'] == 'internal')) {
		if (count($_POST) > 0) {
			foreach ($_POST as $key => $value) {
				$_POST[$key] = trim($value);
			}
		}
		if (empty($_POST['vwrinternal_uid'])) {
			$errors['vwrinternal_uid'] = "User ID cannot be empty";
		}
		if (empty($_POST['vwrinternal_firstname'])) {
			$errors['vwrinternal_firstname'] = "First Name cannot be empty";
		} else {
			$fname_length = strlen($_POST['vwrinternal_firstname']);
			$match = preg_match("/^[a-zA-Z']+$/", $_POST['vwrinternal_firstname']);
			if ($match == 0) {
				$errors['vwrinternal_firstname'] = "First Name should be characters only";
			} else if ($fname_length > 25) {
				$errors['vwrinternal_firstname'] = "First Name can have maximum 25 characters only";
			}
		}
		if (empty($_POST['vwrinternal_lastname'])) {
			$errors['vwrinternal_lastname'] = "Last Name cannot be empty";
		} else {
			$fname_length = strlen($_POST['vwrinternal_lastname']);
			$match = preg_match("/^[a-zA-Z']+$/", $_POST['vwrinternal_lastname']);
			if ($match == 0) {
				$errors['vwrinternal_lastname'] = "Last Name should be characters";
			} else if ($fname_length > 25) {
				$errors['vwrinternal_lastname'] = "Lastname Name can have maximum 25 characters only";
			}
		}
		if (empty($_POST['vwrinternal_email'])) {
			$errors['vwrinternal_email'] = "Email address cannot be empty";
		} else {
			$email_pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
			$match_email = preg_match($email_pattern, $_POST['vwrinternal_email']);
			if ($match_email == 0) {
				$errors['vwrinternal_email'] = "Please Enter a valid email address";
			}
		}
		
	}elseif(isset($_REQUEST['urlparam'])){
		$errors = $_REQUEST['urlparam'];
	} 
	?>

	<body>
		<script>
			function onSubmit(token) {
				document.getElementById("reg_form").submit();
			}
		</script>
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
						<li>

						</li>
					</ul>
				</div>
			</div>
			<div class="content_container clearfix" id="internal_reg">
				<div class="bread_crumb"></div>
				<div class="welcome">
					<h3>VWR Internal User Registration</h3>
					<div class="reg_form">
						<?php $count = count($errors); ?>
						<form id="reg_form" method="post" action="<?php echo base_path();?>vwrServices/vwrinternalsave">
							<div class="error" id="error" style="<?php echo (!empty($count) ? $style_dispaly : $style_none); ?>">
								<?php
								if (!$count = '') {
									foreach ($errors as $key => $value) {
										echo $errors[$key] . '<br>';
									}
								}
								?>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">User ID :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" id="vwrinternal_uid" name="vwrinternal_uid" tabindex="1" />
								<span class="err_icons" id="internal_uid_icon" style="display:none"></span>
							</div>
							<div style="font-size:10px;color:red;padding-left:35px;padding-bottom:10px;">
								Please input your VWR User ID that is used for logging into VWR network (ex: John.Smith)
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">First Name :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" id="vwrinternal_firstname" name="vwrinternal_firstname" tabindex="1" />
								<span class="err_icons" id="internal_first_icon" style="display:none"></span>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Last Name :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" id="vwrinternal_lastname" tabindex="2" name="vwrinternal_lastname" />
								<span class="err_icons" id="internal_last_icon" style="display:none"></span>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Email :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" id="vwrinternal_email" name="vwrinternal_email" tabindex="3" />
								<span class="err_icons" id="internal_email_icon" style="display:none"></span>
							</div>
							

							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Region :</label>
							</div>
							<div class="reg_inpt">
								<label for="select"></label>
								<select name="internal_user_region" id="internal_user_region" tabindex="8">
									<option value="Select Region" selected="selected">Select Region</option>
									<?php
									$result = db_query("select * from {manage_regions} where region_status=1");
									foreach ($result as $record) {
									?>
									<option value="<?php echo $record->region_id; ?>"><?php echo $record->region_name; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="reg_btn">
								<div id="saveinternalloading" style="display:none">
									<img src="<?php echo base_path() . path_to_theme(); ?>/images/loading.gif">
								</div>
								<div id="saveinternalsave">
									<input type="hidden" name="registration" value="internal">
									<button class="button g-recaptcha" data-sitekey="<?php echo htmlspecialchars(variable_get('recaptcha_site_key', ''));?>" data-callback='onSubmit'>Submit</button>
									<!--input type="button" class="button" value="Submit" onclick="vwrinternalRegistration();" tabindex="6" /-->
									<input type="button" class="button" value="Reset" onclick="vwrinternalReset();" tabindex="7" />
									<a href="<?php echo base_path(); ?>"><input type="button" class="button" value="Cancel" tabindex="8" onclick="cancelForm();" /></a>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="login">
					<h3>Supplier Login</h3>
					<div class="log_form" id="log_form">
						<?php 
						if(isset($_SESSION['internal_status'])){
							$vwr_user_status = $_SESSION['internal_status'];
							$display = ($vwr_user_status != '') ? 'block' : 'none'; ?>
							<div class="log_error" id="error" style="display:<?php print $display; ?>;">
								<?php if ($vwr_user_status != '') {
									print $vwr_user_status;
								} ?>
							</div>
					<?php } ?>
						<?php unset($_SESSION['internal_status']); ?>
						<div>
							<div class="log_links"><a style="cursor:pointer;" id="select_type" class="basic" title="Setup New Account" alt="Setup New Account"><strong>Setup New Account</strong></a></div>
							<div class="log_links">
								<a href="<?php echo base_path(); ?>?q=moLogin"><input type="button" class="button" value="Login" name="op" id="edit-submit" /></a>
							</div>
							<div style="clear:both; height:0px;"></div>
						</div>
					</div>
				</div>
			</div>
			<div id="basic-modal-category" style="display:none;">
				<div class="pop_head">
					<div class="pop_logo"><img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/pop_logo.png" width="153" height="46" alt="logo" /></div>
					<div class="pop_slog"><img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/pop_slog.jpg" width="136" height="23" alt="slog" /></div>
				</div>
				<div class="pop_cont" id="cat_topic_container">
					<div align="center" style="text-align:center; margin:10px;">
						<div class="error status_msg" id="status_msg">&nbsp;</div>
						<img src="<?php echo base_path() . path_to_theme() . '/'; ?>images/loading.gif" width="50" height="50" alt="Loading..." />
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
				<div class="footer_links">
					<?php if (!$user->uid) { ?>
						<span style="padding-right: 100px;"><a href="https://sso.vwr.com/sso/login.jsp?j_app_name=SupplierCentral">VWR Associate Login</a></span>
					<?php } ?>
					<a href="<?php echo $legal_link; ?>" rel="noopener" target="_blank"><?php echo $legal_text; ?></a>
				</div>
				<?php
				$google_analytics = variable_get('google_analytics_UA');
				?>
				<script type="text/javascript">
					var _gaq = _gaq || [];
					_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
					_gaq.push(['_trackPageview', 'VWR Internal Registration']);

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
	</body>