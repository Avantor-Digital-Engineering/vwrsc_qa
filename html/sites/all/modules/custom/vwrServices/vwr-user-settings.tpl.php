<?php if (!is_vwr_user_role()) {
		$displaying = 'none';
		$tabdisplay = "block";
		$modal_height = '400px';
	} else {
		$displaying = 'block';
		$tabdisplay = "none";
		$modal_height = '600px';
	} ?>
	<style type="text/css">
		div.simplemodal-container {
			height: <?php echo $modal_height; ?> !important;
		}
	</style>
	<?php
	$user_password = db_query("SELECT uf.email_notify FROM {users} AS u LEFT JOIN {users_info} AS uf ON u.uid = uf.uid WHERE u.uid=:uid", [':uid' => $user->uid])->fetchColumn();
	?>
	<div id="change_password">
		<div id="suppiler_settings" style="display:<?php echo $tabdisplay; ?>">
			<div class="reg_labl" style="width:165px; line-height:16px;"><label>*<a href="#" onclick="change_pass();myaccountvalidate();">Change Password</a></label></div>
			<div style="clear:both"></div>
			<div class="reg_labl" id="region_selection" style="width:165px; line-height:16px;"><label>*<a href="#" onclick="region_select();">Region Selection</a></label></div>
			<div style="clear:both"></div>
		</div>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div style="width: 335px;display:none; margin-top:0px;" id="region_status" class="success">Region Settings Saved</div>
		<div class="error" id="myaccount_error" style="width:335px; margin-top:0px;display:none;"></div>
		<div class="poptxt1">
			<!--div id="password_settings" style="display:<1?php echo $displaying; ?>">
				<1?php if (!is_vwr_user_role()) { ?> 

					<!--div class="reg_labl" style="width:165px; line-height:16px;"><span>*</span>
						<label>Old Password :</label>
					</div>
					<input type="password" id="myaccount_old_password" /><br>
					<div style="clear:both"></div>

					<div class="reg_labl" style="width:165px;line-height:16px;"><span>*</span>
						<label>New Password :</label>
					</div>
					<input type="password" id="myaccount_password" /><br>
					<div style="clear:both"></div>

					<div class="reg_labl" style="width:165px;line-height:16px;"><span>*</span>
						<label>Confirm Password :</label>
					</div>
					<input type="password" id="myaccount_confirm" />
					<div style="clear:both"></div-->
					<!--div class="reg_labl" style="width:165px;line-height:16px;"><span>*</span>
						<label>Confirm Mail :</label>
					</div>
					<input type="text" id="mail_confirm" value="<1?php echo $user->mail;?>"/>
					<div style="clear:both"></div-->
				<!--?php } ?-->
				<!--div class="reg_labl" style="width:165px;line-height:16px;">
					<label>Email notification :</label>
				</div>

				<div style="width:150px; vertical-align:top; float:left;">
					<input type="checkbox" name="email_nofity" id="email_nofity" value="1" <1?php echo $user_password ? 'checked' : ''; ?> onClick="notificationUpdate();" /> Disable
				</div-->

				<!--div style="clear:both"></div>
				<1?php if (!is_vwr_user_role()) { ?>
					<div class="popBut" style="float: left;margin-left: 140px;padding: 10px 10px 10px 18px;">
						<input type="button" class="button" value="Confirm" onclick="myaccountvalidate();" />
						<input type="button" class="button simplemodal-close" value="Cancel" />
					</div>
				<1?php } ?>
			</div-->
			<br />
			<div class="region_check" style="height:180px;display:<?php echo $displaying; ?>;">
				<div class="reg_labl" style="width:165px;line-height:16px;">
					<label style="margin-left:-27px;width:165px;"><b>View Region Content</b>&nbsp;&nbsp;:
						<span style="float:right;">*</span></label>
				</div>

				<div style="width:125px; vertical-align:top; float:left;">
					<?php
					if ($user->uid) {
						$usertabpreferences = array();
						$regionlist = get_all_regions();
						$userregions = getuserregions();
						$usertabpreferences = getusertabpreference();
					?>

						<?php
						if ($regionlist) {

							foreach ($regionlist as $regions) {
								$regioncheckedattribute = '';
								$userdefaultcheckedattribute = '';
								if (in_array($regions->region_id, $userregions)) {
									$regioncheckedattribute = 'checked';
								}
								if (!empty($usertabpreferences)) {
									if ($usertabpreferences[0] == $regions->region_id) {
										$userdefaultcheckedattribute = 'checked';
									}
								}
						?>


								<input type="checkbox" name="userregionboxes[]" value="<?php echo $regions->region_id; ?>" <?php echo $regioncheckedattribute; ?>>
								<?php echo $regions->region_name; ?>

					<?php
							}
						}
					}
					?>
				</div>
				<div style="clear:both"></div>
				<br />
				<div class="reg_labl" style="line-height:16px;width:165px;">
					<label style="margin-left:36px;width:auto;"><b>Default Tab&nbsp;:</b></label>
				</div>
				<div style="width:125px; vertical-align:top; float:left;">
					<?php

					$regionlistpref = get_all_regions();
					$userregionspref = getuserregions();
					$usertabpreferencesdefault = getusertabpreference();
					foreach ($regionlistpref as $regionstabpreferences) {
						$regioncheckedattribute = '';
						$userdefaultcheckedattribute = '';
						if (in_array($regionstabpreferences->region_id, $userregionspref)) {
							$regioncheckedattribute = 'checked';
						}
						if (!empty($usertabpreferencesdefault)) {
							if ($usertabpreferencesdefault[0] == $regionstabpreferences->region_id) {
								$userdefaultcheckedattribute = 'checked';
							}
						}
					?>


						<input type="radio" name="defaulttab" value="<?php echo $regionstabpreferences->region_id; ?>" <?php echo $userdefaultcheckedattribute; ?>>
						<?php echo $regionstabpreferences->region_name; ?>

					<?php

					}
					?>
				</div>
				<div style="clear:both"></div>
				<br />
				<div class="setting-confirm-btn">
					<input type="button" onclick="regionSettings()" value="Confirm" class="button">
					<input type="button" onclick="" value="Cancel" class="button simplemodal-close"><span style="display:none;margin-left:5px" id="dashboard_loader"><a title="Close" class="modalCloseImg simplemodal-close"></a></span>
				</div>
			</div>



		</div>
	</div>
	<div id="changePasswordFinal" style="display:none">
		<div style="width:350px;padding-left:40px; #padding-left:0px; padding-top:54px;color:#4B4A4A;font-weight:bold;">Your password has been successfully changed.</div>
		<div style="clear:both;line-height:25px;"></div>
		<br /> <br />
		<div style="padding-left:180px;#padding-left:100px;"><input type="button" class="button simplemodal-close" value="Close" /></div>
	</div>

	<?php if (is_vwr_user_role()) { ?>
		<div id="email_preferences" style="display:block">

			<div id="suppiler_settings" style="display:block">
				<div class="reg_labl" id="region_selection" style="width:165px; line-height:16px;"><label>
						<a href="#" style="color:#004D8F;font-size: 14px;text-decoration: underline;" onclick="emailpreferencesselect()">Email Preferences</a></label></div>
				<div style="clear:both"></div>
			</div>

			<div class="error status_msg" id="status_msg">&nbsp;</div>
			<span style="width:360px;display:block; margin-top:0px;margin-left:30px;font-family:verdana;color:#4b4a4a">Please select the notifications you would like to receive:</span>
			<div style="width: 335px;display:none; margin-top:0px;" id="email_preferences_status" class="success">Email Preferences Saved</div>
			<div class="error" id="myaccount_error" style="width:335px; margin-top:0px;display:none;"></div>
			<div class="poptxt1">

				<br />
				<div class="email_preferences_check" style="height:180px;display:block;width:500px">
					<div class="reg_labl" style="width:330px;line-height:16px;">
						<label style="margin-left:37px;width:330px;"><b>NA News and Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b>
						</label>
					</div>
					<?php
					$supplieruseremailnotificationscount = db_query("select count(*) from {supplier_notifications} where user_id=:uid", [':uid' => $user->uid])->fetchColumn();;
					$emailpreferences = db_query("select * from {supplier_notifications} where user_id=:uid", [':uid' => $user->uid]);
					foreach ($emailpreferences as $emf) {
						$nanews = $emf->na_news;
						$naquality = $emf->na_quality;
						$nasupply = $emf->na_supply;
						$eunews = $emf->eu_news;
					}
					?>
					<div style="vertical-align:top; float:left;">
						<input type="radio" name="na_news" value="1" style="margin-left:-35px" <?php if (($nanews == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
						<input type="radio" name="na_news" value="0" <?php if (($nanews == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
					</div>
					<div style="clear:both"></div><br />

					<div class="reg_labl" style="line-height:16px;width:165px;">
						<label style="margin-left:36px;width:330px;"><b>NA Quality Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
					</div>
					<div style="vertical-align:top; float:left;">
						<input type="radio" name="na_quality" value="1" style="margin-left:130px" <?php if (($naquality == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
						<input type="radio" name="na_quality" value="0" <?php if (($naquality == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
					</div>
					<div style="clear:both"></div><br />


					<div class="reg_labl" style="line-height:16px;width:165px;">
						<label style="margin-left:36px;width:330px;"><b>NA Supply Chain Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
					</div>
					<div style="vertical-align:top; float:left;">
						<input type="radio" name="na_supply" value="1" style="margin-left:130px" <?php if (($nasupply == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
						<input type="radio" name="na_supply" value="0" <?php if (($nasupply == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
					</div>
					<div style="clear:both"></div><br />


					<div class="reg_labl" style="line-height:16px;width:165px;">
						<label style="margin-left:36px;width:330px;"><b>EU News and Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
					</div>
					<div style="vertical-align:top; float:left;">
						<input type="radio" name="eu_news" value="1" style="margin-left:131px" <?php if (($eunews == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
						<input type="radio" name="eu_news" value="0" <?php if (($eunews == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
					</div>
					<div style="clear:both"></div><br />


					<div class="setting-confirm-btn">
						<input type="button" onclick="emailpreferencessettings()" value="Save" class="button">
						<input type="button" onclick="" value="Cancel" class="button simplemodal-close"><span style="display:none;margin-left:5px" id="dashboard_loader"><a title="Close" class="modalCloseImg simplemodal-close"></a></span>
					</div>
				</div>



			</div>
		</div>

	<?php } ?>




	<?php if (!is_vwr_user_role()) {
		$suppplier_org_id = db_query("SELECT so.supplier_org_id FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid = :uid", [':uid' => $user->uid])->fetchColumn();
		$supplierregionscount = db_query("select count(*) from {supplier_org_regions} where supplier_org_id=:suppplier_org_id and status=1", [':suppplier_org_id' => $suppplier_org_id])->fetchColumn();
		if ($supplierregionscount == 1) {
			$supplierregionvalue = db_query("select region_id from {supplier_org_regions} where supplier_org_id=:suppplier_org_id and status=1", [':suppplier_org_id' => $suppplier_org_id])->fetchColumn();
		}
		$supplieruseremailnotificationscount = db_query("select count(*) from {supplier_notifications} where user_id=:uid", [':uid' => $user->uid])->fetchColumn();;
		$emailpreferences = db_query("select * from {supplier_notifications} where user_id=:uid", [':uid' => $user->uid]);
		foreach ($emailpreferences as $emf) {
			$nanews = $emf->na_news;
			$naquality = $emf->na_quality;
			$nasupply = $emf->na_supply;
			$eunews = $emf->eu_news;
		}
	?>
		<div id="email_preferences" style="display:block">

			<div id="suppiler_settings" style="display:block">
				<div class="reg_labl" id="region_selection" style="width:165px; line-height:16px;"><label>
						<a href="#" style="color:#004D8F;font-size: 14px;text-decoration: underline;" onclick="emailpreferencesselect()">Email Preferences</a></label></div>
				<div style="clear:both"></div>
			</div>

			<div class="error status_msg" id="status_msg">&nbsp;</div>
			<span style="width:360px;display:block; margin-top:0px;margin-left:30px;font-family:verdana;color:#4b4a4a">Please select the notifications you would like to receive:</span>
			<div style="width: 335px;display:none; margin-top:0px;" id="email_preferences_status" class="success">Email Preferences Saved</div>
			<div class="error" id="myaccount_error" style="width:335px; margin-top:0px;display:none;"></div>
			<div class="poptxt1">

				<br />
				<?php if ($supplierregionscount == 2) { ?>

					<div class="email_preferences_check" style="height:180px;display:block;width:500px">
						<div class="reg_labl" style="width:330px;line-height:16px;">
							<label style="margin-left:37px;width:330px;"><b>NA News and Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b>
							</label>
						</div>

						<div style="vertical-align:top; float:left;">
							<input type="radio" name="na_news" value="1" style="margin-left:-35px" <?php if (($nanews == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
							<input type="radio" name="na_news" value="0" <?php if (($nanews == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
						</div>
						<div style="clear:both"></div><br />

						<div class="reg_labl" style="line-height:16px;width:165px;">
							<label style="margin-left:36px;width:330px;"><b>NA Quality Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
						</div>
						<div style="vertical-align:top; float:left;">
							<input type="radio" name="na_quality" value="1" style="margin-left:130px" <?php if (($naquality == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
							<input type="radio" name="na_quality" value="0" <?php if (($naquality == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
						</div>
						<div style="clear:both"></div><br />


						<div class="reg_labl" style="line-height:16px;width:165px;">
							<label style="margin-left:36px;width:330px;"><b>NA Supply Chain Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
						</div>
						<div style="vertical-align:top; float:left;">
							<input type="radio" name="na_supply" value="1" style="margin-left:130px" <?php if (($nasupply == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
							<input type="radio" name="na_supply" value="0" <?php if (($nasupply == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
						</div>
						<div style="clear:both"></div><br />
						<div class="reg_labl" style="line-height:16px;width:165px;">
							<label style="margin-left:36px;width:330px;"><b>EU News and Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
						</div>
						<div style="vertical-align:top; float:left;">
							<input type="radio" name="eu_news" value="1" style="margin-left:131px" <?php if (($eunews == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
							<input type="radio" name="eu_news" value="0" <?php if (($eunews == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
						</div>
						<div style="clear:both"></div><br />
					<?php } ?>


					<?php if ($supplierregionscount == 1) { ?>
						<?php if ($supplierregionvalue == 1) { ?>
							<div class="email_preferences_check" style="height:180px;display:block;width:500px">
								<div class="reg_labl" style="width:330px;line-height:16px;">
									<label style="margin-left:37px;width:330px;"><b>NA News and Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b>
									</label>
								</div>

								<div style="vertical-align:top; float:left;">
									<input type="radio" name="na_news" value="1" style="margin-left:-35px" <?php if (($nanews == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
									<input type="radio" name="na_news" value="0" <?php if (($nanews == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
								</div>
								<div style="clear:both"></div><br />

								<div class="reg_labl" style="line-height:16px;width:165px;">
									<label style="margin-left:36px;width:330px;"><b>NA Quality Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
								</div>
								<div style="vertical-align:top; float:left;">
									<input type="radio" name="na_quality" value="1" style="margin-left:130px" <?php if (($naquality == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
									<input type="radio" name="na_quality" value="0" <?php if (($naquality == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
								</div>
								<div style="clear:both"></div><br />


								<div class="reg_labl" style="line-height:16px;width:165px;">
									<label style="margin-left:36px;width:330px;"><b>NA Supply Chain Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
								</div>
								<div style="vertical-align:top; float:left;">
									<input type="radio" name="na_supply" value="1" style="margin-left:130px" <?php if (($nasupply == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
									<input type="radio" name="na_supply" value="0" <?php if (($nasupply == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
								</div>
								<div style="clear:both"></div><br />
							<?php } ?>
							<?php if ($supplierregionvalue == 2) { ?>
								<div class="reg_labl" style="line-height:16px;width:165px;">
									<label style="margin-left:36px;width:330px;"><b>EU News and Notifications:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
								</div>
								<div style="vertical-align:top; float:left;">
									<input type="radio" name="eu_news" value="1" style="margin-left:131px" <?php if (($eunews == 1) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>Yes
									<input type="radio" name="eu_news" value="0" <?php if (($eunews == 0) && ($supplieruseremailnotificationscount == 1)) { ?> checked <?php } ?>>NO
								</div>
								<div style="clear:both"></div><br />
							<?php } ?>
						<?php } ?>

						<div class="setting-confirm-btn">
							<input type="button" onclick="emailpreferencessettings()" value="Save" class="button">
							<input type="button" onclick="" value="Cancel" class="button simplemodal-close"><span style="display:none;margin-left:5px" id="dashboard_loader"><a title="Close" class="modalCloseImg simplemodal-close"></a></span>
						</div>
							</div>



					</div>
			</div>

		<?php } ?>


		<div id="changePasswordFinal" style="display:none">
			<div style="width:350px;padding-left:40px; #padding-left:0px; padding-top:54px;color:#4B4A4A;font-weight:bold;">Your password has been successfully changed.</div>
			<div style="clear:both;line-height:25px;"></div>
			<br /> <br />
			<div style="padding-left:180px;#padding-left:100px;"><input type="button" class="button simplemodal-close" value="Close" /></div>
		</div>
		<?php
		$google_analytics = variable_get('google_analytics_UA', '');
		?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
			_gaq.push(['_trackPageview', 'Change Password']);

			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();
		</script>