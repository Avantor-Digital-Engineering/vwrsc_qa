<style type="text/css">
	.comment_box_txt ul li.msg {
		width: 585px;
	}

	.comment_box_txt_link {
		width: 594px;
	}

	.reg_labl {
		padding-left: 18px;
		width: 128px;			
	}

	div table td.file-uploaded-name a,
	div table td.file-uploaded-name,
	span.viewall a {
		color: #4B4A4A;
		cursor: pointer;
		font-size: 12px;
		line-height: 22px;
		text-decoration: underline;
	}

	#current_records,
	#total_comment_count {
		color: #4B4A4A;
	}

	table.comments-attached-links {
		margin-left: 120px;
	}

	.shw-catdesc-all p {
		line-height: 18px;
	}

	.shw-catdesc-all ul {
		list-style: disc outside none;
		padding: 4px 0 5px 25px;
	}

	.shw-catdesc-all ol {
		list-style: decimal outside none;
		padding: 4px 0 5px 26px;
	}

	table .downloadall td a {
		margin: 10px 2px;
		text-decoration: underline;
	}
</style>
	<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox.js"></script>
	<?php
	global $user;
	$_SESSION['google_analytics_page_name'] = "Submission Details Page";
	$module_path = base_path() . drupal_get_path('module', 'vwr_dropbox') . '/';
	$theme_path = base_path() . drupal_get_path('theme', 'vwr') . '/';
	//$temp_sub_id = trim(arg(2));
	$temp_sub_id = base64_decode(trim(arg(2)));
	if ($temp_sub_id && is_numeric($temp_sub_id)) {
		$dbox_tic_id = $temp_sub_id;
	} else {
		$temp_sub_id = trim(arg(2)) . trim(arg(3)) . trim(arg(4)) . trim(arg(5));
		$temp_sub_id = base64_decode(trim($temp_sub_id));
		if ($temp_sub_id && is_numeric($temp_sub_id)) {
			$dbox_tic_id = $temp_sub_id;
		}
	}
	$submission_info = '';
	if ($dbox_tic_id && is_numeric($dbox_tic_id)) {
		$qry_archived = "";
		$archive_id = db_query("SELECT status_id FROM {manage_status} WHERE `status_name` = 'Archive'")->fetchColumn();
		$query_param = [':dbox_tic_id' => $dbox_tic_id];
		if ($archive_id && !has_page_access('submissions')) {
			$qry_archived = " AND status != :archive_id ";
			$query_param = array_merge($query_param, [':archive_id' => $archive_id]);
		}
		if (is_vwr_user_role()) {
			$submission_info = db_query("SELECT id, dbox_id, title, message, vendor_no, file, created_by, created_date FROM {dropbox_files} WHERE submission_id=:dbox_tic_id AND deleted='0' $qry_archived ", $query_param)->fetchObject();
		} else if (view_team_access($user->uid)) {
			$user_supl_all = db_query("SELECT uid FROM {users_info} WHERE supplier_org_name = (SELECT supplier_org_name FROM {users_info} WHERE uid = :uid )", ['uid' => $user->uid])->fetchCol();
			$qry_supl_all = '';
			if ($user_supl_all) {
				$user_suppliers = implode(',', $user_supl_all);
				$qry_supl_all = " AND created_by IN ($user_suppliers) ";
				//$query_param = array_merge($query_param, [':user_suppliers' => $user_suppliers]);
				
			}
			$submission_info = db_query("SELECT id, dbox_id, title, message, vendor_no, file, created_by, created_date FROM {dropbox_files} WHERE submission_id=:dbox_tic_id and deleted='0' $qry_archived $qry_supl_all", $query_param)->fetchObject();
		} else {
			$query_param = array_merge($query_param, [':uid' => $user->uid]);
			$submission_info = db_query("SELECT id, dbox_id, title, message, vendor_no, file, created_by, created_date FROM {dropbox_files} WHERE submission_id=:dbox_tic_id and deleted=0 AND created_by = :uid $qry_archived ", $query_param)->fetchObject();
		}
	}
	if ($submission_info) {

		$user_info = db_query("SELECT ui.firstname, ui.lastname, ui.email, sm.supplier_org_name FROM {users_info} as ui LEFT JOIN {supplier_organization} as sm ON sm.supplier_org_id = ui.supplier_org_name WHERE ui.uid=:created_by", [':created_by' => $submission_info->created_by])->fetchObject();
		$dropbox_info = db_query("SELECT title, link_workflow_tool, workflow_email_id, deleted, end_date FROM {dropbox} WHERE id=:dbox_id", [':dbox_id' => $submission_info->dbox_id])->fetchObject();
		$dropbox_name = $dropbox_info->title;
		$isworkflowlink = $dropbox_info->link_workflow_tool;
		$workflowEmail = trim($dropbox_info->workflow_email_id);
		$comBySupplier = true;
		if ($dropbox_info->deleted || ($dropbox_info->end_date < strtotime(date("m/d/Y"))) || !checkSupplierSubmDropbox($submission_info->dbox_id)) {
			$comBySupplier = false;
		}
		$userfullname = $user_info->firstname . ' ' . $user_info->lastname;
	?>
		<div class="right_cont">
			<div class="submdet_head">
				<h3>Submission Details</h3>
				<span class="topicon">
					<a href="javascript:void(0);">
						<?php
						if (is_vwr_user_role()) {
						?>
							<img src="<?php echo htmlspecialchars($module_path); ?>images/ico_7.png" alt="Edit" onClick="editSubmissionInfo('<?php echo htmlspecialchars($submission_info->id); ?>', 'filedocs', '<?php echo htmlspecialchars($dbox_tic_id); ?>');" />
						<?php
						}
						?>
					</a>
					<a href="javascript:void(0);">
						<?php
						if (has_page_access('submissions')) {
						?>
							<img src="<?php echo htmlspecialchars($module_path); ?>images/delt_icon.png" alt="Delete" onClick="Delete_Dropbox_Files('<?php echo htmlspecialchars(base_path()); ?>','<?php echo htmlspecialchars($submission_info->id); ?>','<?php echo htmlspecialchars($submission_info->dbox_id); ?>');" />
						<?php
						}
						?>
					</a>


					<?php
					if (has_page_access('move_submissions')) {
					?><!--a href="<1?php echo base_path() . 'vwr_dropbox/movesubmissions/' . arg(2); ?>"-->
						<a href="<?php echo base_path() . 'vwr_dropbox/movesubmissions/' . $dbox_tic_id; ?>">
							<img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/dropbox_up_s.png" width="20" height="20" alt="Move Submissions" title="Move Submissions" />
						</a>
					<?php
					}
					?>


				</span>
			</div>
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<a href="<?php echo base_path() . 'ticketmanager/ticketsoverview'; ?>">Submissions Overview</a>&gt;<span>Submission Details</span>
			</div>

			<div class="submdet_det">
				<div class="submdet_det_cont1">
					<div class="submdet_det_cont1_head">Submission ID</div>
					<div class="submdet_det_cont1_text"><?php echo 'ID' . $dbox_tic_id; ?></div>
					<div class="submdet_det_cont1_head">Supplier Org</div>
					<div class="submdet_det_cont1_text" title="<?php echo htmlspecialchars($user_info->supplier_org_name); ?>"><?php echo $user_info->supplier_org_name ? (strlen($user_info->supplier_org_name) > 10) ? substr(htmlspecialchars($user_info->supplier_org_name), 0, 8) . '..' : htmlspecialchars($user_info->supplier_org_name) : "N/A"; ?></div>
				</div>
				<div class="submdet_det_cont2">
					<div class="submdet_det_cont2_head">Submission Date</div>
					<div class="submdet_det_cont2_text"><?php echo date('m/d/Y', $submission_info->created_date); ?></div>
					<div class="submdet_det_cont2_head">Vendor No</div>
					<div class="submdet_det_cont2_text"><?php echo $submission_info->vendor_no ? htmlspecialchars($submission_info->vendor_no) : "N/A"; ?></div>
				</div>
				<div class="submdet_det_cont3">
					<div class="submdet_det_cont3_head">Submitted By</div>
					<div class="submdet_det_cont3_text" title="<?php echo htmlspecialchars($userfullname) . ' - ' . htmlspecialchars($user_info->email); ?>"><?php echo (strlen($userfullname) > 17) ? substr(htmlspecialchars($userfullname), 0, 15) . '..' : htmlspecialchars($userfullname); ?></div>
					<div class="submdet_det_cont3_head">Drop Box</div>
					<div class="submdet_det_cont3_text" title="<?php echo htmlspecialchars($dropbox_name); ?>"><?php echo (strlen($dropbox_name) > 17) ? substr(htmlspecialchars($dropbox_name), 0, 15) . '..' : htmlspecialchars($dropbox_name); ?></div>
				</div>
			</div>
			<div class="reg_form">
				<div class="error" style="display:none"></div>
				<div class="reg_labl">
					<label>Title :</label>
				</div>
				<div class="reg_inpt" style="padding-top:7px;">
					<span><?php echo trim(stripslashes($submission_info->title)); ?></span>
				</div>
				<div class="clearboth"></div>
				<div class="reg_labl">
					<label>Message :</label>
				</div>
				<div class="reg_inpt" style="padding-top:6px;">
					<span class="shw-catdesc-all"><?php echo trim(preg_replace('/\<(.*)script(.*)\>(.*)<\/script>/i', '', $submission_info->message));?></span>
				</div>
				<div class="clearboth"></div>
				<div id="file_multidocs">
					<div class="reg_labl">
						<label>Documents :</label>
					</div>
					<div class="reg_inpt_new">
						<table>
							<?php
							$multdocs_count = 0;
							if (!is_numeric($submission_info->file) && $submission_info->file) {
								$multdocs_count++; // need to delete this if showing existing files as per phase1;
							?>
								<tr>
									<td class="file-uploaded-name">
										<a href="javascript:void(0);" onClick="window.open('<?php echo base_path(); ?>sites/default/files/docs_dropbox/<?php echo htmlspecialchars($submission_info->file); ?>','_blank')"><?php echo htmlspecialchars($submission_info->file); ?></a>
									</td>
									<td>
										<a href="javascript:void(0);" onClick="downloadUploadfiles(<?php echo htmlspecialchars($submission_info->id); ?>,'viewdropboxfiles');">
											<img src="<?php echo $theme_path; ?>images/ico_6.png" alt="Download" />
										</a>
										<a href="javascript:void(0);" onclick="">
											<img src="<?php echo $module_path; ?>images/ico_8.png" alt="Delete" />
										</a>
									</td>
								</tr>
								<?php
							}
							$docs_attached = db_query("SELECT id, file_name, scan_file_id, scan_file_status FROM {submission_files} WHERE submission_id=:dbox_tic_id AND source='submission' AND deleted=0", [':dbox_tic_id' => $dbox_tic_id]);
							if ($docs_attached) {
								foreach ($docs_attached as $filedoc) {
								?>
									<tr file_id="<?php echo $filedoc->scan_file_id;?>">
										<?php
										if ($filedoc->scan_file_status == "SCAN_COMPLETED" || $filedoc->scan_file_status == "") {
											$multdocs_count++;
											$ga_name = "Submission-".addslashes(str_replace('"', '', $submission_info->title));
											$ga_file_title = addslashes(str_replace('"', '', $filedoc->file_name));
										?>
											<td class="file-uploaded-name">
												<a title="<?php echo $filedoc->file_name; ?>" href="javascript:void(0);" onClick="downloadSubmissionfiles(<?php echo $filedoc->id; ?>,'filedocs', '<?php echo $dbox_tic_id; ?>');track_document_download('<?php print $ga_name; ?>', 'Download', '<?php print $ga_file_title; ?>')"><?php echo (strlen($filedoc->file_name) > 50) ? substr($filedoc->file_name, 0, 48) . '..' : $filedoc->file_name; ?></a>
											</td>
											<td>
												<span>
													<a href="javascript:void(0);" onClick="downloadSubmissionfiles(<?php echo $filedoc->id; ?>,'filedocs', '<?php echo $dbox_tic_id; ?>');track_document_download('<?php print $ga_name; ?>', 'Download', '<?php print $ga_file_title; ?>');">
														<img src="<?php echo $theme_path; ?>images/ico_6.png" alt="Download" />
													</a>
												</span>
												<?php
												if (has_page_access('submissions')) {
												?>
													<span>
														<a href="javascript:void(0);" onclick="deleteAttachments('<?php echo $filedoc->id; ?>', '<?php echo 'filedocs'; ?>', '<?php echo $dbox_tic_id; ?>');">
															<img src="<?php echo $module_path; ?>images/ico_8.png" alt="Delete" />
														</a>
													</span>
												<?php
												}
												?>
											</td>
										<?php
										} elseif ($filedoc->scan_file_status == "SCAN_FAILED") {
											echo "<tr><td class='file-uploaded-name'>" . str_replace('|filename|', $filedoc->file_name, variable_get('threat_detected')) . "</td></tr>";
										} else {
											echo "<tr><td class='file-uploaded-name'>" . str_replace('|filename|', $filedoc->file_name, variable_get('in_progress')) . "</td></tr>";
										}
										?>
									</tr>
								<?php
								}
							}
							if ($multdocs_count == 0) {
								?>
								<tr class="downloadall">
									<td><br />
										<a href="javascript:void(0);">No Documents Attached</a>
									</td>
								</tr>
							<?php
							} else if ($multdocs_count > 1) {
							?>
								<tr class="downloadall">
									<td><br />
										<a href="javascript:void(0);" onClick="downloadAllSubfiles('all','filedocs', '<?php echo $dbox_tic_id; ?>');">Download All</a>
									</td>
								</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>

				<div class="submdet_det_comments">
					<?php
					if ((is_vwr_user_role() && !$isworkflowlink) || (!is_vwr_user_role() && is_supplier_comment_block($dbox_tic_id) && has_submission_change_access($dbox_tic_id) && $comBySupplier)) { //comp, den, canceld
					?>
						<a class="addcomment" href="javascript:void(0);" onClick="openDropboxAddComments('<?php echo htmlspecialchars($dbox_tic_id); ?>', '<?php echo htmlspecialchars($isworkflowlink); ?>');">Add Comments</a>
						<input type="hidden" id="is_workflow_linked" name="is_workflow_linked" value="<?php echo $isworkflowlink ? htmlspecialchars($isworkflowlink) : ''; ?>" />
					<?php
					}
					?>
				</div>
				<div id="sub-comments-holder">
					<?php
					$end = 5;
					$comment_no_count = $cid = 0;
					$comment_no = db_query("SELECT count(1) AS cnt FROM {submission_comments} WHERE submission_id=:dbox_tic_id AND deleted='0' AND (comments!='' OR from_status!='') ORDER BY id DESC", [':dbox_tic_id' => $dbox_tic_id]);
					foreach ($comment_no as $cmnt) {
						$comment_no = $cmnt->cnt;
					}
					$total_comments_count = $comment_no;
					$all_comments = db_query("SELECT * FROM {submission_comments} WHERE submission_id=:dbox_tic_id AND deleted='0' AND (comments!='' OR from_status!='') ORDER BY id DESC limit 0, $end", [':dbox_tic_id' => $dbox_tic_id]);
					if ($all_comments) {
						$comment_no = $total_comments_count;
						foreach ($all_comments as $comment) {
							if ($comment_no_count++ == $end) {
								break;
							}
							$cid = $comment->id;
							$created_user = db_query("SELECT firstname, lastname, email, supplier_org_name FROM {users_info} WHERE uid=:created_by", [':created_by' => $comment->created_by])->fetchObject();
							$comment_attachments = db_query("SELECT id, file_name, scan_file_id, scan_file_status FROM {submission_files} WHERE submission_id=:dbox_tic_id AND source='comments' AND comment_id=:cid AND deleted='0'", [':dbox_tic_id' => $dbox_tic_id, ':cid' => $cid]);
							$commented_uname = trim($created_user->firstname . ' ' . $created_user->lastname);

							$external_email = trim($comment->group_email_id);
							$group_email_name = '';
							if ($external_email && $comment->created_by <= 1 && !$commented_uname) {
								if ($isworkflowlink && $external_email == $workflowEmail) {
									$group_email_name = 'Admin';
								} else {
									$group_email_name = 'VWR';
								}
							}
							$display_uname = $commented_uname ? $commented_uname : ($group_email_name ? $group_email_name : 'VWR');
							$display_email = trim($created_user->email) ? $created_user->email : ($external_email ? $external_email : 'VWRsuppliercentral@vwr.com');
					?>
							<div class="submdet_det_comments">
								<div class="comment_box">
									<div class="comment_box_txt">
										<ul>
											<li class="title">Comment <?php echo htmlspecialchars($comment_no--); ?></li>
											<li class="normal" title="<?php echo htmlspecialchars($display_uname); ?>">
												<?php
												if ($display_uname) {
													echo (strlen($display_uname) > 22) ? substr(htmlspecialchars($display_uname), 0, 20) . '..' : htmlspecialchars($display_uname);
												} else {
													echo 'VWR';
												}
												echo ' | ';
												?>
											</li>
											<li class="normal" title="<?php echo htmlspecialchars($display_email); ?>">
												<?php
												if ($display_email) {
													echo (strlen($display_email) > 32) ? substr(htmlspecialchars($display_email), 0, 30) . '..' : htmlspecialchars($display_email);
												} else {
													echo 'VWRsuppliercentral@vwrsuppliercentral.com';
												}
												?>
											</li>
											<li class="normal"><?php echo $comment->created_date ? ' | ' . date("m/d/Y, G:i:s T", $comment->created_date) : ''; ?></li>
											<li class="flor">
												<span>
													<?php
													if (has_page_access('submissions')) {
													?>
														<a href="javascript:void(0);" onClick="deleteSubmissionEle('<?php echo $cid; ?>', 'comment', '<?php echo $dbox_tic_id; ?>');"><img src="<?php echo $module_path; ?>images/ico_8.png" alt="Delete" /></a>
													<?php
													}
													?>
												</span>
											</li>
										</ul>
									</div>
									<div class="comment_box_txt">
										<ul>
											<li class="title">Message</li>
											<li class="msg">
												<?php
												if (($comment->from_status != $comment->status) && $comment->from_status) {
													echo ($comment->comments ? htmlspecialchars(rtrimStringLines($comment->comments)) . "<br /><br />" : "") . "Status Changed From " . htmlspecialchars(getFullStatusName($comment->from_status)) . " To " . htmlspecialchars(getFullStatusName($comment->status));
												} else {
													echo rtrimStringLines($comment->comments);
												}
												?>
											</li>
										</ul>
									</div>

									<table class="comments-attached-links">
										<?php
										if ($comment_attachments) {
											foreach ($comment_attachments  as $comment_attached) {
												$comment_file_attached = substr($comment_attached->file_name, (stripos($comment_attached->file_name, '_') + 1), strlen($comment_attached->file_name));

										?>
												<tr file_id="<?php echo $comment_attached->scan_file_id;?>">
													<?php
													if ($comment_attached->scan_file_status == "SCAN_COMPLETED"  || $comment_attached->scan_file_status == "") {
													?>
														<td class="file-uploaded-name" href="javascript:void(0);" title="<?php echo $comment_file_attached; ?>" onClick="downloadAttchedFiles('<?php echo $comment_attached->id; ?>','comments', '<?php echo $dbox_tic_id; ?>');"><?php echo (strlen($comment_file_attached) > 50) ? substr($comment_file_attached, 0, 48) . '..' : $comment_file_attached; ?></td>
														<td>
															<a href="javascript:void(0);" onClick="downloadAttchedFiles('<?php echo $comment_attached->id; ?>','comments', '<?php echo $dbox_tic_id; ?>');">
																<img src="<?php echo $theme_path; ?>images/ico_6.png" alt="Download" />
															</a>
														</td>
													<?php
													} elseif ($comment_attached->scan_file_status == "SCAN_FAILED") {
														echo "<td>" . str_replace('|filename|', $comment_file_attached, variable_get('threat_detected')) . "</td>";
													} else {
														echo "<td>" . str_replace('|filename|', $comment_file_attached, variable_get('in_progress')) . "</td>";
													}
													?>
												</tr>
										<?php
											}
										}
										?>
									</table>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
				<div class="submdet_det_comments">
					<div class="subdet_okbtn"><input type="submit" class="button" value="Back" onClick="window.open('<?php echo base_path(); ?>ticketmanager/ticketsoverview','_self')" /></div>
					<?php
					if ($comment_no_count) {
					?>
						<div class="subdet_pgn">
							<div class="fl_pg">
								<span class="pge">
									<?php
									if ($total_comments_count > $end) {
									?>
										<span id="hide_start_cont" style="display:none;">
											<a class="sh_cursor" onClick="showCommentsPagination('<?php echo $dbox_tic_id; ?>', '', '<?php echo $cid; ?>', 'first');"><img src="<?php echo $theme_path; ?>images/older1.jpg" width="7" height="7" /></a>&nbsp;<a class="sh_cursor" onClick="showCommentsPagination('<?php echo $dbox_tic_id; ?>', '', '<?php echo $cid; ?>', 'prev');"><img src="<?php echo $theme_path; ?>images/prev1.jpg" width="7" height="7" /></a>
										</span>
										<a class="sh_cursor"><span id="current_records"><?php echo $comment_no_count > 1 ? '<span id="first_comment_entry">1</span><span id="single_comment_entry">-<span id="last_comment_entry">' . htmlspecialchars($comment_no_count) . '</span></span>' : '1'; ?></span></a>&nbsp;of&nbsp;<a class="sh_cursor"><span id="total_comment_count"><?php echo htmlspecialchars($total_comments_count); ?></span></a>
										<?php
										if ($total_comments_count > $end) {
										?>
											<span id="hide_last_cont">
												<a class="sh_cursor" onClick="showCommentsPagination('<?php echo $dbox_tic_id; ?>', '', '<?php echo $cid; ?>', 'next');"><img src="<?php echo $theme_path; ?>images/next1.jpg" width="7" height="7" /></a>&nbsp;<a class="sh_cursor" onClick="showCommentsPagination('<?php echo $dbox_tic_id; ?>', '', '<?php echo $cid; ?>', 'last');"><img src="<?php echo $theme_path; ?>images/last1.jpg" width="7" height="7" /></a>
											</span>
										<?php
										}
										if ($total_comments_count > $end) {
										?>
											<span class="viewall" style="margin:0px 30px;" id="viewall_comments"><a href="javascript:void(0);" onClick="showCommentsPagination('<?php echo $dbox_tic_id; ?>', '', '<?php echo $cid; ?>', 'viewall');" id="viewall_a">View&nbsp;All</a></span>
									<?php
										}
									}
									?>
								</span>
							</div>
						</div>
						<div class="subdet_addcomm" style="float:right; width:120px;">
							<?php
							if ((is_vwr_user_role() && !$isworkflowlink) || (!is_vwr_user_role() && has_submission_change_access($dbox_tic_id) && $comBySupplier)) {
							?>
								<a href="javascript:void(0);" onClick="openDropboxAddComments('<?php echo htmlspecialchars($dbox_tic_id); ?>', '<?php echo htmlspecialchars($isworkflowlink); ?>');">Add Comments</a>
							<?php
							}
							?>
						</div>
					<?php
					}
					?>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
	<?php
	} else {
		$_SESSION['error_content'] = " ";
		print theme('noaccess_error_theme', array('action' => '', 'level' => 'submission'));
	}
	?>