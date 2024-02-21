	<style type="text/css">
		div#files_edit_list {			
			clear: both;
		}

		#files_edit_list div {
			clear: both;
			float: left;
			margin: 5px 1px;
		}

		#files_edit_list div span {
			float: left;
			font-weight: normal;
			width: 260px;

			color: #4B4A4A;
			cursor: pointer;
			font-size: 12px;
			line-height: 22px;
			text-decoration: underline;
		}

		#files_edit_list div img {
			float: right;
			cursor: pointer;
			margin: 0px 0px 0px 2px;			
		}

		#files_edit_list {
			float: left;
			padding-left: 0;
			width: 370px;
		}

		.reg_inpt {
			line-height: 27px;
			width: 540px;
		}

		.download_header {
			width: 739px;
		}

		.download_list {
			width: 739px;
			height: 271px;
			overflow: auto;
			overflow-x: hidden;
		}

		table tr.table_row {
			border-bottom: 1px solid #CFCFC8;
		}

		table tr.table_row td {
			border-bottom: 1px solid #CFCFC8;
		}

		.download_table {
			padding: 0px 15px 0px 15px;
			width: 739px;
		}

		.brdr_right {
			border-right: 1px solid #CFCFC8 !important;
		}

		.reg_btn {
			padding-left: 15px;
		}

		div a.repDownloadExport {
			float: right;
			text-decoration: underline;
		}

		div .topicon img {
			cursor: pointer;
		}
	</style>
	<script src="<?php echo base_path() . drupal_get_path('module', 'bulk'); ?>/js/bulk.js"></script>
	<?php
	global $user;
	$bulk_info = $user_supplier_org = '';
	$bulk_id = 0;

	if (arg(2) && is_numeric(arg(2))) {
		$bulk_id = arg(2);
	} else {
		$temp_bulk_id = trim(arg(2)) . trim(arg(3)) . trim(arg(4)) . trim(arg(5));
		$bulk_id = base64_decode(trim($temp_bulk_id));
	}
	if ($bulk_id && is_numeric($bulk_id)) {
		$bulk_info = db_query("SELECT title, department, description, email_notification, expiry_date, supplier_org, filename, scan_file_id, scan_file_status from {bulk_upload_list} where bulk_id =:bulk_id AND deleted='0'",[':bulk_id' => $bulk_id])->fetchObject();
		$bulk_info = db_query("SELECT b.title, b.department, b.description, b.email_notification, b.expiry_date, so.supplier_org_name AS supplier_org, b.filename, scan_file_id, scan_file_status FROM {bulk_upload_list} AS b LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = b.supplier_org WHERE b.bulk_id =:bulk_id AND b.deleted='0' AND so.deleted='0'",[':bulk_id' => $bulk_id])->fetchObject();
	}
	if (is_vwr_user_role()) {
		$title = "View Bulk Upload";
	} else {
		$user_supplier_org = db_query("SELECT so.supplier_org_name FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid = '" . $user->uid . "' AND so.deleted='0'")->fetchColumn();
		$title = "Reports Details";
	}
	drupal_set_title($title);
	if (is_vwr_user_role() || (trimLowReplace($user_supplier_org) == trimLowReplace($bulk_info->supplier_org))) {

		$where = "";
		if (is_vwr_user_role()) {
			$bulk_list = db_query("SELECT * FROM {bulk_upload_history} AS h LEFT JOIN {users_info} AS i ON i.uid = h.user_id WHERE h.bulk_id=$bulk_id AND h.deleted='0' ORDER BY h.download_date DESC");
		} else {
			$supplier_org_name = db_query("SELECT supplier_org_name FROM {users_info} WHERE uid='" . $user->uid . "'")->fetchColumn();
			$bulk_list = db_query("SELECT i.firstname, i.lastname, i.email, h.download_date FROM {bulk_upload_history} AS h LEFT JOIN {bulk_upload_list} AS l ON l.bulk_id = h.bulk_id LEFT JOIN {users_info} AS i ON i.uid = h.user_id LEFT JOIN {users_roles} AS r ON r.uid = h.user_id WHERE l.supplier_org = '" . $supplier_org_name . "' AND h.bulk_id=$bulk_id AND r.rid =(SELECT rid FROM {role} WHERE name='supplier')  AND h.deleted='0'  ORDER BY h.download_date DESC");
		}

		$records_count = 0;

		$bulk_total = $bulk_list->rowCount();
	?>
		<div class="right_cont">
			<div class="submdet_head">
				<h3><?php echo $title; ?></h3>
				<span class="topicon" style="margin-right:10px;">
					<?php
					if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
						$theme_path = base_path() . drupal_get_path('theme', 'vwr') . '/';
					?>
						<a href="<?php echo base_path() . 'bulk/create/' . $bulk_id; ?>">
							<img src="<?php echo $theme_path; ?>images/edit_ico.png" width="15" height="16" alt="edit" title="Edit" onClick="" />
						</a>
						<img src="<?php echo $theme_path; ?>images/ico_8.png" width="18" height="18" alt="delete" title="Delete" onClick="deleteAttachedBulk('bulk_id', '<?php echo $bulk_id; ?>');" />
					<?php
					}
					?>
				</span>
			</div>
			<div class="inbread">
				<?php
				if (is_vwr_user_role()) {
				?>
					<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<a href="<?php echo base_path() . 'bulk/overview'; ?>">Bulk Upload Overview</a>&gt;<span>View Bulk Upload</span>
				<?php
				} else {
				?>
					<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<a href="<?php echo base_path() . 'bulk/reports'; ?>">My Reports</a>&gt;<span>Reports Details</span>
				<?php
				}
				?>
			</div>

			<div class="error status_msg" id="status_bulk_msg">&nbsp;</div>
			<form name="bulkForm">
				<div class="reg_form">
					<div class="reg_labl">
						<label>Title :</label>
					</div>
					<div class="reg_inpt">
						<?php echo htmlspecialchars($bulk_info->title); ?>
					</div>
					<div class="clearboth">&nbsp;</div>
					<div class="reg_labl">
						<label>Department :</label>
					</div>
					<div class="reg_inpt">
						<?php echo htmlspecialchars($bulk_info->department); ?>
					</div>
					<div class="clearboth">&nbsp;</div>
					<div class="reg_labl">
						<label>Description :</label>
					</div>
					<div class="reg_inpt">
						<?php echo nl2br(htmlspecialchars($bulk_info->description)); ?>
					</div>
					<div class="clearboth">&nbsp;</div>
					<?php
					if (is_vwr_user_role()) {
					?>
						<div class="reg_labl">
							<label>Expiry Date :</label>
						</div>
						<div class="reg_inpt">
							<?php echo $bulk_info->expiry_date ? date("m/d/Y", $bulk_info->expiry_date) : ''; ?>
						</div>
						<div class="clearboth">&nbsp;</div>
						<div class="reg_labl"><label>&nbsp;</label></div>
						<div class="reg_inpt" style="color:#4B4A4A;">
							<input type="checkbox" name="bulk_notification" id="bulk_notification" style="width:20px; margin:0 0 0 1px; border:0px; background:none;" <?php echo $bulk_info->email_notification ? 'checked' : ''; ?> disabled="disabled" /> Enable Email Notifications
						</div>
						<div class="clearboth">&nbsp;</div>
					<?php
					}
					?>
					<div class="reg_labl">
						<label>Bulk Uploads :</label>
					</div>
					<div class="reg_inpt">
						<div id="files_edit_list" file_id="<?php echo htmlspecialchars($bulk_info->scan_file_id);?>">
							<input type="hidden" value="<?php echo $bulk_id; ?>" id="bulk_id_hidden" />
							<?php
							$theme_path = base_path() . drupal_get_path('theme', 'vwr') . '/';
							if ($bulk_info->filename && $bulk_id && ($bulk_info->scan_file_status == "SCAN_COMPLETED"  || $bulk_info->scan_file_status == "")) {
								$bulk_filename = function_exists('splitFileNameTimestamp') ? splitFileNameTimestamp($bulk_info->filename) : $bulk_info->filename;
							?>
								<div id="bulk_uploaded_file_<?php echo $bulk_file->file_id; ?>" >
									<a href="<?php echo base_path() . 'bulk/actions/download/' . $bulk_id . '/view'; ?>">
										<span title="<?php echo htmlspecialchars($bulk_filename); ?>" class="supl_bulk_file "><?php echo (strlen(htmlspecialchars($bulk_filename)) > 30) ? substr(htmlspecialchars($bulk_filename), 0, 28) . '..' : htmlspecialchars($bulk_filename); ?></span>
									</a>
									<a href="<?php echo base_path() . 'bulk/actions/download/' . $bulk_id . '/view'; ?>">
										<img title="<?php echo htmlspecialchars($bulk_filename); ?>" src="<?php echo $theme_path; ?>images/ico_6.png" alt="download" height="18" width="18" />
									</a>
								</div>
							<?php
							} elseif ($bulk_info->scan_file_status == "SCAN_FAILED") {
								echo str_replace('|filename|', splitFileNameTimestamp(htmlspecialchars($bulk_info->filename)), variable_get('threat_detected'));
							} else {
								echo str_replace('|filename|', splitFileNameTimestamp(htmlspecialchars($bulk_info->filename)), variable_get('in_progress'));
							}
							?>
						</div>
					</div>

					<div class="clearboth">&nbsp;</div>
					<div class="reg_labl">
						<label>Download Details :</label>
					</div>
					<div class="reg_inpt">
						<span style="float:right; line-height:20px;">
							<?php
							if (is_vwr_user_role() && $bulk_total > 0) {
							?>
								<a href="javascript:void(0);" class="repDownloadExport">Export</a>
							<?php
							}
							?>
						</span>
					</div>
					<div style="clear:both"></div>
					<div class="download_table">
						<div class="download_header">
							<?php
							if ($bulk_total > 10) {
								$width1 = "235px";
								$width2 = "230px";
								$width3 = "110px";
								$width4 = "93px";
								$close_css = ' ';
								$overfl_height = '';
							} else {
								$width1 = "235px";
								$width2 = "230px";
								$width3 = "110px";
								$width4 = "110px";
								$close_css = 'brdr_right';
								$overfl_height = 'height:auto; ';
							}
							?>
							<form name="bulk-reportexpo" id="bulk-reportexpo" action="" method="POST">
								<input type="hidden" id="selected_bulkreport" name="selected_bulkreport" value="<?php echo ($bulk_id && is_numeric($bulk_id)) ? $bulk_id : ''; ?>" />
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<thead>
										<tr class="table_head table_row">
											<th style="width:<?php echo $width1; ?>;">Downloaded By</th>
											<th style="width:<?php echo $width2; ?>;">Email Id</th>
											<th style="width:<?php echo $width3; ?>;">Date</th>
											<th style="width:110px; #width:<?php echo $width4; ?>;">Time &nbsp; &nbsp; </th>
										</tr>
									</thead>
								</table>
								<div class="download_list" style="<?php echo $overfl_height; ?>">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<?php
											foreach ($bulk_list as $bulk_item) {
												$records_count++;
											?>
												<tr class="table_row">
													<td style="width:<?php echo $width1; ?>; text-align:left"><?php echo $bulk_item->firstname . ' ' . $bulk_item->lastname; ?></td>
													<td style="width:<?php echo $width2; ?>; text-align:left" title="<?php echo $bulk_item->email ?>" alt="<?php echo $bulk_item->email; ?>">
														<?php echo (strlen($bulk_item->email) > 35) ? substr($bulk_item->email, 0, 35) . '..' : $bulk_item->email; ?>
													</td>
													<td style="width:<?php echo $width3; ?>;">
														<?php echo date('m/d/Y', $bulk_item->download_date); ?>
													</td>
													<td style="width:<?php echo $width4; ?>;" class="<?php echo $close_css; ?>">
														<?php echo date('G:i T', $bulk_item->download_date); ?>
													</td>
												</tr>
											<?php
											}
											?>
											<?php
											if ($records_count == 0) {
											?>
												<tr class="table_row">
													<td class="no_records brdr_right" colspan="11">No Records Found</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</form>
						</div>
					</div>

				</div>
			</form>
		</div>
	<?php
	} else {
		$_SESSION['error_content'] = " ";
		print theme('noaccess_error_theme', array('action' => '', 'level' => ''));
	}
	?>