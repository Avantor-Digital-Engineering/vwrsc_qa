<?php
	$close_css = '';
	$supplier_org_name = '';
	$where = '';
	if (!is_vwr_user_role()) {
		$timestamp = strtotime(date("m/d/Y"));
		$close_css = 'brdr_right ';
		$supplier_org_name = db_query("SELECT so.supplier_org_name FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid='" . $user->uid . "' AND so.deleted='0'")->fetchColumn();
		$where = " so.supplier_org_name = '" . $supplier_org_name . "' AND b.expiry_date >= $timestamp AND ";
	}
	$records_count = 0;
	$bulk_title = addslashes(trim($_POST['bulk_title']));
	$bulk_sorg = addslashes(trim($_POST['bulk_sorg']));

	$theme_path = base_path() . drupal_get_path('theme', 'vwr') . '/';
	$qry_str = '';
	if ($bulk_title) {
		$qry_str .= " title LIKE '$bulk_title%' AND ";
	}
	if ($bulk_sorg) {
		$qry_str .= " so.supplier_org_name LIKE '$bulk_sorg%' AND ";
	}
	if ($bulk_title == '' && $bulk_sorg == '' && $qry_str == '') {
		$page = trim($_POST['page_no']);
		if (!$page || !is_numeric($page)) {
			$page = pager_find_page();
		}
		$num_per_page = variable_get('usermanager_num_per_page', 10);
		$offset = $num_per_page * $page;
		$total = db_query("SELECT count(1) FROM {bulk_upload_list} AS b LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = b.supplier_org WHERE $where b.deleted='0' AND so.deleted='0'")->fetchColumn();
		pager_default_initialize($total, $num_per_page);
		$bulk_list = db_query("SELECT b.*, so.supplier_org_name AS supplier_org_name FROM {bulk_upload_list} AS b LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = b.supplier_org WHERE $where b.deleted='0' AND so.deleted='0' ORDER BY bulk_id DESC LIMIT $offset, $num_per_page");
	} else {
		$bulk_list = db_query("SELECT b.*, so.supplier_org_name AS supplier_org_name FROM {bulk_upload_list} AS b LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = b.supplier_org WHERE $qry_str $where b.deleted='0' AND so.deleted='0' ORDER BY bulk_id DESC "); //LIMIT $offset, $num_per_page
	}
	foreach ($bulk_list as $bulk_item) {
		$records_count++;
	?>
		<tr class="table_row">
			<?php
			if (is_vwr_user_role()) {
			?>
				<td height="20"><input type="checkbox" value="<?php echo $bulk_item->bulk_id; ?>" name="bulks[]" class="single-checkbox" /></td>
			<?php
			}
			?>
			<td class="submission-id-link">
				<a href="<?php echo base_path() . 'bulk/actions/download/' . $bulk_item->bulk_id; ?>" title="<?php echo function_exists('splitFileNameTimestamp') ? splitFileNameTimestamp($bulk_item->filename) : $bulk_item->filename; ?>">
					<?php
					echo (strlen($bulk_item->title) > 25) ? substr($bulk_item->title, 0, 23) . '..' : $bulk_item->title;
					?>
				</a>
			</td>
			<td title="<?php echo $bulk_item->department; ?>">
				<?php
				echo (strlen($bulk_item->department) > 16) ? substr($bulk_item->department, 0, 14) . '..' : $bulk_item->department;
				?>
			</td>
			<td>
				<?php echo date('m/d/Y', $bulk_item->created_date);	?>
			</td>
			<td class="<?php echo is_notexpired_date($bulk_item->expiry_date) ? '' : 'expiredItem'; ?>">
				<?php echo date('m/d/Y', $bulk_item->expiry_date); ?>
			</td>
			<?php
			if (is_vwr_user_role()) {
			?>
				<td title="<?php echo $bulk_item->supplier_org_name; ?>">
					<?php echo $bulk_item->supplier_org_name ? $bulk_item->supplier_org_name : 'N/A'; ?>
				</td>
			<?php
			}
			?>
			<td class="<?php echo $close_css; ?> downloaded_<?php echo $bulk_item->bulk_id; ?>">
				<span>
					<?php
					if (is_vwr_user_role()) {
						$bulk_hist = db_query("SELECT i.firstname, i.lastname, i.email, h.download_date FROM {bulk_upload_history} AS h LEFT JOIN {users_info} AS i ON i.uid = h.user_id WHERE h.bulk_id= '" . $bulk_item->bulk_id . "' AND h.deleted='0' ORDER BY h.download_date DESC")->fetchObject();
					} else if ($supplier_org_name) {
						$bulk_hist = db_query("SELECT i.firstname, i.lastname, i.email, h.download_date FROM {bulk_upload_history} AS h LEFT JOIN {bulk_upload_list} AS l ON l.bulk_id = h.bulk_id LEFT JOIN {users_info} AS i ON i.uid = h.user_id LEFT JOIN {users_roles} AS r ON r.uid = h.user_id WHERE l.supplier_org = '" . $supplier_org_name . "' AND h.bulk_id='" . $bulk_item->bulk_id . "' AND r.rid =(SELECT rid FROM {role} WHERE name='supplier')  AND h.deleted='0'  ORDER BY h.download_date DESC")->fetchObject();
					}
					$hist_downloaded_user = $bulk_hist->firstname . ' ' . $bulk_hist->lastname;
					echo trim(htmlspecialchars($hist_downloaded_user)) ? htmlspecialchars($hist_downloaded_user) . ' <br />(' . date('m/d/Y', htmlspecialchars($bulk_hist->download_date)) . ')' : 'None';
					?>
				</span>
			</td>

			<td class="brdr_right" style="min-width:55px">
				<a href="<?php echo base_path() . 'bulk/view/' . $bulk_item->bulk_id; ?>" style="margin-right:4px;">
					<img src="<?php echo $theme_path; ?>images/view_ico.png" alt="View" title="<?php echo is_vwr_user_role() ? 'View Bulk Upload' : 'Report details'; ?>" />
				</a>
				<?php
				if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
				?>
					<a href="<?php echo base_path() . 'bulk/create/' . $bulk_item->bulk_id; ?>">
						<img src="<?php echo $theme_path; ?>images/edit_ico.png" width="15" height="16" alt="edit" title="Edit" onClick="" />
					</a>
					<img src="<?php echo $theme_path; ?>images/ico_8.png" width="18" height="18" alt="delete" title="Delete" onClick="deleteAttachedBulk('bulk_id', '<?php echo $bulk_item->bulk_id; ?>');" />
				<?php
				}
				?>
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