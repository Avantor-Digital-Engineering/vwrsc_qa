<script type="text/javascript">
	$(document).ready(function() {
		var sanitizeHTML = function(str) {
			var temp = document.createElement('div');
			temp.textContent = str;
			return temp.innerHTML;
		};
		$(".tab_content").hide();
		$("ul.tabs li:first").addClass("active").show();
		$(".tab_content:first").show();

		$("ul.tabs li").click(function() {
			$("ul.tabs li").removeClass("active");
			$(this).addClass("active");
			$(".tab_content").hide();
			var activeTab = $(this).find("a").attr("href");
			$(sanitizeHTML(activeTab)).fadeIn();
			return false;
		});

	});
</script>
	<?php
	$confirm_edit_perm = has_user_access('confirm/update');
	?>
	<?php if ($confirm_edit_perm) { ?>
		<div class="right_cont">
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<a href="<?php echo base_path(); ?>usermanager/useroverview">User Directory</a>
			</div>
			<div class="success" style="display: none; clear:both;">Successfully Updated!</div>
			<div class="error" id="error-msg" style="display: none; clear:both;"></div>
			<div class="tab_container">
				<ul class="tabs">
					<li class="tab"> <a href="#tab1">User Info</a> </li>
					<li class="tab"> <a href="#tab2" id="user_tab">User Type</a> </li>
					<li class="tab"> <a href="#tab3" id="user_permission">User Permission</a> </li>
					<li class="tab"> <a href="#tab4" id="email_settings">Email Settings</a> </li>
				</ul>
				<?php
				$status_class = '';
				$status_msg = '';
				if ($data->status == 0) {
					$status_class = "inActiveButton";
					$status_msg = 'Deactive';
				} else if ($data->status == 1) {
					$status_class = "activeButton";
					$status_msg = 'Active';
				}
				?>
				<?php if ($data->status != 2) { ?>
					<div style="float:right; margin-right: 20px; text-align: center;">
						<a href="#"><span id="user_status_update" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span></a><span id="status-msg"><?php echo $status_msg; ?></span>
					</div>
				<?php } ?>
			</div>
			<div class="tab_container" style="border-bottom: none;">
				<div id="tab1" class="tab_content">
					<div class="reg_form">
						<div class="error" style="display:none"></div>
						<div class="reg_labl"><span>*</span>
							<label>First Name :</label>
						</div>
						<input type="hidden" name="edit_user_id" id="edit_user_id" value="<?php print $data->uid; ?>" />
						<div class="reg_inpt">
							<input type="text" name="firstname" id="firstname" value="<?php print $data->firstname; ?>" />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Last Name :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="lastname" id="lastname" value="<?php print $data->lastname; ?>" />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Email :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="email" id="email" value="<?php print $data->mail; ?>" />
						</div>

						<?php
						$userids = base64_decode(arg(2));
						$regionids = db_query("SELECT regionid FROM {newsupplier_regions} WHERE userid = :userids", [':userids' => $userids])->fetchField();
						?>
						<div class="reg_labl"><span>*</span>
							<label>Region :</label>
						</div>
						<div class="reg_inpt">
							<label for="select"></label>

							<select name="select_region" id="select_region" <?php echo $select_attr; ?>>
								<option value="Select Region" selected="selected">Select Region</option>
								<?php
								$result = db_query("select * from {manage_regions} where region_status=1");

								foreach ($result as $record) {

								?>
									<option <?php if ($record->region_id == $regionids) { ?> selected="selected" <?php } ?> value="<?php echo $record->region_id; ?>"><?php echo $record->region_name; ?></option>

								<?php } ?>
							</select>
						</div>
						<div class="reg_btn">
							<input type="submit" class="button" value="Confirm" name="internal_user-info" id="internal_user-info" />
						</div>
					</div>
				</div>
				<div id="tab2" class="tab_content">
					<div class="sel_sup">
						<?php
						$role = db_query('SELECT r.name FROM {users_roles} ur LEFT JOIN {role} r ON r.rid=ur.rid WHERE ur.uid=' . base64_decode(arg(2)) . ' LIMIT 1')->fetchField(0);
						?>
						<div class="selbox">
							<input id="vwr_user_type_1" type="radio" name="vwr_user_type_internal" value="5" <?php if ($role == 'vwr internal') { ?> checked="checked" <?php } ?> style="float:left;" />
							<label style="padding: 3px 0px; display: inline-block !important;" for="vwr_user_type_1">VWR Internal</label>
							<br style="clear:both;" />
							<br />
							<input id="vwr_user_type_2" type="radio" name="vwr_user_type_internal" value="6" <?php if ($role == 'supplier') { ?> checked="checked" <?php } ?> style="float:left;" />
							<label style="padding: 3px 0px; display: inline-block !important;" for="vwr_user_type_2">VWR Supplier</label>
						</div>
						<br style="clear:both;" />
						<br />
						<div class="conf_btn">
							<input type="submit" class="button" value="Confirm" name="internal_user_type" id="internal_user_type" />
						</div>
					</div>
				</div>
				<div id="tab3" class="tab_content">
					<div class="sel_sup">

						<div><strong>User Permissions</strong></div><br />

						<div class="selbox">

							<?php
							foreach ($permission_results as $permission_result) {
								$checkStatus = '';
								if ($permission_result['permission_category_id'] == "1") {
									$checkStatus = in_array($permission_result['permission_id'], $user_permission[0]);
							?>
									<input type="checkbox" style="float:left;" name="user_perm_<?php echo $permission_result['permission_id']; ?>" id="user_perm_<?php echo $permission_result['permission_id']; ?>" value="<?php echo $permission_result['permission_id']; ?>" <?php if ($checkStatus) { ?> checked="checked" <?php } ?> />
									<label style="padding: 3px 0px; display: inline-block !important;" for="user_perm_<?php echo $permission_result['permission_id']; ?>"><?php echo $permission_result['permission_title']; ?></label>
									<br style="clear: both;" />
									<br />
							<?php }
							}
							?>
						</div>
						<br style="clear: both;" />
						<div><strong>Page Permissions</strong></div><br />
						<div class="selbox">
							<?php
							foreach ($permission_results as $permission_result) {
								$checkStatus = '';
								if ($permission_result['permission_category_id'] == "2") {
									$checkStatus = in_array($permission_result['permission_id'], $user_permission[0]);
							?>
									<input type="checkbox" style="float:left;" name="user_perm_<?php echo $permission_result['permission_id']; ?>" id="user_perm_<?php echo $permission_result['permission_id']; ?>" value="<?php echo $permission_result['permission_id']; ?>" <?php if ($checkStatus) { ?> checked="checked" <?php } ?> />
									<label style="padding: 3px 0px; display: inline-block !important;" for="user_perm_<?php echo $permission_result['permission_id']; ?>"><?php echo $permission_result['permission_title']; ?></label>
									<br style="clear: both;" />
									<br />
							<?php }
							} ?>
						</div>

						<div class="conf_btn">
							<input type="submit" class="button" value="Confirm" name="user_perm" id="user_perm" />
						</div>
					</div>
				</div>
				<div id="tab4" class="tab_content">
					<div class="error status_msg" id="status_msg">&nbsp;</div>
					<div style="width: 335px;display:none; margin-top:0px;" id="email_preferences_status" class="success">Email Preferences Saved</div>
					<?php

					$emailpreferencescount = db_query("select count(*) from {supplier_notifications} where user_id=:userids", [':userids' => $userids])->fetchColumn();;
					$emailpreferences = db_query("select * from {supplier_notifications} where user_id=:userids", [':userids' => $userids]);
					foreach ($emailpreferences as $emf) {
						$nanews = $emf->na_news;
						$nasupply = $emf->na_supply;
						$eunews = $emf->eu_news;
						$naquality = $emf->na_quality;
					}

					?>
					<div class="reg_labl" style="line-height:16px;width:165px;">
						<div class="email_preferences_check" style="height:180px;display:block;width:500px">
							<div class="reg_labl" style="width:330px;line-height:16px;margin-left:29px">
								<label style="margin-left:1px;width:330px;"><b>NA News and Notifications:&nbsp;&nbsp;
										<span style="color:red;">*</span></b>
								</label>
							</div>
							<div style="vertical-align:top; float:left;">
								<input type="radio" name="na_news" value="1" style="margin-left:-33px" <?php if (($nanews == '1') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>Yes
								<input type="radio" name="na_news" value="0" <?php if (($nanews == '0') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>NO
							</div>

							<div class="reg_labl" style="line-height:16px;width:165px;">
								<div class="email_preferences_check" style="height:180px;display:block;width:500px">
									<div class="reg_labl" style="width:330px;line-height:16px;">
										<label style="margin-left:1px;width:330px;"><b>NA Quality Notifications:&nbsp;&nbsp;
												<span style="color:red;">*</span></b>
										</label>
									</div>
									<div style="vertical-align:top; float:left;">
										<input type="radio" name="na_quality" value="1" style="margin-left:-35px" <?php if (($naquality == '1') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>Yes
										<input type="radio" name="na_quality" value="0" <?php if (($naquality == '0') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>NO
									</div>

									<div class="email_preferences_check" style="height:180px;display:block;width:500px">
										<div class="reg_labl" style="width:330px;line-height:16px;">
											<label style="margin-left:1px;width:330px;"><b>NA Supply Chain Notifications:&nbsp;&nbsp;
													<span style="color:red;">*</span></b>
											</label>
										</div>
										<div style="vertical-align:top; float:left;">
											<input type="radio" name="na_supply" value="1" style="margin-left:-35px" <?php if (($nasupply == '1') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>Yes
											<input type="radio" name="na_supply" value="0" <?php if (($nasupply == '0') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>NO
										</div>
										<div style="clear:both"></div>

										<div class="email_preferences_check" style="height:180px;display:block;width:500px">
											<div class="reg_labl" style="width:330px;line-height:16px;">
												<label style="margin-left:1px;width:330px;"><b>EU News and Notifications:&nbsp;&nbsp;
														<span style="color:red;">*</span></b>
												</label>
											</div>

											<div style="vertical-align:top; float:left;">
												<input type="radio" name="eu_news" value="1" style="margin-left:-35px" <?php if (($eunews == '1') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>Yes
												<input type="radio" name="eu_news" value="0" <?php if (($eunews == '0') && ($emailpreferencescount == '1')) { ?> checked <?php } else { ?> <?php } ?>>NO
											</div>
											<div style="clear:both"></div>
											<div class="setting-confirm-btn">
												<input type="button" onclick="useremailpreferencessettings()" value="Save" class="button">
												<input type="button" onclick="takeuserback()" value="Cancel" class="button simplemodal-close"><span style="display:none;margin-left:5px" id="dashboard_loader"><a title="Close" class="modalCloseImg simplemodal-close"></a></span>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } else { ?>
				<div class="right_cont">You are not authorized to access this page!
				</div>
			<?php } ?>