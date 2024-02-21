	<script type="text/javascript">
		$(document).ready(function() {
			$(".sortTitle").click(function() {
				var params = {
					sortBy: $(this).find('div').attr("id"),
					direction: $(this).find('div').attr("class"),
					dropbox: $.trim($('#ticket_search_dbox').val()),
					status: $.trim($('#ticket_search_status').val())
				};
				window.location.href = '?' + $.param(params);
			});
		});
	</script>
	<style type="text/css">
		.sort_tbl {
			width: 5px;
			#width: 6px;
		}

		.w75 input {
			width: 40px;
		}

		.table_container .brdr_right {
			border-right: 1px solid #CFCFC8 !important;
		}

		.table_container table .title_minwidth {
			min-width: 100px;
			#padding-left: 6%;
		}

		.topalignsort {
			position: relative;
			top: 5px;
			#top: -8px;
		}

		.topalignsort2 {
			position: relative;
			top: -3px;
			#top: -16px;
		}

		.fieldreltop {
			position: relative;
			#top: 4px;
		}
	</style>
	<?php
	global $user;
	$regioncookieval = '';
	$regionquery = "";
	$regiondropboxlistquery = "";
	if (!isset($_COOKIE['cookieregion_name'])) {

		$regioncookieval = addslashes(htmlspecialchars(trim($_SESSION['region_name'])));
		$regionquery = "INNER JOIN vwr_dropbox_regions AS vwrdr ON vwrdr.dropbox_id=vwrdf.dbox_id AND vwrdr.region_id in ($regioncookieval) INNER JOIN vwr_manage_regions as vwrmr on vwrmr.region_id=vwrdr.region_id and vwrmr.region_status=1 ";
		$regiondropboxlistquery = "INNER JOIN vwr_dropbox_regions AS vwrdr ON vwrdr.dropbox_id=d.id AND vwrdr.region_id in ($regioncookieval) INNER JOIN vwr_manage_regions as vwrmr on vwrmr.region_id=vwrdr.region_id and vwrmr.region_status=1 ";
		$reggroupby = " group by id ";
	} else {
		$regioncookieval = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));
		$regionquery = "INNER JOIN vwr_dropbox_regions AS vwrdr ON vwrdr.dropbox_id=vwrdf.dbox_id AND vwrdr.region_id in ($regioncookieval) INNER JOIN vwr_manage_regions as vwrmr on vwrmr.region_id=vwrdr.region_id and vwrmr.region_status=1 ";
		$regiondropboxlistquery = "INNER JOIN vwr_dropbox_regions AS vwrdr ON vwrdr.dropbox_id=d.id AND vwrdr.region_id in ($regioncookieval) INNER JOIN vwr_manage_regions as vwrmr on vwrmr.region_id=vwrdr.region_id and vwrmr.region_status=1 ";
		$reggroupby = " group by id ";
	}
	$_SESSION['google_analytics_page_name'] = "Submission Overview Page";
	$uid = $user->uid;
	$dropbox_selected = $status_selected = $region_selected = 0;
	if (isset($_REQUEST['dropbox']) && is_numeric($_REQUEST['dropbox'])) {
		$dropbox_selected = addslashes(htmlspecialchars(trim($_REQUEST['dropbox'])));
	}
	if (isset($_REQUEST['status']) && is_numeric($_REQUEST['status'])) {
		$status_selected = addslashes(htmlspecialchars(trim($_REQUEST['status'])));
	}
	if (isset($_REQUEST['regions']) && is_numeric($_REQUEST['regions'])) {
		$region_selected =  addslashes(htmlspecialchars(trim($_REQUEST['regions'])));
	}

	$arg_2 = '';
	if (is_numeric(arg(2))) {
		$arg_2 = arg(2);
		if ($arg_2 != 0 && !is_valid_supplierorg_user($arg_2)) {
			$arg_2 = '';
		}
	}

	$sortField = addslashes(strip_tags(strtolower(trim($_REQUEST['sortBy']))));
	$sortOrder = addslashes(strip_tags(trim($_REQUEST['direction'])));
	$idOrder = 'Desc';
	$firstnameOrder = 'Desc';
	$supplierOrgOrder = 'Asc';
	$createOrder = 'Asc';
	switch ($sortField) {
		case "submission_id":
			if ($sortOrder == 'Desc') {
				$idOrder = 'Asc';
			}
			break;
		case "firstname":
			if ($sortOrder == 'Desc') {
				$firstnameOrder = 'Asc';
			}
			break;
		case "supplier_org_name":
			if ($sortOrder == 'Asc') {
				$supplierOrgOrder = 'Desc';
			}
			break;
		case "created_date":
			if ($sortOrder == 'Asc') {
				$createOrder = 'Desc';
			}
			break;
	}
	// get supplier id of the logged in supplier
	$supplier_org_name = db_query('SELECT supplier_org_name FROM {users_info} WHERE uid = :uid', array(':uid' => $uid))->fetchField();
	
	// get users of the supplier from the same supplier organization	
	if ($supplier_org_name) {
		$supplier_users = db_query('SELECT ui.* FROM {users_info} ui INNER JOIN {users} u ON ui.uid = u.uid WHERE ui.supplier_org_name = :supplier_org_name AND u.status = 1', array(':supplier_org_name' => $supplier_org_name));
	}
	$page_title = (($arg_2 || arg(2) == 0) && $arg_2 != '' && !is_vwr_user_role() && arg(2) != intval($user->uid)) ? 'Team Submissions Overview' : 'Submissions Overview';
	?>
	<div class="right_cont">
		<h3><?php print $page_title; ?></h3>
		<div class="inbread">
			<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span><?php print $page_title; ?></span>
		</div>
		<div class="error" id="error-msg" style="display: none; clear:both;"></div>
		<div class="tab_container">
			<ul class="tabs">
				<li class="tab active">
					<a href="#tab1">
						<?php
						echo ($dropbox_selected) ? 'View Dropbox Submissions' : (is_vwr_user_role() ? 'View Overall Submissions' : 'View Submissions');
						?>
					</a>
				</li>
			</ul>
			<?php if (view_team_access($uid)) { ?>
				<div style="float:right;">
					<select style="font-size:11px;" onchange="change_view_team(this.value);" id="view-team-supplier-id">
						<option value="0">-- All --</option>
						<?php
						foreach ($supplier_users as $supplier) {
							$supplier_user_id = $supplier->uid;
							$supplier_uids[] = $supplier_user_id;
							$supplier_user_name = $supplier->firstname . ' ' . $supplier->lastname;
							$selected = ($arg_2 == $supplier_user_id || ($uid == $supplier_user_id && !$arg_2 && $arg_2 !== '0')) ? 'selected' : '';
						?>
							<option value="<?php print htmlspecialchars($supplier_user_id); ?>" <?php print $selected; ?>><?php print htmlspecialchars($supplier_user_name); ?></option>
						<?php
						}
						?>
					</select>
				</div>
			<?php } ?>
		</div>

		<div class="tab_container" style="border-bottom: none;">
			<div class="table_container">
				<form name="submissions-overview" id="submissions-overview" action="" method="POST">
					<input type="hidden" name="selected_tokens" id="selected_tokens" value="" />
					<?php
					if ($dropbox_selected) {
					?>
						<input type="hidden" name="selected_dropbox" id="selected_dropbox" value="<?php echo $dropbox_selected ? $dropbox_selected : ''; ?>" />
					<?php
					}
					if ($status_selected) {
					?>
						<input type="hidden" name="selected_status" id="selected_status" value="<?php echo $status_selected ? $status_selected : ''; ?>" />
					<?php
					}

					if ($region_selected) {
					?>
						<input type="hidden" name="selected_region" id="selected_region" value="<?php echo $region_selected ? $region_selected : ''; ?>" />
					<?php
					}
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr class="table_head table_row">
								<?php
								if (is_vwr_user_role()) {
								?>
									<th width="2%" height="20"><input type="checkbox" value="" name="tickets" class="tickets-selectall" /></th>
								<?php
								}
								?>
								<th width="1%"><span class="fieldreltop">Id</span><span class="sort_tbl topalignsort"><a class="sortTitle">
											<div id="submission_id" class="<?php echo $idOrder; ?>"></div>
										</a></span></th>
								<th width="5%">Title</th>
								<th width="5%">Dropbox</th>
								<th width="4%">Full&nbsp;<br />Name<span class="sort_tbl topalignsort2"><a class="sortTitle">
											<div id="firstname" class="<?php echo $firstnameOrder; ?>"></div>
										</a></span>
								</th>
								
								<?php
								if (is_vwr_user_role()) {
								?>
									<th width="4%"><span class="fieldreltop">Supplier&nbsp;</span><span class="sort_tbl topalignsort"><a class="sortTitle">
												<div id="supplier_org_name" class="<?php echo $supplierOrgOrder; ?>"></div>
											</a></span>
									</th>
								<?php
								}
								?>
								<th width="3%">Region</th>
								<th width="3%">Status</th>
								<th width="3%">Submission<br /> Date<span class="sort_tbl topalignsort2"><a class="sortTitle">
											<div id="created_date" class="<?php echo $createOrder; ?>"></div>
										</a></span>
								</th>
								
								<?php
								if (is_vwr_user_role()) {
								?>
									<th width="2%" height="20">&nbsp;</th>
								<?php
								}
								?>
							</tr>

							<tr class="table_row filter_bg">
								<?php
								if (is_vwr_user_role()) {
								?>
									<th>&nbsp;</th>
								<?php
								}
								?>
								<th class="table_cell w75"><input type="text" id="ticket_search_id" value="" class="ticket-search" /></th>
								<th class="table_cell w75 title_minwidth" style="#padding-left:<?php echo is_vwr_user_role() ? '1%' : '4%'; ?>;"><input style="min-width:90px;" type="text" id="ticket_search_title" value="" class="ticket-search" /></th>
								<th class="table_cell w75 title_minwidth" style="#padding-left:<?php echo is_vwr_user_role() ? '2%' : '5%'; ?>;">
									
									<select id="ticket_search_dbox" style="width:70px;" class="fontsize10px" onChange="getDboxSubmissions('<?php echo $dropbox_selected ? 'vwr' : 'ajax'; ?>');">

										<option value='0'>All</option>
										<?php
										$timestamp = strtotime(date("m/d/Y"));
										$qry_drp_order = " ORDER BY title ASC ";
										if (is_vwr_user_role()) {

											$dbox_title_list = db_query("SELECT d.id, d.title from {dropbox} as d $regiondropboxlistquery group by d.id $qry_drp_order")->fetchAllKeyed();
										} else {
											if ($supplier_org_name) {
												
												$dbox_title_list = db_query("SELECT DISTINCT d.id, d.title FROM {dropbox} AS d $regiondropboxlistquery LEFT JOIN {dropbox_supplier_access} AS ds ON  d.id = ds.dropbox_id WHERE ds.mapping = 1 AND ds.supplier_org_id IN (SELECT DISTINCT vendor_id FROM {vendor} WHERE supplier_org_id = '$supplier_org_name') $qry_drp_order")->fetchAllKeyed();
											}
											if (!$dbox_title_list) {
												$dbox_title_list = db_query("SELECT id, title from {dropbox} as d $regiondropboxlistquery where d.deleted='0' AND d.end_date >= $timestamp AND d.id IN (SELECT dbox_id FROM {dropbox_files} WHERE deleted = 0 AND created_by = '$uid') group by d.id $qry_drp_order")->fetchAllKeyed();
											}
										}
										if ($dbox_title_list) {
											foreach ($dbox_title_list as $dbox_id => $dbox_titl) {
										?>
												<option value="<?php echo htmlspecialchars($dbox_id); ?>" <?php echo ($dropbox_selected == $dbox_id) ? 'selected' : ''; ?> title="<?php echo htmlspecialchars($dbox_titl); ?>"><?php echo (strlen(htmlspecialchars($dbox_titl)) > 16) ? substr(htmlspecialchars($dbox_titl), 0, 14) . '..' : htmlspecialchars($dbox_titl); ?></option>
										<?php
											}
										}
										?>
									</select>
								</th>
								<th class="table_cell w75" style="#padding-left:<?php echo is_vwr_user_role() ? '0%' : '2%'; ?>;"><input type="text" id="ticket_search_fname" value="" class="ticket-search" /></th>
								
								<?php
								if (is_vwr_user_role()) {
								?>
									<th class="table_cell w75"><input type="text" id="ticket_search_sorg" value="" class="ticket-search" /></th>
								<?php
								}
								?>
								<th class="table_cell w75">
									<select id="ticket_search_regions" style="min-width:55px;" class="fontsize10px" onChange="getDboxSubmissions('ajax');">

										<option value='0'>All</option>
										<?php
										
										$dbox_regions = db_query("select region_id,region_shortname from {manage_regions} where region_status=1");


										if ($dbox_regions) {
											foreach ($dbox_regions as  $docr) {
										?>
												<option value="<?php echo $docr->region_id; ?>" <?php echo ($region_selected == $docr->region_id) ? 'selected' : ''; ?> title="<?php echo $docr->region_shortname; ?>"><?php echo $docr->region_shortname; ?></option>
										<?php
											}
										}
										?>
									</select>




								</th>
								<th class="table_cell w75" style="#padding-left:<?php echo is_vwr_user_role() ? '1%' : '2%'; ?>;">
									<select id="ticket_search_status" style="width:55px;" onChange="getDboxSubmissions('ajax');" class="fontsize10px">
										<option value='0'>Any</option>
										<?php
										$status_list = getAllStatusList(1);
										foreach ($status_list as $status) {
											if ($status->status_name && $status->status_id) {
										?>
												<option title="<?php echo $status->status_name; ?>" value="<?php echo $status->status_id; ?>" <?php echo ($status_selected == $status->status_id) ? 'selected' : ''; ?>><?php echo $status->status_abbr ? $status->status_abbr : $status->status_name; ?></option>
										<?php
											}
										}
										?>
									</select>
									<span style="display:none;" id="manage-status-list-all">
										<select class='fontsize10px'>
											<?php
											$status_list2 = getActiveStatusList(1);
											foreach ($status_list2 as $status) {
												if ($status->status_name && $status->status_id) {
											?>
													<option title='<?php echo $status->status_name; ?>' value='<?php echo $status->status_id; ?>' class='status_option_abbr_<?php echo $status->status_id; ?>'><?php echo $status->status_abbr ? $status->status_abbr : $status->status_name; ?></option>
											<?php
												}
											}
											?>
										</select>
									</span>
								</th>
								<th class="<?php echo is_vwr_user_role() ? '' : 'brdr_right'; ?>">&nbsp;</th>
								
								<?php
								if (is_vwr_user_role()) {
								?>
									<th class="brdr_right">&nbsp;</th>
								<?php
								}
								?>
							</tr>
						</thead>
						<tbody id="ticket_results">
							<?php
							$users_info_support = false;
							$records_count = 0;
							$supplier_uid = '';


							// view only supplier submissions
							if (in_array('supplier', $user->roles)) {
								// view team member's submissions
								if ($arg_2) {
									$uid = $arg_2;
								}
								$suppliers = implode(',', $supplier_uids);
								$supplier_uid = ($arg_2 == '0') ? " AND vwrdf.created_by IN(" . $suppliers . ")" : " AND vwrdf.created_by = " . $uid;
							}
							$qry_sort = '';
							$qry_count_sort = '';
							if ($sortField == 'submission_id' || $sortField == 'created_date') {
								$qry_sort = $supplier_uid . " $reggroupby ORDER BY $sortField " . (($sortOrder == 'Desc') ? 'DESC' : 'ASC') . " ";
								$qry_count_sort = $supplier_uid . " ORDER BY $sortField " . (($sortOrder == 'Desc') ? 'DESC' : 'ASC') . " ";
							} else if ($sortField == 'firstname') {								
								$qry_sort = $supplier_uid . " AND vwrdf.created_by = ui.uid $reggroupby ORDER BY $sortField " . (($sortOrder == 'Desc') ? 'DESC' : 'ASC');
								$qry_count_sort = $supplier_uid . " AND vwrdf.created_by = ui.uid ORDER BY $sortField " . (($sortOrder == 'Desc') ? 'DESC' : 'ASC');
								$users_info_support = true;
							} else if ($sortField == 'supplier_org_name') {								
								$qry_sort = $supplier_uid . " AND vwrdf.created_by = ui.uid $reggroupby ORDER BY sm.supplier_org_name " . (($sortOrder == 'Desc') ? 'DESC' : 'ASC');

								$qry_count_sort = $supplier_uid . " AND vwrdf.created_by = ui.uid ORDER BY sm.supplier_org_name " . (($sortOrder == 'Desc') ? 'DESC' : 'ASC');
								$users_info_support = true;
							} else {
								$qry_sort = $supplier_uid . " $reggroupby ORDER BY submission_id DESC ";
								$qry_count_sort = $supplier_uid . "  ORDER BY submission_id DESC ";
							}
							/*checking for dropbox selected*/
							$qry_dropbox = '';
							if ($dropbox_selected) {
								$qry_dropbox = " AND vwrdf.dbox_id = '$dropbox_selected' ";
							}
							if ($status_selected) {
								$qry_dropbox .= " AND vwrdf.status = '$status_selected' ";
							}
							if ($region_selected) {
								$qry_dropbox .= " AND vwrmr.region_id  = '$region_selected' ";
							}
							$qry_archived = "";
							$archive_id = db_query("SELECT status_id FROM {manage_status} WHERE `status_name` = 'Archive'")->fetchColumn();
							if ($archive_id && !is_vwr_user_role()) {
								$qry_archived = " AND vwrdf.status != '$archive_id' ";
							}


							/*Pagination Initializations*/
							if ($users_info_support) {
								$total = db_query("SELECT count(submission_id) FROM {dropbox_files} vwrdf $regionquery, {users_info} ui LEFT JOIN {supplier_organization} as sm ON sm.supplier_org_id = ui.supplier_org_name  WHERE submission_id>0 AND vwrdf.deleted='0' $qry_archived $qry_dropbox $qry_count_sort")->fetchColumn(); //$total = db_query("SELECT count(submission_id) from {dropbox_files} df, {users_info} ui where submission_id>0 AND deleted='0' $qry_archived $qry_dropbox $qry_sort")->fetchColumn();
							} else {
								$total = db_query("SELECT count(vwrdf.submission_id) FROM {dropbox_files} as vwrdf  $regionquery WHERE vwrdf.submission_id>0 AND vwrdf.deleted=0 $qry_archived $qry_dropbox  $qry_count_sort")->fetchColumn();
							}
							$page = pager_find_page();
							$num_per_page = variable_get('usermanager_num_per_page', 10);
							$offset = $num_per_page * $page;
							pager_default_initialize($total, $num_per_page);

							if ($users_info_support) {
								$submission_list = db_query("SELECT vwrdf.* FROM {dropbox_files} vwrdf $regionquery , {users_info} as ui LEFT JOIN {supplier_organization} as sm ON sm.supplier_org_id = ui.supplier_org_name  WHERE submission_id>0 AND vwrdf.deleted='0' $qry_archived $qry_dropbox  $qry_sort LIMIT $offset, $num_per_page"); //$submission_list = db_query("SELECT df.* from {dropbox_files} df, {users_info} ui where submission_id>0 AND deleted='0' $qry_archived $qry_dropbox $qry_sort LIMIT $offset, $num_per_page");
							} else {

								$submission_list = db_query("SELECT vwrdf.* FROM {dropbox_files} as vwrdf $regionquery WHERE vwrdf.submission_id>0 AND vwrdf.deleted=0 $qry_archived $qry_dropbox $qry_sort LIMIT $offset, $num_per_page");
							}

							foreach ($submission_list as $submission_info) {
								$records_count++;
								$dropbox_info = db_query('SELECT title, link_workflow_tool from {dropbox} where id = :dbox_id', array(':dbox_id' => $submission_info->dbox_id))->fetchObject();
								$dropbox_title = $dropbox_info->title;								
								$created_user_info = db_query('SELECT ui.firstname, ui.lastname, sm.supplier_org_name FROM {users_info} as ui LEFT JOIN {supplier_organization} as sm ON sm.supplier_org_id = ui.supplier_org_name  WHERE ui.uid=:crdby', array(':crdby' => $submission_info->created_by))->fetchObject();
								$modified_user_name = $modified_user_email = '';
								if ($submission_info->modified_by) {
									$modified_user_info = db_query('SELECT firstname, lastname, email FROM {users_info} WHERE uid = :modiby', array(':modiby' => $submission_info->modified_by))->fetchObject();
									$modified_user_email = $modified_user_info->email;
									$modified_user_name = $modified_user_info->firstname . ' ' . $modified_user_info->lastname;
								}

							?>
								<tr class="table_row">
									<?php
									if (is_vwr_user_role()) {
									?>
										<td height="20"><input type="checkbox" value="<?php echo $submission_info->submission_id; ?>" name="tickets[]" class="single-checkbox" /></td>
									<?php
									}
									?>
									<td class="submission-id-link" id="subm_tikid_<?php echo htmlspecialchars($submission_info->submission_id); ?>">
										<?php
										if ($submission_info->status != $archive_id) {
										?>
											<a href="<?php echo base_path() . 'vwr_dropbox/viewsubmission/' . base64_encode($submission_info->submission_id); ?>"><?php echo 'ID' . htmlspecialchars($submission_info->submission_id); ?></a>
										<?php
										} else {
										?>
											<span style="color:red;">
												<?php
												echo 'ID' . $submission_info->submission_id;
												?>
											</span>
										<?php
										}
										?>
									</td>
									<td title="<?php echo $submission_info->title; ?>">
										<?php
										$trimcnt = 20;
										if (strlen($submission_info->title) > ($trimcnt * 2)) {
											echo str_replace(" ", "&nbsp;", substr($submission_info->title, 0, $trimcnt) . '<br/>' . substr($submission_info->title, $trimcnt, $trimcnt) . '..');
										} else if (strlen($submission_info->title) > $trimcnt) {
											echo str_replace(" ", "&nbsp;", substr($submission_info->title, 0, $trimcnt) . '<br/>' . substr($submission_info->title, $trimcnt, $trimcnt));
										} else {
											echo str_replace(" ", "&nbsp;", $submission_info->title);
										}
										?>
									</td>
									<td title="<?php echo htmlspecialchars($dropbox_title); ?>">
										<?php
										echo (strlen($dropbox_title) > $trimcnt) ? substr(htmlspecialchars($dropbox_title), 0, ($trimcnt - 2)) . '..' : htmlspecialchars($dropbox_title);
										?>
									</td>
									<td title="<?php echo $full_name = htmlspecialchars($created_user_info->firstname) . ' ' . htmlspecialchars($created_user_info->lastname); ?>">
										<?php
										echo htmlspecialchars($created_user_info->firstname) . "<br/>" . htmlspecialchars($created_user_info->lastname);
										?></td>
									
									<?php
									if (is_vwr_user_role()) {
									?>
										<td><?php echo $created_user_info->supplier_org_name ? htmlspecialchars($created_user_info->supplier_org_name) : 'N/A'; ?></td>
									<?php
									}
									?>
									<?php									
									$region_names = db_select("dropbox_regions", "dr")
										->fields("dr", array("region_id"))
										->condition('dr.dropbox_id', $submission_info->dbox_id, '=')
										->execute();

									$rnameslist = '';
									foreach ($region_names as $rnm) {										
										$rnames = db_select("manage_regions", "mr")
											->fields("mr", array("region_shortname"))
											->condition('mr.region_id', array($rnm->region_id), 'IN')
											->execute();

										if ($rnames) {
											foreach ($rnames as $rn) {
												$rnameslist .= $rn->region_shortname . ",";
											}
										}
									}
									$rnameslist = implode(',', array_unique(explode(',', $rnameslist)));
									?>
									<td><?php echo substr($rnameslist, 0, (strlen($rnameslist) - 1)); ?></td>
									<td class="status_<?php echo $submission_info->submission_id; ?>">
										<span title="<?php echo htmlspecialchars(getFullStatusName($submission_info->status)); ?>"><?php echo htmlspecialchars($submission_info->status) ? htmlspecialchars(getStatusAbbr($submission_info->status)) : 'Recvd'; ?></span>
									</td>

									<td class="<?php echo is_vwr_user_role() ? '' : 'brdr_right'; ?>"><?php echo $submission_info->created_date ? date("m/d/Y", $submission_info->created_date) : ''; ?></td>
									
									<?php

									if (is_vwr_user_role()) {
									?>
										<td class="brdr_right">
											<input type="hidden" value="<?php echo htmlspecialchars($dropbox_info->link_workflow_tool); ?>" id="dbox_workflow_<?php echo htmlspecialchars($submission_info->submission_id); ?>" />
											<input type="hidden" value="<?php echo $submission_info->status ? $submission_info->status : 'Recvd'; ?>" id="db_subm_status_<?php echo $submission_info->submission_id; ?>" />
											
											<a class="ticket_status_edit" id="status_actions_<?php echo $submission_info->submission_id; ?>">
												<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" class="edit-icon" style="display:block;" onClick="editSaveTokenStatus('<?php echo $submission_info->submission_id; ?>', 'edit', '');" />
												<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/saveButton.png" width="15" height="16" alt="save" class="save-icon" style="display:none;" onClick="editSaveTokenStatus('<?php echo $submission_info->submission_id; ?>', 'save', '');" />
											</a>
											
										</td>
									<?php
									}
									?>
								</tr>
							<?php } ?>
							<?php
							if ($records_count == 0) { ?>
								<tr class="table_row">
									<td class="no_records brdr_right" colspan="11">No Submissions Found</td>
								</tr>
							<?php } ?>
						</tbody>
						<input type="hidden" value="<?php echo htmlspecialchars($archive_id); ?>" id="tkt_archv_statusid" />
					</table>
				</form>
			</div>

			<div class="pagenation">
				<div class="pagenation_cont">
					<?php
					$current_record_count = (($page + 1) * $num_per_page);
					$rec_starts = $current_record_count - ($num_per_page - 1);
					?>
					<div class="show_page">
						<?php

						echo "Showing " .
							(($rec_starts != $total && $total) ? $rec_starts . ' - ' : '') .
							((($current_record_count < $total) && $current_record_count) ? htmlspecialchars($current_record_count) : htmlspecialchars($total)) .
							' of ' . htmlspecialchars($total) . ' Entries';

						?>
					</div>
					<div class="cunt">
						<?php echo theme('pager'); ?>
					</div>
				</div>
			</div>


			<div class="pagenation_search" style="display:none">
				<div class="pagenation_cont_search">

					<div class="show_page_search">

					</div>
					<div class="cunt_search">

					</div>
				</div>
			</div>

			<div class="conf_btn_overview" style="margin-bottom:10px;">
				<input type="button" class="button" value="Ok" onClick="window.location = baseurl;" />
				<?php
				if (is_vwr_user_role()) {
				?>
					<span id="edit-selected-tickets">
						<input type="button" class="button" value="Edit" id="edit_ticket_action" onClick="editSaveTokenStatus('', 'editAll', '');" />
					</span>
					<span id="save-cancel-tickets" style="display:none;">
						<input type="button" class="button" value="Save" name="save_ticket" id="save_ticket" onClick="editSaveTokenStatus('', 'saveAll', '');" />
						<input type="button" class="button" value="Cancel" id="" onClick="window.location = baseurl+'ticketmanager/ticketsoverview'; " />
					</span>
					<input type="button" class="button ticketsubexport" value="Export" name="ticket_export" id="ticket_export" />
					<input type="button" class="button ticketsubexport" value="Export All" name="tickets_export_all" id="tickets_export_all" />
				<?php
				}
				?>
			</div>

		</div>
		<div class="clearboth"></div>
	</div>