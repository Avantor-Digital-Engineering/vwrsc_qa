	<script type="text/javascript">
		$(document).ready(function() {
			$(".sortTitle").click(function() {
				var params = {
					sortBy: $(this).find('div').attr("id"),
					direction: $(this).find('div').attr("class")
				};
				window.location.href = '?' + $.param(params);
			});
		});
	</script>
	<script src="<?php echo base_path() . drupal_get_path('module', 'bulk'); ?>/js/bulk.js"></script>
	<style type="text/css">
		.sort_tbl {
			width: 8px;
		}

		.table_container .brdr_right {
			border-right: 1px solid #CFCFC8 !important;
		}

		.brdr_right img {
			cursor: pointer;
		}

		.table_container {
			margin-top: 2px;
		}

		.fieldreltop {
			position: relative;
			top: 5px;			
		}

		.topalignsort2 {
			position: relative;
			top: -3px;			
		}

		.expiredItem {
			color: red;
		}
		
	</style>
	<?php
	global $user;
	$sortField = addslashes(strip_tags(strtolower(trim($_REQUEST['sortBy']))));
	$sortOrder = addslashes(strip_tags(trim($_REQUEST['direction'])));
	$departmentOrder = 'Desc';
	$dateOrder = 'Desc';
	$exdateOrder = 'Asc';
	$sort_qry_field = '';
	switch ($sortField) {
		case "department":
			if ($sortOrder == 'Desc') {
				$departmentOrder = 'Asc';
			}
			$sort_qry_field = 'department';
			break;
		case "createdate":
			if ($sortOrder == 'Desc') {
				$dateOrder = 'Asc';
			}
			$sort_qry_field = 'created_date';
			break;
		case "expdate":
			if ($sortOrder == 'Asc') {
				$exdateOrder = 'Desc';
			}
			$sort_qry_field = 'expiry_date';
			break;
	}
	$close_css = '';
	$where = '';
	$supplier_org_name = '';
	if (is_vwr_user_role()) {
		$page_title = $tab_title = 'View Reports';
	} else {
		$timestamp = strtotime(date("m/d/Y"));
		$page_title = $tab_title = 'My Reports';
		$close_css = 'brdr_right ';
		$supplier_org_name = db_query('SELECT so.supplier_org_name FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid=:uid AND so.deleted=0', array(':uid' => $user->uid))->fetchColumn();
		if ($supplier_org_name != "")
			$where = " so.supplier_org_name = ':supplier_org_name' AND ";
		$where .= " b.expiry_date >= :timestamp AND ";
	}
	$theme_path = base_path() . drupal_get_path('theme', 'vwr') . '/';
	?>
	<div class="right_cont">
		<h3><?php print $page_title; ?></h3>
		<div class="inbread">
			<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span><?php print $page_title; ?></span>
		</div>
		<div class="error" id="error-msg" style="display: none; clear:both;"></div>
		<div class="tab_container">
			<ul class="tabs">
				<li class="tab active"><a href="#tab1"><?php echo $tab_title; ?></a></li>
			</ul>
		</div>
		<?php
		if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
		?>
			<div style="float:right; margin:10px 25px 0px 0px;">
				<a href="<?php echo base_path() . 'bulk/create'; ?>"><img src="<?php echo $theme_path; ?>images/createnew_icon_25.png" width="24" height="25" alt=" + " title="Upload New" /></a>
			</div>
		<?php
		}
		?>
		<div class="tab_container" style="border-bottom: none;">
			<div class="table_container">
				<form name="bulk-overview" id="bulk-overview" action="" method="POST">
					<input type="hidden" name="selected_bulks" id="selected_bulks" value="" />
					<input type="hidden" name="current_page_no" id="current_page_no" value="<?php echo addslashes(htmlentities(trim($_REQUEST['page']))) ? addslashes(htmlentities(trim($_REQUEST['page']))) : ''; ?>" />
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr class="table_head table_row">
								<?php
								if (is_vwr_user_role()) {
								?>
									<th width="2%" height="20"><input type="checkbox" value="" name="bulks" class="bulks-selectall" /></th>
								<?php
								}
								?>
								<th width="11%">Report Name</th>
								<th width="8%"><span style="#top:4px; position:relative;">Department</span><span class="sort_tbl fieldreltop"><a class="sortTitle">
											<div id="department" class="<?php echo $departmentOrder; ?>"></div>
										</a></span></th>
								<th width="5%">Date <br />Provided<span class="sort_tbl topalignsort2"><a class="sortTitle">
											<div id="createdate" class="<?php echo $dateOrder; ?>"></div>
										</a></span></th>
								<th width="5%">Expiration<br /> Date<span class="sort_tbl topalignsort2"><a class="sortTitle">
											<div id="expdate" class="<?php echo $exdateOrder; ?>"></div>
										</a></span></th>
								<?php
								if (is_vwr_user_role()) {
								?>
									<th width="5%">Supplier Org</th>
								<?php
								}
								?>
								<th width="6%">Last Download By</th>
								<th width="<?php echo has_page_access('dropbox') ? '5%' : '2%'; ?>" height="20">&nbsp;</th>
							</tr>
							<tr class="table_row filter_bg">
								<?php
								if (is_vwr_user_role()) {
								?>
									<th>&nbsp;</th>
								<?php
								}
								?>
								<th class="table_cell w75" style="#padding-left:<?php echo is_vwr_user_role() ? '4%' : '5%'; ?>;"><input style="min-width:<?php echo is_vwr_user_role() ? '88px' : '95px'; ?>;" type="text" id="bulk_search_report" value="" class="bulk-search" /></th>
								<th class="table_cell w75"></th>
								<th class="table_cell w75"></th>
								<th class="table_cell w75"></th>
								<?php
								if (is_vwr_user_role()) {
								?>
									<th class="table_cell w75" style="#padding-left:1%;"><input type="text" id="bulk_search_sorg" value="" class="bulk-search" /></th>
								<?php
								}
								?>
								<th class="<?php echo $close_css; ?>table_cell w75"></th>
								<th class="brdr_right">&nbsp;</th>
							</tr>
						</thead>
						<tbody id="bulk_results">
							<?php
							$records_count = 0;
							$qry_sort = " ORDER BY bulk_id DESC ";
							if ($sort_qry_field) {
								$qry_sort = " ORDER BY :sort_qry_field " . ((strtolower($sortOrder) == 'desc') ? 'DESC' : 'ASC') . " ";
							}
							$currentregions = 0;
							$currentregionquery = '';
							$groupbyregionquery = "";
							$cookie_region_name = addslashes(strip_tags(trim($_COOKIE['cookieregion_name'])));
							if (isset($cookie_region_name)) {
								$currentregions = $cookie_region_name;
								$currentregionquery = " INNER JOIN {bulk_upload_list_regions} as vwrbulr on vwrbulr.bulk_id = b.bulk_id and vwrbulr.status=1 and vwrbulr.region_id in (:currentregions) INNER JOIN {manage_regions} as vwrmr on  vwrmr.region_id=vwrbulr.region_id and vwrmr.region_status=1 ";
								$groupbyregionquery = " group by b.bulk_id ";
							}

							$page = pager_find_page();
							$num_per_page = variable_get('usermanager_num_per_page', 10);
							$offset = $num_per_page * $page;
							$query = "SELECT 
												count(1) 
											FROM 
												{bulk_upload_list} AS b $currentregionquery  
											LEFT JOIN 
												{supplier_organization} AS so ON so.supplier_org_id = b.supplier_org 
											WHERE 
												$where 
												b.deleted=0 AND so.deleted=0";

							if (is_vwr_user_role()) {
								$where_array = [':currentregions' => $currentregions];
							} else {
								$supplier_param = [':supplier_org_name' => $supplier_org_name];
								if ($supplier_org_name != "")
									$where_array = array_merge($where_array, $supplier_param);
								$where_array = [':currentregions' => $currentregions, ':timestamp' => $timestamp];
							}
							$total = db_query($query, $where_array)->fetchColumn();
							pager_default_initialize($total, $num_per_page);
							$query = "SELECT 
												b.*, so.supplier_org_name AS supplier_org_name 
											FROM 
												{bulk_upload_list} AS b $currentregionquery 
											LEFT JOIN 
												{supplier_organization} AS so ON so.supplier_org_id = b.supplier_org 
											WHERE 
												$where 
												b.deleted=0 AND so.deleted=0 
												$groupbyregionquery 
												$qry_sort LIMIT $offset, $num_per_page ";
							if ($sort_qry_field) {
								$sort_param = [':sort_qry_field' => $sort_qry_field];
								$where_array = array_merge($where_array, $sort_param);
							}
							$bulk_list = db_query($query, $where_array);
							foreach ($bulk_list as $bulk_item) {
								$records_count++;								
							?>
								<tr class="table_row">
									<?php
									if (is_vwr_user_role()) {
									?>
										<td height="20"><input type="checkbox" value="<?php echo htmlspecialchars($bulk_item->bulk_id); ?>" name="bulks[]" class="single-checkbox" /></td>
									<?php
									}
									?>
									<td class="submission-id-link">
										<a href="<?php echo base_path() . 'bulk/actions/download/' . htmlspecialchars($bulk_item->bulk_id); ?>" title="<?php echo function_exists('splitFileNameTimestamp') ? splitFileNameTimestamp(htmlspecialchars($bulk_item->filename)) : htmlspecialchars($bulk_item->filename); ?>">
											<?php
											echo (strlen(htmlspecialchars($bulk_item->title)) > 25) ? substr(htmlspecialchars($bulk_item->title), 0, 23) . '..' : htmlspecialchars($bulk_item->title);
											?>
										</a>
									</td>
									<td title="<?php echo htmlspecialchars($bulk_item->department); ?>">
										<?php
										echo (strlen(htmlspecialchars($bulk_item->department)) > 16) ? substr(htmlspecialchars($bulk_item->department), 0, 14) . '..' : htmlspecialchars($bulk_item->department);
										?>
									</td>
									<td>
										<?php
										echo date('m/d/Y', $bulk_item->created_date);
										?>
									</td>
									<td class="<?php echo is_notexpired_date($bulk_item->expiry_date) ? '' : 'expiredItem'; ?>">
										<?php
										echo date('m/d/Y', $bulk_item->expiry_date);
										?></td>
									<?php
									if (is_vwr_user_role()) {
									?>
										<td title="<?php echo str_replace('"', '', htmlspecialchars($bulk_item->supplier_org_name)); ?>"><?php echo trim(htmlspecialchars($bulk_item->supplier_org_name)) ? htmlspecialchars($bulk_item->supplier_org_name) : 'N/A'; ?></td>
									<?php
									}
									?>
									<td class="<?php echo htmlspecialchars($close_css); ?> downloaded_<?php echo htmlspecialchars($bulk_item->bulk_id); ?>">
										<span>
											<?php
											if (is_vwr_user_role()) {
												$bulk_hist = db_query('SELECT i.firstname, i.lastname, i.email, h.download_date FROM {bulk_upload_history} AS h LEFT JOIN {users_info} AS i ON i.uid = h.user_id WHERE h.bulk_id= :bulk_id AND h.deleted=0 ORDER BY h.download_date DESC', array(':bulk_id' => $bulk_item->bulk_id))->fetchObject();
											} else if ($supplier_org_name) {
												$bulk_hist = db_query('SELECT i.firstname, i.lastname, i.email, h.download_date FROM {bulk_upload_history} AS h LEFT JOIN {bulk_upload_list} AS l ON l.bulk_id = h.bulk_id LEFT JOIN {users_info} AS i ON i.uid = h.user_id LEFT JOIN {users_roles} AS r ON r.uid = h.user_id WHERE l.supplier_org = :sup_org AND h.bulk_id=:bulk_id AND r.rid =(SELECT rid FROM {role} WHERE name="supplier")  AND h.deleted=0  ORDER BY h.download_date DESC', array(':sup_org' => $supplier_org_name, ':bulk_id' => $bulk_item->bulk_id))->fetchObject();
											}
											$hist_downloaded_user = htmlspecialchars($bulk_hist->firstname) . ' ' . htmlspecialchars($bulk_hist->lastname);
											echo trim($hist_downloaded_user) ? $hist_downloaded_user . ' <br />(' . date('m/d/Y', $bulk_hist->download_date) . ')' : 'None';
											?>
										</span>
									</td>

									<td class="brdr_right" style="min-width:55px;">
										<a href="<?php echo base_path() . 'bulk/view/' . htmlspecialchars($bulk_item->bulk_id); ?>" style="margin-right:4px;">
											<img src="<?php echo $theme_path; ?>images/view_ico.png" alt="View" title="<?php echo is_vwr_user_role() ? 'View Bulk Upload' : 'Report details'; ?>" />
										</a>
										<?php
										if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
										?>
											<a href="<?php echo base_path() . 'bulk/create/' . htmlspecialchars($bulk_item->bulk_id); ?>">
												<img src="<?php echo $theme_path; ?>images/edit_ico.png" width="15" height="16" alt="edit" title="Edit" onClick="" />
											</a>
											<img src="<?php echo $theme_path; ?>images/ico_8.png" width="18" height="18" alt="delete" title="Delete" onClick="deleteAttachedBulk('bulk_id', '<?php echo htmlspecialchars($bulk_item->bulk_id); ?>');" />
										<?php
										}
										?>
									</td>

								</tr>
							<?php 	} ?>
							<?php
							if ($records_count == 0) { ?>
								<tr class="table_row">
									<td class="no_records brdr_right" colspan="11">No Records Found</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</form>
			</div>
			<?php if ($records_count != 0) { ?>
				<div class="pagenation">
					<div class="pagenation_cont">
						<?php
						$current_record_count = (($page + 1) * $num_per_page);
						$rec_starts = $current_record_count - ($num_per_page - 1);
						?>
						<div class="show_page">
							<?php

							echo "Showing " .
								(($rec_starts != $total && $total) ? htmlspecialchars($rec_starts) . ' - ' : '') .
								((($current_record_count < $total) && $current_record_count) ? htmlspecialchars($current_record_count) : htmlspecialchars($total)) .
								' of ' . htmlspecialchars($total) . ' Records';

							?>
						</div>
						<div class="cunt">
							<?php echo theme('pager'); ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="conf_btn_overview" style="margin-bottom:10px;">
				<input type="button" class="button" value="Ok" onClick="window.location = baseurl;" />
				<?php
				if (is_vwr_user_role() && $records_count) {
					if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
				?>
						<input type="button" class="button grpbulkdelete" value="Delete" id="grpbulkdelete" />
					<?php
					}
					?>
					<input type="button" class="button bulksexport" value="Export" name="bulk_export" id="bulk_export" />
					<input type="button" class="button bulksexport" value="Export All" name="bulk_export_All" id="bulk_export_All" />
				<?php
				}
				?>
			</div>
		</div>
		<div class="clearboth"></div>
	</div>