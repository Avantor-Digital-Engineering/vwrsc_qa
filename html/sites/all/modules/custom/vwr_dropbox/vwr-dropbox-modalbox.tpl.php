<?php
	$modalbox_type = addslashes(htmlspecialchars(trim($_POST['modalbox_type'])));
	$selected_values = addslashes(htmlspecialchars(trim($_POST['selected_values'])));
	$cookieprocessregions = '';
	$currentregionquery = "";
	$supplierorgnamequery = " so.supplier_org_name ";
	if (isset($_COOKIE['cookieregion_name'])) {
		$cookieprocessregions = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));
		$supplierorgnamequery = " so.supplier_org_name as supplier_org_name ";
	}
	$cookieregionsprocess = array();
	if (!empty($cookieprocessregions)) {
		$cookieregionsprocess =	explode(',', $cookieprocessregions);
	}
	$activeregions = array();
	$activeregionsprocess = array();
	$activeregions = getregioninfo();
	$activeregionsprocess = array_flip($activeregions);

	$isglobalsupplierslist = executestoreprocedureis_global_supplier();
	$supplierslist = executestoreproceduresupplierslist();
	?>
	<!-- Add Users Modal Box Part - Start -->
	<?php if ($modalbox_type == "add_users") {
		$result_vas = db_query("SELECT vas_tier_id, vas_tier_name FROM {vas_tier} WHERE deleted=0 GROUP BY vas_tier_name ASC");

		$result_supplier_org = db_query('SELECT v.vendor_id as supplier_org_id,
			' . $supplierorgnamequery . ' FROM {vendor} as v LEFT JOIN {supplier_organization}
			as so ON so.supplier_org_id = v.supplier_org_id WHERE v.deleted=0 AND 
			so.deleted=0 GROUP BY so.supplier_org_id ASC ORDER BY so.supplier_org_name');

		$split_selected_value = explode("_", $selected_values);
		$selected_vas_values = explode(",", $split_selected_value[0]);
		$selected_supplier_values = explode(",", $split_selected_value[1]);
		$selected_supplier_values = array_unique($selected_supplier_values);
		$selected_right_values = $selected_supplier_values;
		$selected_supplier_names = array();
		foreach ($selected_right_values as $selected_right) {
			if ($selected_right != "") {
				$selected_supplier_names[] = strtolower(trim($supplierslist[$selected_right]['supplier_org_name']));
			}
		}

		$vendors = get_vas_vendors(addslashes(strip_tags(trim($_COOKIE['cookieregion_name']))));
	?>
		<div class="modalbox_users">
			<h3>Add Users</h3>
			<form name="add_users" action="">
				<div class="select_vas">
					<p class="box_head">Select Flags</p>
					<div class="left_list">
						<select name="vas_list1" id="vas_list1" class="dropbox_list" multiple="">
							<?php foreach ($result_vas as $vas_list) {
								$supplier_org_id = $vendors[$vas_list->vas_tier_id];
								if (!in_array($vas_list->vas_tier_id, $selected_vas_values)) {
							?>
									<option value="<?php echo htmlspecialchars($vas_list->vas_tier_id); ?>_<?php echo htmlspecialchars($supplier_org_id); ?>"><?php echo htmlspecialchars($vas_list->vas_tier_name); ?></option>
							<?php }
							}
							?>
						</select>
					</div>
					<div class="move_buttons">
						&nbsp;<input type="button" class="dropbox_button" value=">>" onClick="Move_Options_Values('vas_list1','vas_list2');" name="right" title="Move All Right" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value=">" onClick="moveSelectedOptions_Related(this.form['vas_list1'],this.form['vas_list2'],'move_supplier_auto_right','<?php echo base_path(); ?>');" title="Move Right" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<" onClick="moveSelectedOptions_Related(this.form['vas_list2'],this.form['vas_list1'],'move_supplier_auto_left','<?php echo base_path(); ?>');" title="Move Left" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<<" onClick="Move_Options_Values('vas_list2','vas_list1');" title="Move All Left" />&nbsp;<br>
					</div>
					<div class="right_list">
						<select name="vas_list2" id="vas_list2" class="dropbox_list" multiple="">
							<?php foreach ($selected_vas_values as $vas_list_selected) {
								//Select supplier org related to vas tier
								if ($vas_list_selected != "") {									

									$supplier_org_id = $vendors[$vas_list->vas_tier_id];
							?>
									<option value="<?php echo htmlspecialchars($vas_list_selected); ?>_<?php echo htmlspecialchars($supplier_org_id); ?>"><?php echo htmlspecialchars(get_vas_name($vas_list_selected)); ?></option>
							<?php
								}
							} ?>
						</select>
					</div>
				</div>
				<div class="select_supplier">
					<p class="box_head">Select Supplier Org</p>
					<div class="left_list">
						<select name="supplier_org_list1" id="supplier_org_list1" class="dropbox_list" multiple="multiple">
							<?php foreach ($result_supplier_org as $supplier_list) {
								$region_short_name = "";
								if (!in_array(strtolower(trim($supplier_list->supplier_org_name)), $selected_supplier_names)) {
									if ((in_array($isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['region_id'], $cookieregionsprocess)) || ($isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['isglobal'])) {

										if (!$isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['isglobal']) {
											$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supplierslist[$supplier_list->supplier_org_id]['supplier_org_id']]['region_id']];
										}
							?>
										<option value="<?php echo htmlspecialchars($supplier_list->supplier_org_id); ?>"><?php echo htmlspecialchars($supplierslist[$supplier_list->supplier_org_id]['supplier_org_name']) . htmlspecialchars($region_short_name); ?></option>
							<?php }
								}
							} ?>
						</select>
					</div>
					<div class="move_buttons">
						&nbsp;<input type="button" class="dropbox_button" value=">>" onClick="Move_Options_Values('supplier_org_list1','supplier_org_list2');" title="Move All Right" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value=">" onClick="moveSelectedOptions(this.form['supplier_org_list1'],this.form['supplier_org_list2'])" title="Move Right" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<" onClick="moveSelectedOptions_Related(this.form['supplier_org_list2'],this.form['supplier_org_list1'],'move_vas_auto_left','<?php echo base_path(); ?>');" title="Move Left" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<<" onClick="Move_Options_Values('supplier_org_list2','supplier_org_list1');" title="Move All Left" />&nbsp;<br>
					</div>
					<div class="right_list">
						<select name="supplier_org_list2" id="supplier_org_list2" class="dropbox_list" multiple="multiple">
							<?php foreach ($selected_supplier_values as $supplier_list_selected) {
								$region_short_name = "";
								if ($supplier_list_selected != "") {
									if ((in_array($isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['region_id'], $cookieregionsprocess)) || ($isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['isglobal'])) {
										if (!$isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['isglobal']) {
											$region_short_name = '--' . $activeregionsprocess[$isglobalsupplierslist[$supplierslist[$supplier_list_selected]['supplier_org_id']]['region_id']];
										}
							?>
										<option value="<?php echo htmlspecialchars($supplier_list_selected); ?>"><?php echo htmlspecialchars($supplierslist[$supplier_list_selected]['supplier_org_name']) . htmlspecialchars($region_short_name); ?></option>
							<?php }
								}
							} ?>
						</select>
					</div>
					<div id="temp_val" style="display:none;"></div>
					<?php echo base_path(); ?>
				</div>
			</form>
			<div class="add_users_submit">
				<input type="button" class="dropbox_button" value="Save" id="save_button" style="" onclick="Save_AddUsers(add_users.vas_list2 ,add_users.supplier_org_list2);">&nbsp;
				<input type="button" class="dropbox_button simplemodal-close" id="cancel_button" value="Cancel" onClick="$('a.simplemodal-close').click();">
			</div>
		</div>
		<!-- Add Users Modal Box Part - End -->

		<!-- Add Owners Modal Box Part - Start -->
	<?php } elseif ($modalbox_type == "add_NA owners") {
		$northamericaowners = db_query("select permission_id from {permission_list_internal} where permission_title='Dropbox Owners for NA Region'")->fetchColumn();
		$result_user = db_query('SELECT u.uid, ui.firstname, ui.lastname FROM {users} as u, 
			{users_info} as ui, {users_roles} as ur,{user_permission_internal} AS upi 
			WHERE u.status=1 AND u.uid=ui.uid AND upi.uid=u.uid and
			u.uid=ur.uid AND ur.rid=5 and upi.permission_id=:northamericaowners	
			ORDER BY ui.firstname ASC', array(':northamericaowners' => $northamericaowners));

		$selected_user_values = explode(",", $selected_values);
	?>

		<div class="modalbox_users">
			<h3>Add Owners</h3><br /><br />
			<form name="add_owners" action="">
				<div class="select_vas">
					<div class="left_list">
						<select name="users_list1" id="users_list1" class="dropbox_list" multiple="">
							<?php foreach ($result_user as $user_list) {


								if (!in_array($user_list->uid, $selected_user_values)) {
							?>
									<option value="<?php echo htmlspecialchars($user_list->uid); ?>"><?php echo htmlspecialchars($user_list->firstname) . " " . htmlspecialchars($user_list->lastname); ?></option>
							<?php }
							} ?>
						</select>
					</div>
					<div class="move_buttons">
						&nbsp;<input type="button" class="dropbox_button" value=">>" onClick="moveAllOptions(this.form['users_list1'],this.form['users_list2']);" name="right" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value=">" onClick="moveSelectedOptions_Original(this.form['users_list1'],this.form['users_list2'])" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<" onClick="moveSelectedOptions_Original(this.form['users_list2'],this.form['users_list1'])" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<<" onClick="moveAllOptions(this.form['users_list2'],this.form['users_list1']);" />&nbsp;<br>
					</div>
					<div class="right_list">
						<select name="users_list2" id="users_list2" class="dropbox_list" multiple="">
							<?php
							foreach ($selected_user_values as $user_list_selected) {
								if ($user_list_selected != "") {
									$auth_name = get_author_name($user_list_selected);
									if (trim($auth_name)) {
							?>
										<option value="<?php echo htmlspecialchars($user_list_selected); ?>"><?php echo htmlspecialchars($auth_name); ?></option>
							<?php
									}
								}
							}
							?>
						</select>
					</div>
				</div>
			</form>
			<div class="add_users_submit">
				<input type="button" class="dropbox_button" value="Confirm" style="height:25px;width:70px;" onclick="Save_Add_NAOwners(add_owners.users_list2);">
				<input type="button" class="dropbox_button simplemodal-close" id="cancel_button_new" value="Cancel" style="">
			</div>
		</div>
		<!-- Add Users Modal Box Part - End -->

		<!-- Add Pages Modal Box Part - Start -->
	<?php } elseif ($modalbox_type == "add_EU owners") {
		$euowners = db_query("select permission_id from {permission_list_internal} where permission_title='Dropbox Owners for EU Region'")->fetchColumn();
		$result_user = db_query('SELECT u.uid, ui.firstname, ui.lastname FROM {users} as u, 
			{users_info} as ui, {users_roles} as ur,{user_permission_internal} AS upi 
			WHERE u.status=1 AND u.uid=ui.uid AND upi.uid=u.uid and
			u.uid=ur.uid AND ur.rid=5 and upi.permission_id=:euowners		
			ORDER BY ui.firstname ASC', array(':euowners' => $euowners));
		$selected_user_values = explode(",", $selected_values);
	?>

		<div class="modalbox_users">
			<h3>Add Owners</h3><br /><br />
			<form name="add_owners" action="">
				<div class="select_vas">
					<div class="left_list">
						<select name="users_list1" id="users_list1" class="dropbox_list" multiple="">
							<?php foreach ($result_user as $user_list) {
								if (!in_array($user_list->uid, $selected_user_values)) {
							?>
									<option value="<?php echo htmlspecialchars($user_list->uid); ?>"><?php echo htmlspecialchars($user_list->firstname) . " " . htmlspecialchars($user_list->lastname); ?></option>
							<?php }
							} ?>
						</select>
					</div>
					<div class="move_buttons">
						&nbsp;<input type="button" class="dropbox_button" value=">>" onClick="moveAllOptions(this.form['users_list1'],this.form['users_list2']);" name="right" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value=">" onClick="moveSelectedOptions_Original(this.form['users_list1'],this.form['users_list2'])" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<" onClick="moveSelectedOptions_Original(this.form['users_list2'],this.form['users_list1'])" />&nbsp;<br>
						&nbsp;<input type="button" class="dropbox_button" value="<<" onClick="moveAllOptions(this.form['users_list2'],this.form['users_list1']);" />&nbsp;<br>
					</div>
					<div class="right_list">
						<select name="users_list2" id="users_list2" class="dropbox_list" multiple="">
							<?php
							foreach ($selected_user_values as $user_list_selected) {
								if ($user_list_selected != "") {
									$auth_name = get_author_name($user_list_selected);
									if (trim($auth_name)) {
							?>
										<option value="<?php echo htmlspecialchars($user_list_selected); ?>"><?php echo htmlspecialchars($auth_name); ?></option>
							<?php
									}
								}
							}
							?>
						</select>
					</div>
				</div>
			</form>
			<div class="add_users_submit">
				<input type="button" class="dropbox_button" value="Confirm" style="height:25px;width:70px;" onclick="Save_Add_EUOwners(add_owners.users_list2);">
				<input type="button" class="dropbox_button simplemodal-close" id="cancel_button_new" value="Cancel" style="">
			</div>
		</div>
		<!-- Add Users Modal Box Part - End -->

		<!-- Add Pages Modal Box Part - Start -->
	<?php } elseif ($modalbox_type == "add_pages") {

		$selected_pages_values = explode(",", $selected_values);

		foreach ($selected_pages_values as $values) {
			$page_values[$values] = trim($values);
		}
	?>
		<div class="modalbox_users">
			<h3>Add Pages to Drop Box</h3><br /><br />
			<form name="add_owners" action="">
				<div class="tree">
					<?php
					$timestamp = strtotime(date("d-m-Y"));
					$currentregionslist = addslashes(strip_tags(trim($_COOKIE['cookieregion_name'])));
					//$currentregion = " AND category_regions.region_id in (:currentregionslist)";
					$currentregion = " AND category_regions.region_id in ($currentregionslist)";	

					$result = db_query('SELECT category.*,vwrmr.region_shortname,vwrmr.region_id FROM {category} as category join {category_regions}
		as category_regions on category.category_id=category_regions.category_id ' . $currentregion . '
		INNER JOIN {manage_regions} as vwrmr on vwrmr.region_id=category_regions.region_id and vwrmr.region_status=1 
		WHERE category.category_status=1 AND category_regions.status=1 and category.expiry_date >= :expiry_dt	
		ORDER BY category.category_name ASC', array(':expiry_dt' => $timestamp));

					if ($result) {
						$temp = 0;
						foreach ($result as $record) {
					?>
							<div class="parent">
								<span class="operator">+</span>
								<input type="checkbox" id="c_id_<?php echo htmlspecialchars($cat_id = $record->category_id) . "_regionid_" . htmlspecialchars($record->region_id); ?>" class="tree_checkbox" name="grand_parent" value="<?php echo htmlspecialchars($record->category_name) . " " . htmlspecialchars($record->region_shortname); ?>" <?php if (in_array('c_id_' . $record->category_id . "_regionid_" . $record->region_id, $page_values)) {
																																																																																			?> checked <?php } ?> />
								<?php $cat_id = $record->category_id;
								echo '&nbsp;' . htmlspecialchars($record->category_name) . " " . htmlspecialchars($record->region_shortname);
								?>

								<div class="child">
									<?php


									$cat_topics = db_query("SELECT t.topic_id,t.topic_name,mr.region_shortname,mr.region_id FROM 
											{topic} as t INNER JOIN {content_regions} as cr
											on t.topic_id=cr.content_id 
											and cr.region_id in(:region_id)   and cr.content_type in (1)
											INNER JOIN {manage_regions} as mr
											on mr.region_id=cr.region_id 
											AND t.category_id = :cat_id AND 
											t.parent_topic_id=0 
											AND 
											t.topic_status=1 
											and 
											mr.region_status=1 
											and 
											cr.status=1 
											AND 
											t.expiry_date>=:expiry_dt
											group by t.topic_id,cr.region_id 
											ORDER BY t.topic_name ASC", array(':region_id' => $record->region_id, ':cat_id' => $cat_id, ':expiry_dt' => $timestamp));
									if ($cat_topics) {
										foreach ($cat_topics as $topic) { ?>
											<div class="parent">
												<span class="operator">+</span>
												<input type="checkbox" id="t_id_<?php echo htmlspecialchars($topic_id = $topic->topic_id) . "_regionid_" . htmlspecialchars($topic->region_id); ?>" class="tree_checkbox" name="parent" value="<?php echo htmlspecialchars($topic->topic_name) . " " . htmlspecialchars($topic->region_shortname); ?>" <?php if (in_array('t_id_' . $topic->topic_id . "_regionid_" . $topic->region_id, $page_values)) { ?> checked <?php } ?> />
												<?php $topic_id = $topic->topic_id;
												echo '&nbsp;&nbsp;' . htmlspecialchars($topic->topic_name) . " " . htmlspecialchars($topic->region_shortname);
												?>

												<div class="child">
													<?php
													$sub_topics = db_query('SELECT t.topic_id,t.topic_name,mr.region_shortname,mr.region_id FROM 
											{topic} as t INNER JOIN {content_regions} as cr
											on t.topic_id=cr.content_id 
											and cr.region_id in(:region_id)   and cr.content_type in (2)
											INNER JOIN vwr_manage_regions as mr
											on mr.region_id=cr.region_id 
											AND t.category_id = :cat_id AND 
											t.parent_topic_id=:topic_id 
											AND 
											t.topic_status=1 
											and 
											mr.region_status=1 
											and 
											cr.status=1 
											AND 
											t.expiry_date>=:ts
											group by t.topic_id,cr.region_id 
											ORDER BY t.topic_name ASC', array(':region_id' => $topic->region_id, ':cat_id' => $cat_id, ':topic_id' => $topic_id, ':ts' => $timestamp));

													if ($sub_topics) {
														foreach ($sub_topics as $subtopic) { ?>
															<div class="parent">
																<span class="operator">+</span>
																<input type="checkbox" id="t_id_<?php echo htmlspecialchars($subtopic_id = $subtopic->topic_id) . "_regionid_" . htmlspecialchars($subtopic->region_id); ?>" class="tree_checkbox" name="parent_1" value="<?php echo htmlspecialchars($subtopic->topic_name) . " " . htmlspecialchars($subtopic->region_shortname); ?>" <?php if (in_array('t_id_' . $subtopic->topic_id . "_regionid_" . $subtopic->region_id, $page_values)) { ?> checked <?php } ?> /><?php $subtopic_id = $subtopic->topic_id;
																																																																																																																										echo '&nbsp;&nbsp;' . htmlspecialchars($subtopic->topic_name) . " " . htmlspecialchars($subtopic->region_shortname); ?>
																<div class="child">
																	<?php

																	$internal_topics = db_query('SELECT t.topic_id,t.topic_name,mr.region_shortname,mr.region_id FROM 
											{topic} as t INNER JOIN {content_regions} as cr
											on t.topic_id=cr.content_id  
											and cr.region_id in(:region_id)   and cr.content_type in (3)
											INNER JOIN vwr_manage_regions as mr
											on mr.region_id=cr.region_id 
											AND t.category_id = :cat_id AND 
											t.parent_topic_id=:subtopic_id 
											AND 
											t.topic_status=1 
											and 
											mr.region_status=1 
											and 
											cr.status=1 
											AND 
											t.expiry_date>=:ts
											group by t.topic_id,cr.region_id 
											ORDER BY t.topic_name ASC', array(':region_id' => $subtopic->region_id, ':cat_id' => $cat_id, ':subtopic_id' => $subtopic_id, ':ts' => $timestamp)); 


																	
																	if ($internal_topics) {
																		$i = 1;
																		foreach ($internal_topics as $internaltopic) { ?>

																			<p style="height:20px;">
																				<input type="checkbox" class="tree_checkbox" id="t_id_<?php echo htmlspecialchars($internaltopic_id = $internaltopic->topic_id) . "_regionid_" . htmlspecialchars($internaltopic->region_id); ?>" name="child" value="<?php echo htmlspecialchars($internaltopic->topic_name) . " " . htmlspecialchars($internaltopic->region_shortname); ?>" <?php if (in_array('t_id_' . $internaltopic->topic_id . "_regionid_" . $internaltopic->region_id, $page_values)) { ?> checked <?php } ?> />
																				<?php $internaltopic_id = $internaltopic->topic_id;
																				echo '&nbsp;' . htmlspecialchars($internaltopic->topic_name) . " " . htmlspecialchars($internaltopic->region_shortname); ?>
																			</p>
																	<?php $i++;
																		}
																	} ?>
																</div>
															</div>

													<?php }
													} ?>
												</div>

											</div>
									<?php }
									} ?>

								</div>
							</div>

					<?php }
					} ?>
				</div>
			</form>
			<div class="add_users_submit">
				<input type="button" class="dropbox_button" value="Confirm" style="height:25px;width:70px;" onclick="submitData();">
				<input type="button" class="dropbox_button simplemodal-close" id="cancel_button_new" value="Cancel" style="">
			</div>
		</div>
	<?php } ?>
	<!-- Add Users Modal Box Part - End -->
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