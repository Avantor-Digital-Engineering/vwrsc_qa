<?php
	$records_count = 0;
	$sub_id = addslashes(htmlspecialchars(trim($_REQUEST['sub_id'])));
	$sub_id_repl = array('ID', 'I', 'SUB');
	$sub_id = str_replace($sub_id_repl, '', strtoupper($sub_id));
	$sub_title = addslashes(htmlspecialchars(trim($_REQUEST['sub_title'])));
	$dbox_title = addslashes(htmlspecialchars(trim($_REQUEST['dbox_title'])));
	$user_name = addslashes(htmlspecialchars(trim($_REQUEST['user_name'])));
	$user_sorg = addslashes(htmlspecialchars(trim($_REQUEST['user_sorg'])));
	$sub_status = addslashes(htmlspecialchars(trim($_REQUEST['sub_status'])));
	$sub_regions = addslashes(htmlspecialchars(trim($_REQUEST['sub_regions'])));
	$sub_modby = addslashes(htmlspecialchars(trim($_REQUEST['sub_modby'])));
	$dbox_selected = addslashes(htmlspecialchars(trim($_REQUEST['dbox_selected'])));
	$supl_user_id = addslashes(htmlspecialchars(trim($_REQUEST['supl_user_id'])));
	$qry_str = '';

	if ($sub_id && is_numeric($sub_id)) {
		$qry_str .= " vwrdf.submission_id LIKE '$sub_id%' AND ";
	} else if ($sub_id && !is_numeric($sub_id)) {
		$qry_str .= " vwrdf.submission_id LIKE '0' AND ";
	}
	if ($sub_title) {
		$qry_str .= " vwrdf.title LIKE '$sub_title%' AND ";
	}
	if ($sub_status) {
		$qry_str .= " vwrdf.status = '$sub_status' AND ";
	}

	if ($sub_modby) {
		$qry_str .= " vwrdf.modified_by IN (SELECT uid FROM {users_info} WHERE email LIKE '$sub_modby%') AND ";
	}
	if ($user_sorg) {		
		$qry_str .= " vwrdf.created_by IN (SELECT ui.uid FROM {users_info} as ui LEFT JOIN {supplier_organization} as sm ON sm.supplier_org_id = ui.supplier_org_name WHERE sm.supplier_org_name LIKE '$user_sorg%') AND ";
	}
	if ($user_name) {
		$qry_str .= " vwrdf.created_by IN (SELECT uid FROM {users_info} WHERE firstname LIKE '$user_name%') AND ";
	}
	if ($dbox_title) {
		$qry_str .= " vwrdf.dbox_id = '$dbox_title' AND ";
	} 
	$qry_archived = "";
	$archive_id = db_query("SELECT status_id FROM {manage_status} WHERE `status_name` = 'Archive'")->fetchColumn();
	if ($archive_id && !is_vwr_user_role()) {
		$qry_archived = " vwrdf.status != '$archive_id' AND ";
	}

	if ($sub_regions) {
		$region_str = ",{dropbox_regions} AS vwrdr where vwrdr.dropbox_id=vwrdf.dbox_id 
			AND 
			vwrdr.region_id in ($sub_regions) and";
	}
	if (!$sub_regions) {
		$condition = "where";
	}

	/*Pagination Continuation*/
	$total = db_query("SELECT count(submission_id) FROM {dropbox_files} as vwrdf 
		$region_str $condition $qry_str $qry_archived vwrdf.deleted=0 
		AND submission_id>0 ORDER BY submission_id DESC")->fetchColumn();
	if (!isset($_REQUEST["page"])) {
		$page = pager_find_page();
	} else {
		$page = addslashes(htmlspecialchars(trim($_REQUEST["page"])));
	}
	$num_per_page = variable_get('usermanager_num_per_page', 10);
	$offset = $num_per_page * $page;
	$submission_list = '';
	global $user;
	if ($supl_user_id && is_numeric($supl_user_id) && !is_vwr_user_role()) {

		$submission_list = db_query('SELECT * FROM {dropbox_files} as vwrdf ' . $region_str .
			$condition . $qry_str . $qry_archived . 'vwrdf.deleted=0 AND vwrdf.submission_id>0 AND 
			vwrdf.created_by=:supl_user_id ORDER BY vwrdf.submission_id DESC LIMIT ' . $offset . ', ' . $num_per_page . '', array(':supl_user_id' => $supl_user_id));
	} else if ($supl_user_id == 0 && is_numeric($supl_user_id) && !is_vwr_user_role()) {
		
		$user_supl_all = db_query('SELECT uid FROM {users_info} WHERE supplier_org_name = (SELECT supplier_org_name FROM {users_info} WHERE uid =:uid)', array(':uid' => $user->uid))->fetchColumn();
		$qry_supl_all = " vwrdf.created_by='$supl_user_id' ";
		if ($user_supl_all) {
			$user_suppliers = implode(',', $user_supl_all);
			$qry_supl_all = " vwrdf.created_by IN ($user_suppliers) ";
		}
		$submission_list = db_query("SELECT * FROM {dropbox_files} as vwrdf $region_str $condition 
			$qry_str $qry_archived vwrdf.deleted=0 AND vwrdf.submission_id>0 AND 
			$qry_supl_all ORDER BY vwrdf.submission_id DESC LIMIT $offset, $num_per_page");
	} else if (is_vwr_user_role()) {


		$submission_list = db_query("SELECT * FROM {dropbox_files} as vwrdf $region_str $condition $qry_str $qry_archived 
			vwrdf.deleted=0 AND vwrdf.submission_id>0 ORDER BY vwrdf.submission_id DESC LIMIT $offset, $num_per_page");
	} else {
		$submission_list = db_query('SELECT * FROM {dropbox_files} as vwrdf ' . $region_str . $condition
			. $qry_str . $qry_archived . 'vwrdf.deleted=0 AND vwrdf.submission_id>0 AND vwrdf.created_by=:uid 
			ORDER BY submission_id DESC LIMIT ' . $offset . ', ' . $num_per_page . '', array(':uid' => $user->uid));
	}

	if ($submission_list) {
		foreach ($submission_list as $submission_info) {
			$records_count++;
			$dropbox_info = db_query('SELECT title, link_workflow_tool FROM {dropbox} WHERE id=:dbox_id', array(':dbox_id' => $submission_info->dbox_id))->fetchObject();
			$dropbox_title = $dropbox_info->title;			
			$created_user_info = db_query('SELECT ui.firstname, ui.lastname, sm.supplier_org_name FROM {users_info} as ui LEFT JOIN {supplier_organization} as sm ON sm.supplier_org_id = ui.supplier_org_name  WHERE ui.uid=:crtby', array(':crtby' => $submission_info->created_by))->fetchObject();
			$modified_user_name = $modified_user_email = '';
			if ($submission_info->modified_by) {
				$modified_user_info = db_query('SELECT firstname, lastname, email FROM {users_info} WHERE uid=:modiby', array(':modiby' => $submission_info->modified_by))->fetchObject();
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
				<td class="submission-id-link" id="subm_tikid_<?php echo $submission_info->submission_id; ?>">
					<?php
					if ($submission_info->status != $archive_id) {
					?>
						<a href="<?php echo base_path() . 'vwr_dropbox/viewsubmission/' . base64_encode($submission_info->submission_id); ?>"><?php echo 'ID' . $submission_info->submission_id; ?></a>
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
					echo (strlen(htmlspecialchars($dropbox_title)) > $trimcnt) ? substr(htmlspecialchars($dropbox_title), 0, ($trimcnt - 2)) . '..' : htmlspecialchars($dropbox_title);
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
				$region_names = db_query('select region_id from {dropbox_regions} where dropbox_id=:dbox_id', array(':dbox_id' => $submission_info->dbox_id));
				$rnameslist = '';
				foreach ($region_names as $rnm) {
					$rnames = db_query('select region_shortname from {manage_regions} where region_id in (:region_id)', array(':region_id' => $rnm->region_id));
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
	<?php
		}
	}
	?>
	<?php
	if ($records_count == 0) { ?>
		<tr class="table_row">
			<td class="no_records brdr_right" colspan="11">No Submissions Found</td>
		</tr>
	<?php
	} else {
		$current_record_count = (($page + 1) * $num_per_page);
		$rec_starts = $current_record_count - ($num_per_page - 1);
		$startnumber = (($rec_starts != $total && $total) ? $rec_starts . '' : '');
		$lastnumber = ((($current_record_count < $total) && $current_record_count) ? $current_record_count : $total);
		$totalnumber = $total;
	?>
		<input type="hidden" id="startnumber" value="<?php echo $startnumber; ?>">
		<input type="hidden" id="lastnumber" value="<?php echo htmlspecialchars($lastnumber); ?>">
		<input type="hidden" id="totalnumber" value="<?php echo htmlspecialchars($total); ?>">
	<?php
	}
	?>