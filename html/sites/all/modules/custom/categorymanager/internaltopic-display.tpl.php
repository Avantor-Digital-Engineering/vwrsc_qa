<?php drupal_add_js(drupal_get_path('module', 'categorymanager') . '/js/modalbox_dropbox.js');
	drupal_add_js(drupal_get_path('module', 'categorymanager') . '/js/jquery-ui.js');
	?>
	<?php
	$grand_parent_id = $parent_topic_id = $topic_id = $cat_id = 0;
	global $user;
	if (arg(7) && is_numeric(arg(7))) {
		$topic_id = arg(7);
	}
	if (arg(5) && is_numeric(arg(5))) {
		$parent_topic_id = arg(5);
	}
	if (arg(3) && is_numeric(arg(3))) {
		$grand_parent_id = arg(3);
	}
	if (arg(1) && is_numeric(arg(1))) {
		$cat_id = arg(1);
	}
	$record = get_topic_display_info($cat_id, $topic_id, $parent_topic_id);
	$currentregiontab = 0;
	if (isset($_COOKIE['currentregiontab'])) {
		$currentregiontab = addslashes(htmlspecialchars(trim($_COOKIE['currentregiontab'])));
	}
	$cookieprocessregions = '';
	$cookieprocessregions = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));
	$cookie_regions = array();
	$cookie_regions = explode(',', $cookieprocessregions);
	$category_regions = array();
	$category_regions = getcontentregionsforuseraccess($cat_id, $topic_id);
	if (empty($currentregiontab)) {

		$category_regionsprocess = array();

		if (!empty($category_regions)) {
			$category_regionsprocess = array_keys($category_regions);
			sort($category_regionsprocess, SORT_NUMERIC);

			foreach ($category_regionsprocess as $catindex => $region_id) {
				if (in_array($region_id, $cookie_regions)) {
					if (!is_vwr_user_role()) {
						$category_id = 0;
						if ($user->uid) {

							$resultset = db_query('SELECT so.supplier_org_id FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid =:uid', array(':uid' => $user->uid))->fetchObject();
						}
						$isglobal = 1;
						if ($resultset->supplier_org_id > 0) {
							$isglobal = get_global_supplier($resultset->supplier_org_id);
							if ($isglobal <= 1) {

								$subtopic_id =	getcontentregionaccess($cat_id, $topic_id, 3, $region_id, $resultset->supplier_org_id);
								if (empty($subtopic_id)) {
									continue;
								}
							}
						}
					}
					$currentregiontab = $region_id;
					break;
				}
			}
		}
	}
	if (!is_vwr_user_role()) {
		if (!check_category_topic_access($cat_id, $topic_id, $currentregiontab)) {
			drupal_goto('');
		}
	}
	$usertabpreferences = array();
	$usertabpreferences = getusertabpreference();
	if (is_vwr_user_role()) {
		if (count($category_regions) > 1) {
			if (!empty($usertabpreferences)) {
				if (count($cookie_regions) > 1) {
					if (!isset($_COOKIE['currentregiontab'])) {
						$currentregiontab = $usertabpreferences[0];
					}
				}
			}
		}
	} else {
		if ($isglobal > 1) {
			if (count($category_regions) > 1) {
				if (!empty($usertabpreferences)) {
					if (count($cookie_regions) > 1) {
						$currentregiontab = $usertabpreferences[0];
					}
				}
			}
		}
	}
	if (!empty($cookie_regions)) {
		if (!in_array($currentregiontab, $cookie_regions) && $currentregiontab) {
			drupal_goto('');
		}
	}


	if (!empty($category_regions) && !empty($currentregiontab)) {
		if (!in_array($currentregiontab, $category_regions)) {
			drupal_goto('');
		}
	}
	if (!empty($category_regions) && empty($currentregiontab)) {

		drupal_goto('');
	}
	if ($record) {
		$cat_name = db_query('SELECT category_name FROM {category} where category_id=:cat_id', array(':cat_id' => $cat_id))->fetchColumn();
		$parents = db_query('SELECT topic_name FROM {topic} where (topic_id=:topic_id OR topic_id=:parent_topic_id) && category_id=:cat_id ORDER BY topic_id ASC', array(':topic_id' => $grand_parent_id, ':parent_topic_id' => $parent_topic_id, ':cat_id' => $cat_id))->fetchColumn();
		$grand_parent_name = $parents[0];
		$parent_name = $parents[1];
		$parent_expiry = db_query('SELECT expiry_date FROM {topic} where topic_id=:topic_id && category_id=:cat_id', array(':topic_id' => $parent_topic_id, ':cat_id' => $cat_id))->fetchColumn();
		$themepath = base_path() . drupal_get_path('theme', 'vwr') . '/';
		$action_url = 'category/' . $cat_id . '/topic/' . $grand_parent_id . '/subtopic/' . $parent_topic_id;
		$create_access = has_page_access('create');
		$edit_access = has_page_access('edit');
		$_SESSION['google_analytics_page_name'] = $record->topic_name . ' Page';
	?>
		<link href="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/css/jquery-ui.css">
		<div class="right_cont">
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<a href="<?php echo base_path() . 'category/' . htmlspecialchars($cat_id); ?>"><?php echo (strlen($cat_name) > 25) ? substr(htmlspecialchars($cat_name), 0, 23) . '...' : htmlspecialchars($cat_name); ?></a>&gt;<a href="<?php echo base_path() . 'category/' . htmlspecialchars($cat_id) . '/topic/' . htmlspecialchars($grand_parent_id); ?>"><?php echo (strlen($grand_parent_name) > 25) ? substr(htmlspecialchars($grand_parent_name), 0, 23) . '...' : htmlspecialchars($grand_parent_name); ?></a>&gt;<a href="<?php echo base_path() . $action_url; ?>"><?php echo (strlen($parent_name) > 25) ? substr(htmlspecialchars($parent_name), 0, 23) . '...' : htmlspecialchars($parent_name); ?></a>&gt;<span><?php echo (strlen($record->topic_name) > 25) ? substr(htmlspecialchars($record->topic_name), 0, 23) . '...' : htmlspecialchars($record->topic_name); ?></span>
			</div>
			<div class="cat_cont">
				<div class="cat_top">
					<h3 class="<?php echo ($record->expiry_date < (strtotime(date("m/d/Y")))) ? 'doc_title_exp' : ''; ?>"><?php echo htmlspecialchars($record->topic_name); ?></h3>
					<?php if (user_access('add edit delete internaltopic') && $edit_access) { ?>
						<a onClick="editCategoryTopic('<?php echo $topic_id; ?>','internaltopic','<?php echo $action_url . '/internaltopic/edit/' . $topic_id; ?>');" href="javascript:void(0);"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="edit" /></a>
						<a href="javascript:void(0);" onClick="deleteCategoryTopic('<?php echo $topic_id; ?>','internaltopic','<?php echo $action_url; ?>');"><img src="<?php echo $themepath; ?>images/ico_8.png" width="18" height="19" alt="delete" /></a>
					<?php }
					if (user_access('add edit delete internaltopic')  && $create_access) { ?>
						<div class="acc_btn"><input type="submit" class="button" value="User Access" onClick="openUserAccess('<?php echo $cat_id; ?>', '<?php echo $topic_id; ?>', '<?php echo $parent_topic_id; ?>', 'internaltopic', '<?php echo $action_url . '/internaltopic/' . $topic_id; ?>');" /></div>
					<?php } ?>
				</div>

				<div class="cat_list">
					<div class="prod_img" file_id="<?php echo $record->scan_file_id;?>">
						<?php
						$imagepath = base_path() . variable_get('file_public_path', conf_path()) . '/files/topic/' . $record->topic_image;
						$imagepath = str_replace("/sites/default/files/files/", "/sites/default/files/", $imagepath);
						if ($record->scan_file_status == "SCAN_COMPLETED" || $record->scan_file_status == "") {
						?>
							<img alt="<?php echo htmlspecialchars($record->topic_image); ?>" title="internaltopic" src="<?php echo htmlspecialchars($imagepath); ?>" width="206" height="214" alt="<?php echo htmlspecialchars($record->topic_image); ?>" />
						<?php
						} elseif ($record->scan_file_status == "SCAN_FAILED") {
							echo str_replace('|filename|', htmlspecialchars($record->topic_image), variable_get('threat_detected'));
						} else {
							echo str_replace('|filename|', htmlspecialchars($record->topic_image), variable_get('in_progress'));
						}
						?>
					</div>
					<div class="cat_desc">
						<h2><?php echo htmlspecialchars($record->description_title); ?></h2>
						<div class="shw-catdesc-all">
							<?php
							$multidesc = db_query('select description from {subtopic_multi_description} where region_id=:currentregiontab and subtopic_id=:topic_id', array(':currentregiontab' => $currentregiontab, ':topic_id' => $topic_id))->fetchColumn();
							if ($multidesc == '') {
								$desc = $record->topic_description;
							} else {
								$desc = $multidesc;
							}
							$firstposition = substr($desc, 0, 1);
							if ($firstposition == ",") {
								$showdesc = substr($desc, 1, strlen($desc));
							} else {
								$showdesc = $desc;
							}
							if (is_vwr_user_role()) {
								$sortclass = "class='ui-state-default'";
								$sortul = "class='sortable'";
							}
							?>
							<p><?php echo trim(preg_replace('/\<(.*)script(.*)\>(.*)<\/script>/i', '', html_entity_decode($showdesc))); ?></p>
						</div>
						<input type="hidden" value="<?php echo ceil(($record->expiry_date - time()) / (60 * 60 * 24)); ?>" id="max_expiry_add" />
						<input type="hidden" value="<?php echo ceil(($parent_expiry - time()) / (60 * 60 * 24)); ?>" id="max_expiry_edit" />
						<input type="hidden" value="<?php echo $record->expiry_date ? date("m/d/Y", $record->expiry_date) : ''; ?>" id="page_expiry_add" />
						<input type="hidden" value="<?php echo $parent_expiry ? date("m/d/Y", $parent_expiry) : ''; ?>" id="page_expiry_edit" />
						<div class="file_str">
							<ul id="cat-topic-docs" <?php echo $sortul; ?>>
								<?php
								$total_docs = get_docs_totalcount($cat_id, $grand_parent_id, $parent_topic_id, $topic_id, $currentregiontab);
								$end = 5;
								$doc_list = get_docs_intial($cat_id, $grand_parent_id, $parent_topic_id, $topic_id, $currentregiontab);
								$fcount = $fid = 0;
								if ($doc_list) {
									foreach ($doc_list as $file) {
										$fid = $file->file_id;
										if (++$fcount == 1) {
											$first_id = $fid;
										}
										$file_type = $file->file_type;
										$image_icon = getFiletypeImage($file->file_name);

										$ga_name = addslashes(str_replace('"', '', $cat_name . ' > ' . $grand_parent_name . ' > ' . $parent_name . ' > ' . $record->topic_name));
										$ga_file_title = addslashes(str_replace('"', '', $file->file_title));
								?>
										<?php
										if (strpos($file->file_name, ".mp4") || strpos($file->file_name, ".webm")) { ?>
											<div class="ui-state-default">
												<div><?php echo $file->file_title; ?>
													<?php if (is_vwr_user_role()) { ?>
														<span style="float:right;">
															<a href="javascript:void(0);" onClick="editUploadDocuments('<?php echo $topic_id; ?>','internaltopic', '<?php echo $fid; ?>');"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="Edit" /></a>
															<a href="javascript:void(0);" onClick="updateDocuments('<?php echo $topic_id; ?>','internaltopic', '<?php echo $fid; ?>', 'delete');"><img src="<?php echo $themepath; ?>images/ico_8.png" width="18" height="19" alt="Delete" /></a>
														</span>
													<?php } ?>
												</div>

												<video width="100%" height="315" controls>
													<source src="<?php echo base_path(); ?>sites/default/files/docs/<?php echo $file->file_name; ?>" type="video/webm">
													<source src="<?php echo base_path(); ?>sites/default/files/docs/<?php echo $file->file_name; ?>" type="video/mp4">
												</video>
											</div>
										<?php } else { ?>
											<li <?php echo $sortclass; ?> id="itemorder_<?php echo $fid; ?>_1">
												<span class="file_ic">
													<img src="<?php echo $themepath; ?>images/<?php echo $image_icon; ?>" width="18" height="19" alt="<?php echo $file_type; ?>" />
													<?php
													if ($file->scan_file_status == "SCAN_COMPLETED" || $file->scan_file_status == "") {
													?>
														<span onClick="downloadUploadDocuments('<?php echo $topic_id; ?>','internaltopic', '<?php echo $fid; ?>');track_document_download('<?php print $ga_name; ?>', 'Download', '<?php print $ga_file_title; ?>');" class="<?php echo ($file->expiry_date < (strtotime(date("m/d/Y")))) ? 'doc_title_exp' : 'doc_title_downl'; ?>"><?php echo $file->file_title; ?></span>
													<?php
													} elseif ($file->scan_file_status == "SCAN_FAILED") {
														echo str_replace('|filename|', $file->file_title, variable_get('threat_detected'));
													} else {
														echo str_replace('|filename|', $file->file_title, variable_get('in_progress'));
													}
													?>
												</span>
												<span class="filedwn">
													<?php
													if (is_vwr_user_role()) {
													?>
														<img style="width:20px;height:20px" src="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/css/images/dragarrow.jpg">
													<?php }
													if ($file->scan_file_status == "SCAN_COMPLETED" || $file->scan_file_status == "") {
													?>
														<a href="javascript:void(0);" onClick="downloadUploadDocuments('<?php echo $topic_id; ?>','internaltopic', '<?php echo $fid; ?>');track_document_download('<?php print $ga_name; ?>', 'Download', '<?php print $ga_file_title; ?>');"><img src="<?php echo $themepath; ?>images/ico_6.png" width="18" height="19" alt="download" /></a>
													<?php
													}
													if (user_access('add edit delete internaltopic') && user_access('upload file to category topic') && $edit_access) {
													?>
														<a href="javascript:void(0);" onClick="editUploadDocuments('<?php echo $topic_id; ?>','internaltopic', '<?php echo $fid; ?>');"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="Edit" /></a>
														<a href="javascript:void(0);" onClick="updateDocuments('<?php echo $topic_id; ?>','internaltopic', '<?php echo $fid; ?>', 'delete');"><img src="<?php echo $themepath; ?>images/ico_8.png" width="18" height="19" alt="Delete" /></a>
													<?php
													} ?>
												</span>

											</li>
								<?php 		}
									}
								}
								?>
							</ul>
						</div>
						<div class="file_page">
							<?php if (user_access('add edit delete internaltopic') && user_access('upload file to category topic') && is_vwr_user_role() && $edit_access) { ?>
								<div class="upload_btn"><input type="submit" class="button" value="Upload Document" onClick="openUploadDocuments('<?php echo $topic_id; ?>','internaltopic','<?php echo $action_url . '/internaltopic/' . $topic_id; ?>', '<?php echo 'cat_id=' . $cat_id . '&top_id=' . $grand_parent_id . '&stop_id=' . $parent_topic_id . '&itop_id=' . $topic_id; ?>');" /></div>
							<?php }
							if ($fcount) {
							?>
								<div class="fl_pg">
									<input type="hidden" id="current_url" value="<?php echo $action_url . '/internaltopic/'; ?>" />
									<?php if ($total_docs > $end) { ?>
										<span class="viewall" id="viewall_docs"><a href="javascript:void(0);" onClick="showDocsPagination('<?php echo $topic_id; ?>', 'internaltopic', '<?php echo $fid; ?>', 'viewall');" id="viewall_a">View&nbsp;All</a></span>
									<?php } ?>
									<span class="pge">
										<span id="hide_start_cont" style="display:none;">
											<a class="sh_cursor" onClick="showDocsPagination('<?php echo $topic_id; ?>', 'internaltopic', '<?php echo $fid; ?>', 'first');"><img src="<?php echo $themepath; ?>images/older1.jpg" width="7" height="7" /></a>
											<a class="sh_cursor" onClick="showDocsPagination('<?php echo $topic_id; ?>', 'internaltopic', '<?php echo $fid; ?>', 'prev');"><img src="<?php echo $themepath; ?>images/prev1.jpg" width="7" height="7" /></a>
										</span>
										<a class="sh_cursor"><span id="current_records"><?php echo $fcount > 1 ? '<span id="first_doc_entry">1</span><span id="single_doc_entry">-<span id="last_doc_entry">' . htmlspecialchars($fcount) . '</span></span>' : '1'; ?></span></a>of<a class="sh_cursor"><span id="total_doc_count"><?php echo htmlspecialchars($total_docs); ?></span></a>
										<?php if ($total_docs > $end) { ?>
											<span id="hide_last_cont">
												<a class="sh_cursor" onClick="showDocsPagination('<?php echo $topic_id; ?>', 'internaltopic', '<?php echo $fid; ?>', 'next');"><img src="<?php echo $themepath; ?>images/next1.jpg" width="7" height="7" /></a>
												<a class="sh_cursor" onClick="showDocsPagination('<?php echo $topic_id; ?>', 'internaltopic', '<?php echo $fid; ?>', 'last');"><img src="<?php echo $themepath; ?>images/last1.jpg" width="7" height="7" /></a>
											</span>
										<?php } ?>
									</span>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="drp_cont">
					<h4><?php echo htmlspecialchars(getDropboxName()); ?></h4>
					<ul>
						<?php
						$array_order = array("active", "expired");
						foreach ($array_order as $end_date_sort) {
							$dropbox_list = get_related_dropbox($cat_id, $topic_id, $end_date_sort, $currentregiontab);
							if ($dropbox_list) {
								foreach ($dropbox_list as $dropbox) {
									if ((check_vwr_dropbox_access($dropbox->id) || $dropbox->allusers_page) && ((!is_vwr_user_role() && ($dropbox->end_date >= (strtotime(date("m/d/Y"))))) || is_vwr_user_role())) {
						?>
										<li>
											<a style="cursor:pointer;" onClick="Dropbox_Modalbox('file_upload','<?php echo base_path(); ?>','<?php echo htmlspecialchars($dropbox->id) ?>','<?php echo htmlspecialchars($cat_id); ?>','<?php echo htmlspecialchars($grand_parent_id); ?>','<?php echo htmlspecialchars($parent_topic_id); ?>','<?php echo htmlspecialchars($topic_id); ?>');" class="drop_ico"><img src="<?php echo $themepath; ?>images/dropbox_up_s.png" width="30" height="28" alt="" class="viewdpb_img" />
												<span><span class="drb_ttl <?php echo ($dropbox->end_date < (strtotime(date("m/d/Y")))) ? 'doc_title_exp' : ''; ?>"><?php echo htmlspecialchars($dropbox->title); ?></span></span></a>
											<?php if (user_access('add vwr dropbox') && has_page_access('dropbox')) { ?>
												<a href="<?php echo base_path() . 'vwr_dropbox/add_dropbox/' . htmlspecialchars($dropbox->id); ?>" class="drop_edit"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="edit" /></a>
											<?php } ?>
										</li>
						<?php 			}
								}
							}
						}
						?>
					</ul>
				</div>

				<div class="pro_tb">
					<?php
					$cat_topics = get_all_hyperlinks($cat_id, $grand_parent_id, $parent_topic_id, $topic_id, $currentregiontab);
					if ($cat_topics) {
						foreach ($cat_topics as $topic) {
							$hyperlinkimage = $topic->hyperlink_image;
							$hyperlink_id = $topic->hyperlink_id;

					?>


							<div class="tb_box" style="cursor:auto">
								<div class="tb_img">

									<?php
									$tbimagepath = base_path() . variable_get('file_public_path', conf_path()) . '/files/docs/' . $hyperlinkimage;
									$tbimagepath = str_replace("/sites/default/files/files/", "/sites/default/files/", $tbimagepath);
									if ($topic->scan_file_status == "SCAN_COMPLETED"  || $topic->scan_file_status == "") {
									?>
										<img title="hyperlink" src="<?php echo $tbimagepath; ?>" width="88" height="88" alt="<?php echo $hyperlinkimage; ?>" />
									<?php
									} elseif ($topic->scan_file_status == "SCAN_FAILED") {
										echo str_replace('|filename|', $hyperlinkimage, variable_get('threat_detected'));
									} else {
										echo str_replace('|filename|', $hyperlinkimage, variable_get('in_progress'));
									}
									?>
								</div>
								<h4 title="Asset Management"><?php echo $topic->hyperlink_name; ?>
									&nbsp;&nbsp;
									<?php if (is_vwr_user_role() && has_page_access('edit')) { ?>
										<a onClick="editHyperlinkCategory('<?php echo $cat_id; ?>','category','<?php echo 'hyperlink/edit/' . $hyperlink_id; ?>','<?php echo 'cat_id=' . $cat_id . '&top_id=' . $grand_parent_id . '&stop_id=' . $parent_topic_id . '&itop_id=' . $topic_id; ?>');" href="javascript:void(0);"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="edit" /></a>
										<a onClick="deleteHyperlinkCategory('<?php echo $hyperlink_id; ?>','hyperlink','')" href="javascript:void(0);"><img src="<?php echo $themepath; ?>images/ico_8.png" width="18" height="19" alt="delete" /></a>
									<?php } ?>

								</h4>
								<p class="topic_overview">Click here to visit <a href="<?php echo $topic->hyperlink_url; ?>" rel="noopener" target="_blank"><?php echo $topic->hyperlink_url; ?></a>.</p>
							</div>
					<?php
						}
					}

					?>
				</div>

				<?php if (is_vwr_user_role() && has_page_access('edit')) { ?> <div class="addtpc_btn"><input type="submit" class="button" value="Create Hyperlink" onClick="addHyperlink('<?php echo $topic_id; ?>','hyperlink','<?php echo 'category/' . $cat_id . '/hyperlink/topicid/' . $parent_topic_id . '/internaltopic/add'; ?>','<?php echo 'cat_id=' . $cat_id . '&top_id=' . $grand_parent_id . '&stop_id=' . $parent_topic_id . '&itop_id=' . $topic_id . "'"; ?>)" /></div>
				<?php } ?>

			</div>
		</div>
	<?php
	} else {
		$_SESSION['error_content'] = " ";
		print theme('noaccess_error_theme', array('action' => '', 'level' => 'subtopic'));
	}
	?>