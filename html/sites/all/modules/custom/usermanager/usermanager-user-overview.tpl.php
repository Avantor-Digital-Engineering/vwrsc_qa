<script type="text/javascript">
	$(document).ready(function() {
		var sanitizeHTML = function(str) {
			var temp = document.createElement('div');
			temp.textContent = str;
			return temp.innerHTML;
		};
		var current_url = window.location.pathname;
		var get_select_tab = current_url.split("/");
		if (current_url.search(/pendinguser/i) != -1 && get_select_tab[get_select_tab.length - 1] != "pendinguser") {
			$(".tab_content").hide();
			$("ul.tabs li:first").addClass("active").show();
			$(".tab_content:first").show();
		}
		$("ul.tabs li").click(function() {
			$(".success").hide();
			$(".success").html('');
			$("ul.tabs li").removeClass("active");
			$(this).addClass("active");
			$(".tab_content").hide();

			var activeTab = $(this).find("a").attr("href");
			$(sanitizeHTML(activeTab)).fadeIn();
			return false;
		});
		$(".sortTitle").click(function() {
			var fieldVal = $(this).find('div').attr("id");
			var sortOrder = $(this).find('div').attr("class");
			
			var params = {
				sortBy: fieldVal,
				direction: sortOrder
			};
			var str = $.param(params);
			window.location.href = '?' + str;
		});
	});

	$(function() {
		$(".tooltips").tooltip();
	});
</script>
	<style type="text/css">
		.table_rows th,
		.table_rows td {
			line-height: 16px;
			border: 1px solid #cfcfc8;
			border-bottom: none;			
			border-right: 1px solid #cfcfc8;
			#border-right: 1px solid #cfcfc8;
			vertical-align: middle;
			text-align: center;

			#padding: 3px;
		}
	</style>
	<?php
	$confirm_edit_perm = has_user_access('confirm/update');
	$supplier_attr_perm = has_user_access('supplierAttr');
	$sortField = $_REQUEST['sortBy'];
	$sortOrder = $_REQUEST['direction'];
	$firstnameOrder = 'Desc';
	$lastnameOrder = 'Asc';
	$emailOrder = 'Asc';
	$supplierOrgOrder = 'Asc';
	$userTypeOrder = 'Asc';
	$statusOrder = 'Asc';
	$createOrder = 'Asc';
	$loginOrder = 'Asc';
	$regionorder = 'Asc';
	switch ($sortField) {
		case "firstname":
			if ($sortOrder == 'Desc') {
				$firstnameOrder = 'Asc';
			}
			break;
		case "lastname":
			if ($sortOrder == 'Asc') {
				$lastnameOrder = 'Desc';
			}
			break;
		case "mail":
			if ($sortOrder == 'Asc') {
				$emailOrder = 'Desc';
			}
			break;
		case "supplier_org_name":
			if ($sortOrder == 'Asc') {
				$supplierOrgOrder = 'Desc';
			}
			break;
		case "role_name":
			if ($sortOrder == 'Asc') {
				$userTypeOrder = 'Desc';
			}
			break;
		case "status":
			if ($sortOrder == 'Asc') {
				$statusOrder = 'Desc';
			}
			break;
		case "created":
			if ($sortOrder == 'Asc') {
				$createOrder = 'Desc';
			}
			break;
		case "access":
			if ($sortOrder == 'Asc') {
				$loginOrder = 'Desc';
			}
		case "region":
			if ($sortOrder == 'Asc') {
				$regionorder = 'Desc';
			}
			break;
	}
	?>
	<div class="right_cont">
		<div class="inbread">
			<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span>User Directory</span>
		</div>
		<?php
		if ($_SESSION['user_update'] != '') {
		?>
			<div class="success" style=" clear:both;"><?php print $_SESSION['user_update']; ?></div>
		<?php
			$_SESSION['user_update'] = "";
		}
		?>
		<div class="error" id="error-msg" style="display: none; clear:both;"></div>
		<div class="tab_container">
			<ul class="tabs">
				<li class="tab <?php if ($default_tab != "pendinguser" && $default_tab != "deactiveuser") {
									echo "active";
								} else {
								} ?>"> <a href="#tab1">Users Overview</a> </li>
				<?php
				if ($confirm_edit_perm) {
				?>
					<li class="tab <?php if ($default_tab == "pendinguser") {
										echo "active";
									} else {
									} ?>"> <a href="#tab2" id="user-approvals">Users Approvals</a> </li>
					<li class="tab <?php if ($default_tab == "deactiveuser") {
										echo "active";
									} else {
									} ?>"> <a href="#tab3">Deactivation Requests</a></li>
				<?php
				}
				?>
			</ul>
		</div>
		<div class="tab_container" style="border-bottom: none;">
			<div id="tab1" class="tab_content" style=" <?php if ($default_tab != "pendinguser" && $default_tab != "deactiveuser") {
															echo "display:block";
														} else {
															echo "display:none";
														} ?>">
				<div class="act_icons">
					<span><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/active_ico.png" width="14" height="13" alt="active" /> Active</span>
					<span><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/red_status_icon.png" width="14" height="14" alt="active" /> Deactive</span>
					<span><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/new_req_icon.png" width="14" height="13" alt="active" /> New Request</span>
				</div>
				<div class="table_container">
					<form name="users-overview" id="users-overview" action="" method="POST">
						<input type="hidden" name="selcted_users" id="selcted_users" value="" />
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<thead>
								<tr class="table_head table_row">
									<th width="2%" height="20"><input type="checkbox" value="" name="users" class="selectall" /></th>
									<?php if ($confirm_edit_perm || $supplier_attr_perm) { ?>
										<th width="2%">Edit</th>
									<?php } ?>
									<th width="12%">First<br />Name<span class="sort_tbl"><a class="sortTitle">
												<div id="firstname" class="<?php echo $firstnameOrder; ?>"></div>
											</a></span>
									</th>
									<th width="12%">Last<br />Name<span class="sort_tbl"><a class="sortTitle">
												<div id="lastname" class="<?php echo $lastnameOrder; ?>"></div>
											</a></span>
									</th>
									<th width="11%">Email ID<span class="sort_tbl" style="margin-top:5px; #margin:0px; "><a class="sortTitle">
												<div id="mail" class="<?php echo $emailOrder; ?>"></div>
											</a></span>
									</th>
									<th width="9%">Supplier Org<span class="sort_tbl"><a class="sortTitle">
												<div id="supplier_org_name" class="<?php echo $supplierOrgOrder; ?>"></div>
											</a></span>
									</th>
									<th width="7%">VAS Tier</th>
									<th width="12%">User Type<span class="sort_tbl"><a class="sortTitle">
												<div id="role_name" class="<?php echo $userTypeOrder; ?>"></div>
											</a></span>
									</th>
									<th width="11%">Status<span class="sort_tbl"><a class="sortTitle">
												<div id="status" class="<?php echo $statusOrder; ?>"></div>
											</a></span>
									</th>
									<th width="11%">Created Date<span class="sort_tbl"><a class="sortTitle">
												<div id="created" class="<?php echo $createOrder; ?>"></div>
											</a></span>
									</th>
									<th width="12%">Last<br />Login<span class="sort_tbl"><a class="sortTitle">
												<div id="access" class="<?php echo $loginOrder; ?>"></div>
											</a></span>
									</th>
									<th width="12%">Supplier Regions<span class="sort_tbl"><a class="sortTitle">
												<div id="region"></div>
											</a></span>
									</th>
								</tr>
								<tr class="table_row filter_bg">
									<th>&nbsp;</th>
									<?php if ($confirm_edit_perm || $supplier_attr_perm) { ?>
										<th>&nbsp;</th>
									<?php } ?>
									<th class="table_cell w85"><input type="text" name="user_search_fname" id="user_search_fname" value="" class="user-search" /></th>
									<th class="table_cell w85"><input type="text" name="user_search_lname" id="user_search_lname" value="" class="user-search" /></th>
									<th class="table_cell w110"><input type="text" name="user_search_email" id="user_search_email" value="" class="user-search" /></th>
									<th class="table_cell w75"><input type="text" name="user_search_sorg" id="user_search_sorg" value="" class="user-search" /></th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th class="brdr_right">&nbsp;</th>
								</tr>
							</thead>
							<tbody id="users_results">
								<?php
								$records_count = 0;
								foreach ($data as $result) {
									$page = '';
									$records_count++;
								?>
									<tr class="table_rows">
										<td height="20" style="padding:0px !important"><input type="checkbox" value="<?php echo $result->uid; ?>" name="users[]" class="single-checkbox" /></td>
										<?php
										if ($confirm_edit_perm || $supplier_attr_perm) {
											if ($result->role_name == 'vwr internal') {
												$page = 'internaluserapprovals/';
											} else {
												$page = 'userapprovals/';
											}
										?>
											<td>
												<?php
												if (($confirm_edit_perm && $supplier_attr_perm) || ($confirm_edit_perm)) {
												?>
													<a href="<?php echo $page . base64_encode($result->uid); ?>"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" /></a>
												<?php
												} else if (!($confirm_edit_perm) && ($supplier_attr_perm && $page != 'internaluserapprovals/')) {
												?>
													<a href="<?php echo $page . base64_encode($result->uid); ?>"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" /></a>
												<?php
												} else {
												?>
													<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/edit_ico.png" width="15" height="16" alt="edit" />
												<?php
												}
												?>
											</td>
										<?php
										}
										?>
										<td><?php print $result->firstname; ?></td>
										<td><?php print $result->lastname; ?></td>
										<?php
										$mail_length = strlen($result->mail);
										$mail_split = ($mail_length  > 15) ? "<a style='color: #000000;' title=" . $result->mail . ">" . substr($result->mail, 0, 15) . "...</a>" : $result->mail;
										?>
										<td><?php echo $mail_split; ?></td>
										<?php
										$activeregionsprocess = array();
										$activeregions = getregioninfo();
										$activeregionsprocess = array_flip($activeregions);
										$userregions = array();
										$userregions  = get_user_regionid($result->uid);
										$region_name = '';
										if (!empty($userregions)) {
											foreach ($userregions as $indexregion_id => $region_id) {
												$region_name .= $activeregionsprocess[$region_id] . " ";
											}
										}

										$supplier_org_id = '';
										$vas_count = 0;
										$vas_details = '';
										$vas_list = '';
										if ($result->supplier_org_id) {
											$supplier_org_id = $result->supplier_org_id;
											$supplier_details = db_query("SELECT vtier.vas_tier_name
											FROM {vas_tier} vtier, {vendor} ven 
											JOIN {vas_tier_vendor_map} vmap on vmap.vendor_id = ven.vendor_id
											JOIN {supplier_organization} s ON s.supplier_org_id = ven.supplier_org_id
											WHERE s.supplier_org_id = '$supplier_org_id' AND vtier.vas_tier_id = vmap.vas_tier_id 
											AND vtier.deleted = 0 AND vmap.deleted = 0 AND ven.deleted = 0 order by vtier.vas_tier_name ASC");
											$vas_count = 0;
											$vas_list = '';
											$vas_temp_name = '';
											$vas_list = "<div style='height:72px; overflow: auto; padding: 8px;'>";
											foreach ($supplier_details as $rec_count => $supliers_result) {
												$vas_count++;
												if ($vas_temp_name != $supliers_result->vas_tier_name) {
													$vas_list .= $supliers_result->vas_tier_name . "<br />";
												}
												$vas_temp_name = $supliers_result->vas_tier_name;
											}
											$vas_list .= "</div>";
										} else {
											$vas_count = '0';
											$vas_list = "<div style='height:72px; overflow: auto; padding: 8px;'>N/A</div>";
										}
										?>
										<td id="user_supplier_na_<?php echo $result->uid; ?>"><?php echo $result->supplier_org_name ? $result->supplier_org_name : 'N/A'; ?></td>
										<td><a class="tooltips" title="<?php print $vas_list; ?>" style="cursor:pointer;"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/vas_img.png" width="20" height="17" alt="" /><span><?php print $vas_count; ?></span></a></td>
										<td id="user_supplier_type_<?php echo $result->uid; ?>"><?php print $result->role_name; ?></td>
										<?php
										$status_class = "";
										if ($result->status == 0) {
											$status_class = "inActiveButton";
										} else if ($result->status == 1) {
											$status_class = "activeButton";
										} else if ($result->status == 2) {
											$status_class = "pendingButton";
										}
										?>
										<td>
											<?php
											if ($result->status != 2) {
												if ($confirm_edit_perm) {
											?>
													<a href="javascript:void(0);" onclick="statusUpdate(<?php echo $result->uid; ?>);"><span id="userstatus_<?php echo $result->uid; ?>" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span></a>
												<?php
												} else {
												?>
													<span id="userstatus_<?php echo $result->uid; ?>" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span>
												<?php
												}
											} else {
												?>
												<span id="userstatus_<?php echo $result->uid; ?>" class="<?php echo $status_class; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php } ?>
										</td>
										<td><?php print date("m/d/Y", $result->created); ?></td>
										<td class="brdr_right"><?php print $accessdate = $result->login ? date("m/d/Y", $result->login) : "Never"; ?></td>
										<td class="brdr_right" style="padding:0px !important"><?php print htmlspecialchars($region_name); ?></td>
									</tr>
								<?php
								}
								if ($records_count == 0) {
								?>
									<tr class="table_row">
										<td class="no_records brdr_right" colspan="11">No Users Found</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</form>
				</div>
				<div class="pagenation">
					<div class="pagenation_cont">
						<?php $current_record_count = (($page_no + 1) * $number_per_page);
						$rec_starts = $current_record_count - ($number_per_page - 1) ?>
						<div class="show_page">
							Showing <?php if ($rec_starts != $total_rec) echo $rec_starts . " - ";
									echo ($current_record_count < $total_rec) ? $current_record_count : $total_rec; ?>
							of <?php echo $total_rec; ?> Entries
						</div>
						<div class="cunt">
							<?php echo theme('pager'); ?>
						</div>
					</div>
				</div>
				<div class="conf_btn_overview">
					<?php
					if ($confirm_edit_perm) {
					?>
						<input type="button" class="button groupaction" value="Activate" name="user_activate" id="user_activate" />
						<input type="button" class="button groupaction" value="Deactivate" name="user_deactivate" id="user_deactivate" />
					<?php
					}
					?>
					<input type="button" class="button groupexport" value="Export" name="user_export" id="user_export" />
					<input type="button" class="button groupexport" value="Export All" name="user_export_all" id="user_export_all" />
				</div>
				<br style="clear: both;" /><br />
			</div>
			<div id="tab2" class="tab_content" style=" <?php if ($default_tab == "pendinguser") {
															echo "display:block";
														} else {
															echo "display:none";
														} ?>">
				<div class="table_container">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="table_head table_row">
							<td align="left">S.No</td>
							<td align="left">First Name</td>
							<td align="left">Last Name</td>
							<td align="left">Email ID</td>
							<td align="left">User Type</td>
							<td align="left">Requested Date</td>
							<td align="left">Status</td>
						</tr>
						<?php
						$rec_count1 = 0;
						foreach ($pending_user as $i => $pending_list) {
							$rec_count1++;
							$page = base_path() . 'usermanager/userapprovals/'; ?>
							<tr class="table_row">
								<td align="left" valign="middle"><?php echo $i + 1; ?></td>
								<td align="left" valign="middle"><?php echo $pending_list->firstname; ?></td>
								<td align="left" valign="middle"><?php echo $pending_list->lastname; ?></td>
								<?php
								$mail_length = strlen($pending_list->mail);
								$mail_split = ($mail_length  > 15) ? "<a style='color: #000000;' title=" . $pending_list->mail . ">" . substr($pending_list->mail, 0, 15) . "...</a>" : $pending_list->mail;
								?>
								<td align="left" valign="middle"><?php echo $mail_split; ?></td>
								<td align="left" valign="middle"><?php echo $pending_list->name; ?></td>
								<td align="left" valign="middle"><?php print date("m/d/Y", $pending_list->created)  ?></td>

								<?php if ($pending_list->name == 'vwr internal') {
									$page = base_path() . 'usermanager/internaluserapprovals/';
								} ?>

								<td align="left" valign="middle" class="table_cell brdr_right">
									<a href="<?php echo $page . $pending_list->uid; ?>">
										<span><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/thumb_up.png" /></span> </a>&nbsp;
									<span><a href="javascript:void(0);" onclick="disApprove('<?php echo $pending_list->uid; ?>','<?php echo $pending_list->firstname; ?>', '<?php echo $pending_list->mail; ?>');"><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/thumb_down.png" /></a></span>
								</td>
							</tr>
						<?php }
						if ($rec_count1 == 0) { ?>
							<tr class="table_row">
								<td class="no_records brdr_right" colspan="7">No Users Found</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
			<!-- Deactivation Requests -->
			<div id="tab3" class="tab_content" style=" <?php if ($default_tab == "deactiveuser") {
															echo "display:block";
														} else {
															echo "display:none";
														} ?>">
				<div class="table_container">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="table_head table_row">
							<td align="left">S.No</td>
							<td align="left">First Name</td>
							<td align="left">Last Name</td>
							<td align="left">Email ID</td>
							<td align="left">User Type</td>
							<td align="left">Requested By</td>
							<td align="left">Requested Date</td>
							<td align="left">Reason</td>
							<td align="left" class="w45">Status</td>
						</tr>
						<?php
						$sno = 0;
						foreach ($deactivation_list as $list) {
							$sno++;
							$supplier_uid = $list->uid;
							$user_details = get_user_details($supplier_uid);
							$firstname = $user_details->firstname;
							$lastname = $user_details->lastname;
							$mail = $user_details->email;
							$requested_by = get_user_details($list->requested_by)->email;
							$requested = date('m/d/Y', $list->requested_date);
							$reason = $list->reason;
						?>
							<tr class="table_row">
								<td align="left" valign="middle"><?php print $sno; ?></td>
								<td align="left" valign="middle"><?php print htmlspecialchars($firstname); ?></td>
								<td align="left" valign="middle"><?php print htmlspecialchars($lastname); ?></td>
								<td align="left" valign="middle"><span title="<?php print htmlspecialchars($mail); ?>"><?php print substr(htmlspecialchars($mail), 0, 15); ?>...</span></td>
								<td align="left" valign="middle">supplier</td>
								<td align="left" valign="middle"><span title="<?php print htmlspecialchars($requested_by); ?>"><?php print substr(htmlspecialchars($requested_by), 0, 15); ?>...</span></td>
								<td align="left" valign="middle"><?php print $requested; ?></td>
								<td align="left" valign="middle"><?php print $reason; ?></td>
								<td align="left" valign="middle" class="table_cell brdr_right" style="min-width:46px; width:48px;">
									<a href="userapprovals/<?php print $supplier_uid; ?>">
										<span><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/thumb_up.png" /></span>
									</a>&nbsp;
									<span>
										<a href="javascript:void(0);" onclick="rejectDeactivation(<?php print htmlspecialchars($supplier_uid) ?>, '<?php print htmlspecialchars($firstname); ?>');">
											<span><img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/thumb_down.png" /></span>
										</a>
									</span>
								</td>
							</tr>
						<?php
						}
						if ($sno == 0) { ?>
							<tr class="table_row">
								<td class="no_records brdr_right" colspan="10">No Users Found</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>