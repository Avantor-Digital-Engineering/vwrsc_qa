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

		// Load Supplier Org related details
		changeSupplierOrg();

	});
</script>
	<?php
	$activeregions = array();
	$activeregionsprocess = array();
	$activeregions = getregioninfo();
	$activeregionsprocess = array_flip($activeregions);
	$isglobalsupplier = "SELECT supplier_org_id,IF(COUNT(region_id)>1,1,0) AS isglobal,region_id FROM vwr_supplier_org_regions WHERE STATUS=1 GROUP BY supplier_org_id";
	$dbisglobalsuppliers = db_query($isglobalsupplier);
	$isglobalsupplierslist = array();
	while ($row = $dbisglobalsuppliers->fetchAssoc()) {
		$isglobalsupplierslist[$row['supplier_org_id']] = $row;
	}

	$overallsuppliers = "SELECT so.supplier_org_id,so.supplier_org_name FROM vwr_supplier_organization AS so  ";
	$dbsuppliers = db_query($overallsuppliers);
	$supplierslist = array();
	while ($row = $dbsuppliers->fetchAssoc()) {
		$supplierslist[$row['supplier_org_id']] = $row['supplier_org_name'];
	}

	$confirm_edit_perm = has_user_access('confirm/update');
	$supplier_attr_perm = has_user_access('supplierAttr');
	if ($confirm_edit_perm || $supplier_attr_perm) {
	?>
		<div class="right_cont">
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<a href="<?php echo base_path(); ?>usermanager/useroverview">User Directory</a>
			</div>
			<div class="error" id="error-msg" style="display: none; clear: both;"></div>
			<div class="tab_container">
				<ul class="tabs">
					<li class="tab"> <a href="#tab1">User Info</a> </li>
					<?php if ($confirm_edit_perm) { ?>
						<li class="tab"> <a href="#tab2" id="sup_tab">Supplier Org</a> </li>
						<li class="tab"> <a href="#tab3" id="user_tab">User Type</a> </li>
						<li class="tab"> <a href="#tab4" id="email_settings">Email Settings</a> </li>
					<?php } ?>
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
				<?php
				if ($confirm_edit_perm && $data->status != 2) {
				?>
					<div style="float:right; margin-right: 20px; text-align:center;">
						<a href="#"><span id="user_status_update" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span></a><span id="status-msg"><?php echo $status_msg; ?></span>
					</div>
				<?php
				}
				?>
			</div>
			<div class="tab_container" style="border-bottom: none;">
				<div id="tab1" class="tab_content">
					<div class="reg_form">
						<div class="error" style="display:none"></div>
						<?php
						$text_attr = '';
						$select_attr = '';
						if (!$confirm_edit_perm) {
							$text_attr = 'readonly';
							$select_attr = 'disabled';
						}
						?>
						<div class="reg_labl"><span>*</span>
							<label>First Name :</label>
						</div>
						<input type="hidden" name="edit_user_id" id="edit_user_id" value="<?php print $data->uid; ?>" />
						<div class="reg_inpt">
							<input type="text" name="firstname" id="firstname" value="<?php print $data->firstname; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Last Name :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="lastname" id="lastname" value="<?php print $data->lastname; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Address 1 :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="address1" id="address1" value="<?php print $data->address1; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>&nbsp;&nbsp;</span>
							<label>Address 2 :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="address2" id="address2" value="<?php print $data->address2; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>City :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="city" id="city" value="<?php print $data->city; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>State :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="state" id="state" value="<?php print $data->state; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Zip :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="zipcode" id="zipcode" value="<?php print $data->zipcode; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Country :</label>
						</div>
						<div class="reg_inpt">
							<?php
							$display = '';
							if ($data->country == '') {
								$display = 'no';
							?>
								<select name="supplier_country" id="supplier_country" tabindex="8" <?php echo $select_attr; ?>>
									<option value="Select" selected="selected">Select Country</option>
								<?php } else { ?>
									<select name="supplier_country" id="supplier_country" tabindex="8" <?php echo $select_attr; ?>>
										<option value="Others" selected="selected">Others</option>
									<?php } ?>
									<?php
									$result = db_query("select country from {countries}");
									foreach ($result as $record) {
										$selected = '';

										if ($data->country == $record->country) {
											$selected = 'selected';
											$display = 'no';
										}
									?>
										<option value="<?php echo $record->country; ?>" <?php if ($selected == 'selected') { ?> selected="selected" <?php } ?>><?php echo $record->country; ?></option>

									<?php } ?>
									</select>
									<?php
									if ($display == 'no')
										$display = 'style="display:none;"';
									?>
									<input type="text" id="country-others" value="<?php echo $data->country; ?>" name="country-others" <?php echo $display; ?> placeholder="If Others..." <?php echo $text_attr; ?>>
						</div>
						<div class="reg_labl"><span>&nbsp;&nbsp;</span>
							<label> Phone :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="phone" id="phone" value="<?php if ($data->phone) print $data->phone; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Email :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="email" id="email" value="<?php print $data->mail; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Company :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="company" id="company" value="<?php print $data->company; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>&nbsp;&nbsp;</span>
							<label>Division :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="division" id="division" value="<?php print $data->division; ?>" <?php echo $text_attr; ?> />
						</div>
						<div class="reg_labl"><span>*</span>
							<label>Function :</label>
						</div>
						<div class="reg_inpt">
							<label for="select"></label>
							<select name="select_functional" id="select_functional" <?php echo $select_attr; ?>>
								<option>Select Function</option>
								<option <?php if ($data->supplier_function == 'Executive') { ?> selected="selected" <?php } ?> value="Executive">Executive</option>
								<option <?php if ($data->supplier_function == 'Sales') { ?> selected="selected" <?php } ?> value="Sales">Sales</option>
								<option <?php if ($data->supplier_function == 'Channel Manager') { ?> selected="selected" <?php } ?> value="Channel Manager">Channel Manager</option>
								<option <?php if ($data->supplier_function == 'Marketing') { ?> selected="selected" <?php } ?> value="Marketing">Marketing</option>
								<option <?php if ($data->supplier_function == 'Product Manager') { ?> selected="selected" <?php } ?> value="Product Manager">Product Manager</option>
								<option <?php if ($data->supplier_function == 'Operations') { ?> selected="selected" <?php } ?> value="Operations">Operations</option>
								<option <?php if ($data->supplier_function == 'Other') { ?> selected="selected" <?php } ?> value="Other">Other</option>
							</select>
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

						<div class="reg_labl"><span>&nbsp;&nbsp;</span>
							<label>Creation Date :</label>
						</div>
						<div class="reg_inpt">
							<input type="text" name="created_date" id="created_date" value="<?php print date("m/d/Y", $data->created); ?>" readonly="true" />
						</div>
						<div class="reg_labl"><span>&nbsp;&nbsp;</span>
							<label>Last Log in Date :</label>
						</div>
						<?php $accessdate = $data->access ? date("m/d/Y", $data->access) : "Never"; ?>
						<div class="reg_inpt">
							<input type="text" name="last_login" id="last_login" value="<?php print $accessdate; ?>" readonly="true" />
						</div>

						<?php
						if ($supplier_attr_perm) {
							if ($suplier_attr[0] != '' || $suplier_attr[0] != 0) { ?>
								<div id="supplier-attr-container">
									<?php
									foreach ($suplier_attr as $suplier_attributes) {
									?>
										<div class="reg_labl"><span>&nbsp;&nbsp;</span>
											<input type="text" name="supplier_attr_name[]" value="<?php print $suplier_attributes['attribute_name']; ?>" class="supplier_label" maxlength="60" />
										</div>
										<div class="reg_inpt">
											<input type="text" name="supplier_attr_val[]" value="<?php print $suplier_attributes['attribute_value']; ?>" maxlength="60" />
										</div>

									<?php
									} ?>
								</div>
								<div class="reg_labl"><span>&nbsp;&nbsp;</span>
									<label>&nbsp;</label>
								</div>
								<div class="reg_inpt">
									<a style="margin-left: 0px; cursor: pointer;" class="add-supp-attr">Add More</a>
								</div>

							<?php } else { ?>
								<div id="supplier-attr-container"></div>
								<div class="reg_labl"><span>&nbsp;&nbsp;</span>
									<label>&nbsp;</label>
								</div>
								<div class="reg_inpt">
									<a style="margin-left: 0px; cursor: pointer;" class="add-supp-attr">Add Supplier Attributes</a>
								</div>
						<?php  }
						}
						?>
						<div class="reg_btn">
							<input type="submit" class="button" value="Confirm" name="user-info" id="user-info" />
						</div>
					</div>
				</div>
				<div id="tab2" class="tab_content">
					<div class="sel_sup">
						<label style="line-height: 24px;">Select Supplier Org</label>
						<select name="supplier_org" id="supplier_org">
							<?php
							if (!$data->supplier_org_name) {
							?>
								<option value="0">Select</option>
							<?php
							}
							foreach ($suplier_data as $supliers_data) {
								$region_short_name = "";
								if (!$isglobalsupplierslist[$supliers_data->supplier_org_id]['isglobal']) {

									$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supliers_data->supplier_org_id]['region_id']];
								}
							?>
								<option value="<?php print htmlspecialchars($supliers_data->supplier_org_id); ?>" <?php if ($supliers_data->supplier_org_id == $data->supplier_org_name) { ?>selected="selected" <?php } ?>><?php print htmlspecialchars($supliers_data->supplier_org_name) . htmlspecialchars($region_short_name); ?></option>
							<?php
							}
							?>
						</select>
					</div>
					<div id="supplier-info"></div>
				</div>
				<div id="tab3" class="tab_content">
					<div class="sel_sup">
						<?php
						$role = db_query('SELECT r.name FROM {users_roles} ur LEFT JOIN {role} r ON r.rid=ur.rid WHERE ur.uid=' . base64_decode(arg(2)) . ' LIMIT 1')->fetchField(0);
						?>
						<div class="selbox">
							<input id="vwr_user_type_1" type="radio" name="vwr_user_type" value="5" <?php if ($role == 'vwr internal') { ?> checked="checked" <?php } ?> style="float:left;" />
							<label style="padding: 3px 0px; display: inline-block !important;" for="vwr_user_type_1">VWR Internal</label>
							<br style="clear:both;" />
							<br />
							<input id="vwr_user_type_2" type="radio" name="vwr_user_type" value="6" <?php if ($role == 'supplier') { ?> checked="checked" <?php } ?> style="float:left;" />
							<label style="padding: 3px 0px; display: inline-block !important;" for="vwr_user_type_2">VWR Supplier</label>
						</div>
						<br style="clear:both;" />
						<div class="conf_btn">
							<input type="submit" class="button" value="Confirm" name="user_type" id="user_type" />
						</div>
					</div>

				</div>
				<div id="tab4" class="tab_content">
					<div class="error status_msg" id="status_msg">&nbsp;</div>
					<div style="width: 335px;display:none; margin-top:0px;" id="email_preferences_status" class="success">Email Preferences Saved</div>
					<?php
					$emailpreferences = db_query("select * from {supplier_notifications} where user_id=:userids", [':userids' => $userids]);
					$emailpreferencescount = db_query("select count(*) from {supplier_notifications} where user_id=:userids", [':userids' => $userids])->fetchColumn();
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
												<input type="button" onclick="takeuserback()" value="Cancel" class="button simplemodal-close">
												<span style="display:none;margin-left:5px" id="dashboard_loader">
													<a title="Close" class="modalCloseImg simplemodal-close"></a></span>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="right_cont" style="line-height:25px;">You are not authorized to access this page!
		</div>
	<?php } ?>