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
		<!--script src="https://www.google.com/recaptcha/api.js" async defer></script-->

	</head>
	<?php
	$style_dispaly = "display: block";
	$style_none = "display:none";
	$errors = array();
	if (isset($_POST['registration']) && ($_POST['registration'] == 'supplier')) {
		if (count($_POST) > 0) {
			foreach ($_POST as $key => $value) {
				$_POST[$key] = trim($value);
			}
		}
		if (empty($_POST['supplier_first'])) {
			$errors['supplier_first'] = "First Name cannot be empty";
		} else {
			$fname_length = strlen($_POST['supplier_first']);
			$match = preg_match("/^[a-zA-Z']+$/", $_POST['supplier_first']);
			if ($match == 0) {
				$errors['supplier_first'] = "First Name should be characters only";
			} else if ($fname_length > 25) {
				$errors['supplier_first'] = "First Name can have maximum 25 characters only";
			}
		}
		if (empty($_POST['supplier_last'])) {
			$errors['supplier_last'] = "Last Name cannot be empty";
		} else {
			$fname_length = strlen($_POST['supplier_last']);
			$match = preg_match("/^[a-zA-Z']+$/", $_POST['supplier_last']);
			if ($match == 0) {
				$errors['supplier_last'] = "Last Name should be characters";
			} else if ($fname_length > 25) {
				$errors['supplier_last'] = "Lastname Name can have maximum 25 characters only";
			}
		}
		if (empty($_POST['supplier_addr1'])) {
			$errors['supplier_addr1'] = "Address cannot be empty";
		}
		if (empty($_POST['supplier_city'])) {
			$errors['supplier_city'] = "City cannot be empty";
		} else {
			$match_city = preg_match("/([a-zA-Z|0-9])/", $_POST['supplier_city']);
			if ($match_city == 0) {
				$errors['supplier_city'] = "City name can contain only characters or letters";
			}
		}
		if (empty($_POST['supplier_state'])) {
			$errors['supplier_state'] = "State cannot be empty";
		} else {
			$match_state = preg_match("/([a-zA-Z|0-9])/", $_POST['supplier_state']);
			if ($match_state == 0) {
				$errors['supplier_state'] = "state name can contain only characters orletters";
			}
		}
		if (empty($_POST['supplier_zipcode'])) {
			$errors['supplier_zipcode'] = "Zipcode cannot be empty";
		} else {
			$zip_length = strlen($_POST['supplier_zipcode']);
			$match_zipcode = preg_match("/^[-\s0-9]+$/", $_POST['supplier_zipcode']);
			if ($match_zipcode == 0) {
				$errors['supplier_zipcode'] = "Zipcode can contain only numerics";
			} else if ($zip_length < 4) {
				$errors['supplier_zipcode'] = "Zipcode Minimum should have 4 digits";
			} else if ($zip_length > 6) {
				$errors['supplier_zipcode'] = "Zipcode Maximum should have 6 digits";
			}
		}
		if ($_POST['supplier_country'] == 'Select Country') {
			$errors['supplier_country'] = "Please select country";
		}

		if (empty($_POST['supplier_email'])) {
			$errors['supplier_email'] = "Email address cannot be empty";
		} else {
			$email_pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
			$match_email = preg_match($email_pattern, $_POST['supplier_email']);
			if ($match_email == 0) {
				$errors['supplier_email'] = "Please Enter a valid email address";
			}
		}

		if (empty($_POST['supplier_password'])) {
			$errors['supplier_password'] = "Password cannot be empty";
		}
		if (empty($_POST['password_confirm'])) {
			$errors['password_confirm'] = "Confirm Password cannot be empty";
		} else if ($_POST['password_confirm'] != $_POST['supplier_password']) {
			$errors['password_confirm'] = "Please Enter same as password";
		}
		if (empty($_POST['supplier_company'])) {
			$errors['supplier_company'] = "Company cannot be empty";
		}

		if ($_POST['supplier_region'] == 'Select Region') {
			$errors['supplier_region'] = "Please select region";
		}
	}else if(isset($_REQUEST['urlparam'])){
		$errors = $_REQUEST['urlparam'];
	} 
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
						<li>

						</li>
					</ul>
				</div>
			</div>
			<script>
			   function onSubmit(token) {
				 document.getElementById("reg_form").submit();
			   }
			</script>
			<div class="content_container clearfix" id="supply_reg">
				<div class="bread_crumb"></div>
				<div class="welcome">
					<h3>Supplier Registration</h3>
					<div class="reg_form">
						<?php $count = count($errors); ?>
						<form id="reg_form" method="post" action="<?php echo base_path()?>vwrServices/suppliersave">
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
								<label style="display:inline-block;">First Name :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_first" id="supplier_first" tabindex="1"/>
								<span class="err_icons" id="supplier_first_icon" style="display:none"><img src="<?php echo base_path() . path_to_theme(); ?>/images/success_ico.png" width="32" height="32" alt="icon" /></span>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Last Name :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_last" id="supplier_last" tabindex="2"/>
								<span class="err_icons" id="supplier_last_icon" style="display:none"><img src="<?php echo base_path() . path_to_theme(); ?>/images/error_ico.png" width="32" height="32" alt="icon" /></span>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Address 1 :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_addr1" id="supplier_addr1" tabindex="3"/>
							</div>
							<div class="reg_labl"><span>&nbsp;&nbsp;</span>
								<label style="display:inline-block;">Address 2 :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_addr2" id="supplier_addr2" tabindex="4"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">City :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_city" id="supplier_city" tabindex="5"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">State/Province :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_state" id="supplier_state" tabindex="6"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Postal Code :</label>
							</div>


							<div class="reg_inpt" id="supplier_zipcode">
								<input type="text" id="supplier_zip" name="supplier_zipcode" tabindex="7"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Country :</label>
							</div>
							<div class="reg_inpt">
								<select name="supplier_country" id="supplier_country" tabindex="8">
									<option value="Select" selected="selected">Select Country</option>
									<?php
									$result = db_query("select country from {countries}");
									foreach ($result as $record) {
									?>
										<option value="<?php echo $record->country; ?>"><?php echo $record->country; ?></option>

									<?php } ?>
								</select>
								<input type="text" id="country-others" name="country-others" style="display:none">
							</div>


							<div class="reg_labl"><span>&nbsp;&nbsp;</span>
								<label style="display:inline-block;"> Phone :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" name="supplier_phone" id="supplier_phone" tabindex="9"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Email :</label>
							</div>
							<div class="reg_inpt">
								<input type="email" id="supplier_email" name="supplier_email" tabindex="10"/>
								<span class="err_icons" id="supplier_email_icon" style="display:none"><img src="<?php echo base_path() . path_to_theme(); ?>/images/success_ico.png" width="32" height="32" alt="icon" /></span>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Password :</label>
							</div>
							<div class="reg_inpt">
								<input type="password" name="supplier_password" id="supplier_password" tabindex="11"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Confirm Password :</label>
							</div>
							<div class="reg_inpt">
								<input type="password" name="password_confirm" id="password_confirm" tabindex="12"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Company :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" id="supplier_company" name="supplier_company" tabindex="13"/>
							</div>
							<div class="reg_labl"><span>&nbsp;&nbsp;</span>
								<label style="display:inline-block;">Division :</label>
							</div>
							<div class="reg_inpt">
								<input type="text" id="supplier_division" name="supplier_division" tabindex="14"/>
							</div>
							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Function :</label>
							</div>
							<div class="reg_inpt">
								<label for="select"></label>
								<select  id="supplier_function" name="supplier_function" tabindex="15">
									<option selected="selected" value="Select function">Select Function</option>
									<option>Executive</option>
									<option>Sales</option>
									<option>Channel Manager</option>
									<option>Marketing</option>
									<option>Product Manager</option>
									<option>Operations</option>
									<option>Other</option>
								</select>
							</div>


							<div class="reg_labl"><span>*</span>
								<label style="display:inline-block;">Region :</label>
							</div>
							<div class="reg_inpt">
								<label for="select"></label>
								<select id="supplier_region" name="supplier_region" tabindex="8">
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
								<input type="hidden" id="userroletype" value="supplier"/>
								<input type="hidden" name="registration" value="supplier">
								<div id="savesupplierloading" style="display:none">
									<img src="<?php echo base_path() . path_to_theme(); ?>/images/loading.gif">
								</div>

	
    
								<div id="savesuppliersave">
										<!-- Google reCAPTCHA version2 box -->
									<!--div class="g-recaptcha" data-sitekey="6LdyUBopAAAAAAs6mHJlbmw5KXomrYJwrzcnIdqj"></div-->
										<!-- Submit button -->
									<!--input type="submit" name="submit" value="SUBMIT"-->
									<!--input type="button" class="button" value="Submit" onclick="supplierRegistration();" onclick='supplierRegistration();'/-->
									<button class="button g-recaptcha" data-sitekey="<?php echo htmlspecialchars(variable_get('recaptcha_site_key', ''));?>" data-callback='onSubmit'>Submit</button>
									<input type="button" class="button" value="Reset" onclick="supplierReset();" />
									<input type="button" class="button" value="Cancel" tabindex="8" onclick="cancelForm()" />
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
						<?php unset($_SESSION['internal_status']);
						} ?>
						<!--?php unset($_SESSION['internal_status']); ?-->
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
				<div class="copy">&copy;VWR International, LLC. All rights reserved.</div>
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
					_gaq.push(['_trackPageview', 'Supplier Registration']);

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