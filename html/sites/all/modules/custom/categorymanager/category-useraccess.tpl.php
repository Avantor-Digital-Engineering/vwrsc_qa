	<style type="text/css">
		div.simplemodal-container {
			width: 620px !important;
			height: 540px !important;
			top: 18px !important;
		}

		.modalbox_users {
			width: 100%;
		}

		.select_vas {
			width: 100%;
			height: 170px;
			float: left;
			padding-left: 5px;
		}

		.select_supplier {
			width: 100%;
			height: 165px;
			float: left;
			padding-left: 5px;
		}

		.box_head {
			background-color: #005496;
			color: #FFFFFF;
			padding: 3px;
			width: 140px;
			font-weight: bold;
			margin: auto;
			#margin-bottom: -13px;
			text-align: center;
			font-size: 11px;
		}

		.left_list {
			width: 45%;
			float: left;
			margin: 20px 0;
		}

		.move_buttons {
			width: 10%;
			margin: 20px 0;
			#margin: 5px 0 4px 0px;
			float: left;
		}

		.right_list {
			width: 45%;
			float: left;
			margin: 20px 0;
		}

		.dropbox_list {
			border: 1px solid #999999;
			float: left;
			width: 235px;
			height: 115px;
			font-size: 12px;
		}

		.popBut1 {
			clear: both;
			#margin-bottom: -20px;
			padding-left: 12%;
		}

		.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset {
			float: none !important;
			text-align: center;
		}
	</style>
	<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox.js"></script>
	<div class="pop_cont cat_tpls modalbox_users">
		<h3>User Access Permissions</h3>
		<?php

		$currentregiontab = 0;
		$currentcatcaessquery = '';
		$currentregionnamequery = " LOWER(TRIM(sm.supplier_org_name)) as supplier_org_name ";
		if (isset($_COOKIE['currentregiontab'])) {
			$currentregiontab = $_COOKIE['currentregiontab'];
		}
		$supplierorg_namequery = ", sm.supplier_org_name ";
		$currentregionnamequery = " LOWER(TRIM(sm.supplier_org_name)) as supplier_org_name ";
		$cat_id = addslashes(strip_tags(trim($_POST['cat_id'])));
		$topic_id = addslashes(strip_tags(trim($_POST['topic_id'])));
		$level = addslashes(strip_tags(trim($_POST['level'])));
		$parent_id = addslashes(strip_tags(trim($_POST['parent_id'])));
		$parent_level = 'category_id';
		?>

		<div class="error status_msg" id="status_msg">
			<?php
			if (!$result_vas) {
				echo 'Sorry! no vas tier is associated in parent level <br/>';
			}
			if (!$result_supplier_org) {
				echo 'Sorry! no supplier org is associated in parent level';
			}
			?>
		</div>
		<form name="add_users">
			<div class="select_vas">
				<p class="box_head">Select Flags</p>
				<div class="left_list">
					<select name="vas_list1" id="vas_list1" class="dropbox_list" multiple="">
						<?php
						foreach ($result_vas as $vas_list) {
							
							$supplier_org_id = executestoredproceduregetsupplierorgids($vas_list->vas_tier_name);
							if (!in_array($vas_list->vas_tier_id, $selected_vas_values)) {
						?>
								<option value="<?php echo htmlspecialchars($vas_list->vas_tier_id); ?>_<?php echo htmlspecialchars($supplier_org_id); ?>"><?php echo htmlspecialchars($vas_list->vas_tier_name); ?></option>
						<?php
							}
						}
						?>
					</select>
				</div>
				<div class="move_buttons">
					&nbsp;<input type="button" class="ua_dropbox_button" value=">>" onClick="Move_Options_Values('vas_list1','vas_list2');" name="right" title="Move All Right" />&nbsp;<br>
					&nbsp;<input type="button" class="ua_dropbox_button" value=">" onClick="moveSelectedOptions_Related(this.form['vas_list1'],this.form['vas_list2'],'move_supplier_auto_right','<?php echo base_path(); ?>');" title="Move Right" />&nbsp;<br>
					&nbsp;<input type="button" class="ua_dropbox_button" value="<" onClick="moveSelectedOptions_Related(this.form['vas_list2'],this.form['vas_list1'],'move_supplier_auto_left','<?php echo base_path(); ?>');" title="Move Left" />&nbsp;<br>
					&nbsp;<input type="button" class="ua_dropbox_button" value="<<" onClick="Move_Options_Values('vas_list2','vas_list1');" title="Move All Left" />&nbsp;<br>
				</div>

				<div class="right_list">
					<select name="vas_list2" id="vas_list2" class="dropbox_list" multiple="">
						<?php foreach ($selected_vas_values as $vas_list_selected) {
							if ($vas_list_selected != '') {

								$supplier_org_id = executestoredproceduregetsupplierorgids(get_vas_name($vas_list_selected));
								
						?>
								<option value="<?php echo htmlspecialchars($vas_list_selected); ?>_<?php echo htmlspecialchars($supplier_org_id) ?>"><?php echo htmlspecialchars(get_vas_name($vas_list_selected)); ?></option>
						<?php }
						} ?>
					</select>
				</div>
			</div>
			<div class="clearboth"></div>
			<div class="select_supplier">
				<p class="box_head">Select Supplier Org</p>
				<div class="left_list">
					<select name="supplier_org_list1" id="supplier_org_list1" class="dropbox_list" multiple="multiple">
						<?php
						foreach ($result_supplier_org as $key => $supplier_list) {
							$region_short_name = "";
							if (!in_array(strtolower(trim($supplier_list->supplier_org_name)), $selected_supplier_names)) {
								if (($currentregiontab == $isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['region_id']) || ($isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['isglobal'])) {

									if (!$isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['isglobal']) {
										$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['region_id']];
									}

						?>
									<option value="<?php echo $supplier_list->supplier_org_id; ?>"><?php echo $supplierslist[$supplier_list->supplier_org_id]['supplier_org_name'] . $region_short_name; ?></option>
						<?php
								}
							}
						}
						?>
					</select>
				</div>
				<div class="move_buttons">
					&nbsp;<input type="button" class="ua_dropbox_button" value=">>" onClick="Move_Options_Values('supplier_org_list1','supplier_org_list2');" title="Move All Right" />&nbsp;<br>
					&nbsp;<input type="button" class="ua_dropbox_button" value=">" onClick="moveSelectedOptions(this.form['supplier_org_list1'],this.form['supplier_org_list2'])" title="Move Right" />&nbsp;<br>
					&nbsp;<input type="button" class="ua_dropbox_button" value="<" onClick="moveSelectedOptions_Related(this.form['supplier_org_list2'],this.form['supplier_org_list1'],'move_vas_auto_left','<?php echo base_path(); ?>');" title="Move Left" />&nbsp;<br>
					&nbsp;<input type="button" class="ua_dropbox_button" value="<<" onClick="Move_Options_Values('supplier_org_list2','supplier_org_list1');" title="Move All Left" />&nbsp;<br>
				</div>
				<div class="right_list">
					<select name="supplier_org_list2" id="supplier_org_list2" class="dropbox_list" multiple="multiple">
						<?php
						$suppliersarray = array();
						foreach ($selected_supplier_values as $supplier_list_selected) {
							$region_short_name = "";
							if ($supplier_list_selected != "") {
								if (($currentregiontab == $isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['region_id']) || ($isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['isglobal'])) {
									if (!$isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['isglobal']) {
										$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['region_id']];
									}
									$suppliersarray[$supplier_list_selected] = $supplierslist[$supplier_list_selected]['supplier_org_name'] . $region_short_name;
									natcasesort($suppliersarray);
								}
							}
						}
						foreach ($suppliersarray as $key => $val) { ?>
							<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php
						}
						?>
					</select>
				</div>
				<div id="temp_val" style="display:none;"></div>
			</div>
		</form>
		<div class="clearboth" style="height:18px;"></div>
		<div class="popBut1">
			<div class="clearboth"></div>
			<input type="button" class="button" value="Save" onclick="saveUserAccess(add_users.vas_list2 ,add_users.supplier_org_list2, '<?php echo htmlspecialchars($cat_id); ?>', '<?php echo htmlspecialchars($topic_id); ?>', '<?php echo htmlspecialchars($level); ?>');">
			<input type="button" class="button modalCloseImg simplemodal-close" value="Cancel" onClick="$('a.simplemodal-close').click();" />
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Useraccess']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>