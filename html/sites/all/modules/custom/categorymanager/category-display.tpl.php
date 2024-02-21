<?php
	drupal_add_js(drupal_get_path('module', 'categorymanager') . '/js/modalbox_dropbox.js');
	drupal_add_js(drupal_get_path('module', 'categorymanager') . '/js/jquery-ui.js');
	$cat_id = 0;
	if (arg(1) && is_numeric(base64_decode(arg(1)))) {
		$cat_id = trim(base64_decode(arg(1)));
	}
	global $user;
	$timestamp = strtotime(date("d-m-Y"));
	$record = '';
	$currentregiontab = 0;
	if (isset($_COOKIE['currentregiontab']) && is_numeric($_COOKIE['currentregiontab'])) {
		$currentregiontab = htmlspecialchars(addslashes(trim($_COOKIE['currentregiontab'])));
	}
	if (empty($currentregiontab)) {
		$category_regions = array();
		$category_regionsprocess = array();
		$category_regions = getcategoryregions($cat_id);
		if (!empty($category_regions)) {
			$category_regionsprocess = array_keys($category_regions);
			sort($category_regionsprocess, SORT_NUMERIC);
			$cookieprocessregions = '';
			$cookieprocessregions = addslashes(strip_tags($_COOKIE['cookieregion_name']));
			$cookie_regions = array();
			$cookie_regions = explode(',', $cookieprocessregions);
			foreach ($category_regionsprocess as $catindex => $region_id) {
				if (in_array($region_id, $cookie_regions)) {
					if (!is_vwr_user_role()) {
						$category_id = 0;
						if ($user->uid) {

							$resultset = db_query('SELECT so.supplier_org_id FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid = :uid', array(':uid' => $user->uid))->fetchObject();
						}
						$isglobal = 1;
						if ($resultset->supplier_org_id > 0) {
							$isglobal = get_global_supplier($resultset->supplier_org_id);
							if ($isglobal <= 1) {
								$category_id =	getcontentregionaccess($cat_id, 0, 0, $region_id, $resultset->supplier_org_id);
								if (empty($category_id)) {
									continue;
								}
							}
						}
					}
					$currentregiontab = $region_id;
					break;
				}
			}
			$usertabpreferences = array();
			$usertabpreferences = getusertabpreference();
			if (is_vwr_user_role()) {
				if (count($category_regions) > 1) {
					if (!empty($usertabpreferences)) {
						if (count($cookie_regions) > 1) {
							$currentregiontab = $usertabpreferences[0];
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
		}
	}
	$categoryregions = array();
	$categoryregions = Iscategoryregionaccess($cat_id, $currentregiontab);
	
	if (empty($categoryregions)) {
		drupal_goto('');
	}
	if (!is_vwr_user_role()) {
		if (!check_category_topic_access($cat_id, 0, $currentregiontab)) {
			drupal_goto('');
		}
	}
	if (!empty($cookie_regions)) {
		if (!in_array($currentregiontab, $cookie_regions) && $currentregiontab) {
			drupal_goto('');
		}
	}
	if (is_vwr_user_role()) {
		$record = db_query('SELECT cat.category_name,cat.description_title, 
		vwrmd.description as category_description,cat.category_image, 
		cat.category_status, cat.expiry_date, cat.scan_file_id, cat.scan_file_status FROM {category} as cat LEFT JOIN {multi_description} as vwrmd on vwrmd.category_id=cat.category_id and vwrmd.region_id in (:currentregiontab)
		where cat.category_id = :cat_id && cat.category_status=1', array(':currentregiontab' => $currentregiontab, ':cat_id' => $cat_id))->fetchObject();
	} else {
		$record = db_query('SELECT cat.category_name,cat.description_title,vwrmd.description as category_description,cat.category_image,cat.category_status,
		cat.expiry_date, cat.scan_file_id, cat.scan_file_status FROM {category} as cat LEFT JOIN {multi_description} as vwrmd on vwrmd.category_id=cat.category_id and vwrmd.region_id in (:currentregiontab) 
		where cat.category_id = :cat_id && 
		cat.category_status=1 && cat.expiry_date>=:expirydt', array(':currentregiontab' => $currentregiontab, ':cat_id' => $cat_id, ':expirydt' => $timestamp))->fetchObject();
	}
	if ($record && check_category_topic_access($cat_id, 0)) {
		$themepath = base_path() . drupal_get_path('theme', 'vwr') . '/';
		$create_access = has_page_access('create');
		$edit_access = has_page_access('edit');
		$_SESSION['google_analytics_page_name'] = $record->category_name . ' Page';


	?>
		<script type="text/javascript" language="javascript">
			if (($("#displayoptions_one").length) || ($("#displayoptions_two").length)) {
				$("#show_sublevels").show();
			}
		</script>
		<link href="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/css/jquery-ui.css">
		<div class="right_cont">
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span><?php echo htmlspecialchars($record->category_name); ?></span>
			</div>
			<div class="cat_cont">
				<div class="cat_top">
					<h3 class="<?php echo ($record->expiry_date < (strtotime(date("m/d/Y")))) ? 'doc_title_exp' : ''; ?>"><?php echo htmlspecialchars($record->category_name); ?></h3>
					<?php
					if (user_access('add edit delete category') && $edit_access) {
					?>
						<a onClick="editCategoryTopic('<?php echo $cat_id; ?>','category','<?php echo 'category/edit/' . $cat_id; ?>');" href="javascript:void(0);"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="edit" /></a>
						<a onClick="deleteCategoryTopic('<?php echo $cat_id; ?>','category','')" href="javascript:void(0);"><img src="<?php echo $themepath; ?>images/ico_8.png" width="18" height="19" alt="delete" /></a>
					<?php
					}
					if (user_access('add edit delete category') && $create_access) {
					?>
						<div class="acc_btn"><input type="submit" class="button" value="User Access" onClick="openUserAccess('<?php echo $cat_id; ?>', 0, 0, 'category','<?php echo 'category/' . $cat_id; ?>');" /></div>
					<?php
					}
					?>
				</div>

				<div class="cat_list">
					<div class="prod_img" file_id="<?php echo htmlspecialchars($record->scan_file_id);?>">
						<?php
						$imagepath = base_path() . variable_get('file_public_path', conf_path()) . '/files/category/' . $record->category_image;
						$imagepath = str_replace("/sites/default/files/files/", "/sites/default/files/", $imagepath);
						if ($record->scan_file_status == "SCAN_COMPLETED" || $record->scan_file_status == "") {
						?>
							<img alt="category" title="category" src="<?php echo htmlspecialchars($imagepath); ?>" width="206" height="214" alt="<?php echo htmlspecialchars($record->category_image); ?>" />
						<?php
						} elseif ($record->scan_file_status == "SCAN_FAILED") {
							echo str_replace('|filename|', htmlspecialchars($record->category_image), variable_get('threat_detected'));
						} else {
							echo str_replace('|filename|', htmlspecialchars($record->category_image), variable_get('in_progress'));
						}
						?>
					</div>
					<div class="cat_desc">
						<h2><?php echo htmlspecialchars($record->description_title); ?></h2>
						<div class="shw-catdesc-all" id="showdescription">
							<?php

							$firstposition = substr($record->category_description, 0, 1);
							if ($firstposition == ",") {
								$showdesc = substr($record->category_description, 1, strlen($record->category_description));
							} else {
								$showdesc = $record->category_description;
							}
							?>
							<?php
							if (is_vwr_user_role()) {
								$sortclass = "class='ui-state-default'";
								$sortul = "class='sortable'";
							}
							?>
							<p><?php echo trim(preg_replace('/\<(.*)script(.*)\>(.*)<\/script>/i', '', html_entity_decode($showdesc))); ?></p>
						</div>
						<input type="hidden" value="<?php echo ceil(($record->expiry_date - time()) / (60 * 60 * 24)); ?>" id="max_expiry_add" />
						<input type="hidden" value="<?php echo $record->expiry_date ? date("m/d/Y", $record->expiry_date) : ''; ?>" id="page_expiry_add" />
						<div class="file_str" <?php echo $sortul; ?>>

							<ul id="cat-topic-docs" <?php echo $sortul; ?>>
								<?php
								$total_docs = get_docs_totalcount($cat_id, 0, 0, 0, $currentregiontab);
								$end = 5;
								$doc_list = get_docs_intial($cat_id, 0, 0, 0, $currentregiontab);
								$fcount = $fid = 0;
								if ($doc_list) {
									foreach ($doc_list as $file) {
										$fid = $file->file_id;
										if (++$fcount == 1) {
											$first_id = $fid;
										}
										$image_icon = getFiletypeImage($file->file_name);

										$ga_name = addslashes(str_replace('"', '', $record->category_name));
										$ga_file_title = addslashes(str_replace('"', '', $file->file_title));

								?>

										<li <?php echo $sortclass; ?> id="itemorder_<?php echo htmlspecialchars($fid); ?>_1" file_id="<?php echo htmlspecialchars($file->scan_file_id); ?>">
											<span class="file_ic">
												<img src="<?php echo $themepath; ?>images/<?php echo $image_icon; ?>" width="18" height="19" alt="<?php echo $image_icon; ?>" />
												<?php
												if ($file->scan_file_status == "SCAN_COMPLETED" || $file->scan_file_status == "") {
												?>
													<span onClick="downloadUploadDocuments('<?php echo base64_encode($cat_id); ?>','category', '<?php echo $fid; ?>');track_document_download('<?php print $ga_name; ?>', 'Download', '<?php print $ga_file_title; ?>');" class="<?php echo ($file->expiry_date < (strtotime(date("m/d/Y")))) ? 'doc_title_exp' : 'doc_title_downl'; ?>"><?php echo $file->file_title; ?></span>
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
													<a href="javascript:void(0);" onClick="downloadUploadDocuments('<?php echo $cat_id; ?>','category', '<?php echo $fid; ?>');track_document_download('<?php print $ga_name; ?>', 'Download', '<?php print $ga_file_title; ?>');">
														<img src="<?php echo $themepath; ?>images/ico_6.png" width="18" height="19" alt="download" />
													</a>
												<?php
												}

												if (user_access('add edit delete category') && user_access('upload file to category topic') && $edit_access) {
												?>
													<a href="javascript:void(0);" onClick="editUploadDocuments('<?php echo $cat_id; ?>','category', '<?php echo $fid; ?>');"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="Edit" /></a>
													<a href="javascript:void(0);" onClick="updateDocuments('<?php echo $cat_id; ?>','category', '<?php echo $fid; ?>', 'delete');"><img src="<?php echo $themepath; ?>images/ico_8.png" width="18" height="19" alt="Delete" /></a>
												<?php
												} ?>
											</span>

										</li>
								<?php
									}
								}
								?>
							</ul>
						</div>
						<div class="file_page">
							<?php
							if (user_access('add edit delete category') && user_access('upload file to category topic') && is_vwr_user_role() && $edit_access) {
							?>
								<div class="upload_btn"><input type="submit" class="button" value="Upload Document" onClick="openUploadDocuments('<?php echo $cat_id; ?>','category','<?php echo 'category/' . base64_encode($cat_id); ?>', '<?php echo 'cat_id=' . $cat_id . '&top_id=0&stop_id=0&itop_id=0'; ?>');" /></div>
							<?php
							}
							if ($fcount) {
							?>
								<div class="fl_pg">
									<input type="hidden" id="current_url" value="<?php echo 'category/'; ?>" />
									<?php
									if ($total_docs > $end) {
									?>
										<span class="viewall" id="viewall_docs"><a href="javascript:void(0);" onClick="showDocsPagination('<?php echo $cat_id; ?>', 'category', '<?php echo $fid; ?>', 'viewall');" id="viewall_a">View&nbsp;All</a></span>
										
									<?php
									}
									?>
									<span class="pge">
										<span id="hide_start_cont" style="display:none;">
											<a class="sh_cursor" onClick="showDocsPagination('<?php echo $cat_id; ?>', 'category', '<?php echo $fid; ?>', 'first');"><img src="<?php echo $themepath; ?>images/older1.jpg" width="7" height="7" /></a>
											<a class="sh_cursor" onClick="showDocsPagination('<?php echo $cat_id; ?>', 'category', '<?php echo $fid; ?>', 'prev');"><img src="<?php echo $themepath; ?>images/prev1.jpg" width="7" height="7" /></a>
										</span>
										<a class="sh_cursor"><span id="current_records"><?php echo $fcount > 1 ? '<span id="first_doc_entry">1</span><span id="single_doc_entry">-<span id="last_doc_entry">' . htmlspecialchars($fcount) . '</span></span>' : '1'; ?></span></a>of<a class="sh_cursor"><span id="total_doc_count"><?php echo htmlspecialchars($total_docs); ?></span></a>
										<?php
										if ($total_docs > $end) {
										?>
											<span id="hide_last_cont">
												<a class="sh_cursor" onClick="showDocsPagination('<?php echo $cat_id; ?>', 'category', '<?php echo $fid; ?>', 'next');"><img src="<?php echo $themepath; ?>images/next1.jpg" width="7" height="7" /></a>
												<a class="sh_cursor" onClick="showDocsPagination('<?php echo $cat_id; ?>', 'category', '<?php echo $fid; ?>', 'last');"><img src="<?php echo $themepath; ?>images/last1.jpg" width="7" height="7" /></a>
											</span>
										<?php
										}
										?>
									</span>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="drp_cont">
					<h4><?php echo htmlspecialchars(getDropboxName()); ?></h4>
					<ul>
						<?php
						$array_order = array("active", "expired");
						foreach ($array_order as $end_date_sort) {
							$dropbox_list = get_related_dropbox($cat_id, 0, $end_date_sort, $currentregiontab);
							if ($dropbox_list) {
								foreach ($dropbox_list as $dropbox) {
									if ((check_vwr_dropbox_access($dropbox->id) || $dropbox->allusers_page) && ((!is_vwr_user_role() && ($dropbox->end_date >= (strtotime(date("m/d/Y"))))) || is_vwr_user_role())) {
						?>
										<li>
											
											<a style="cursor:pointer;" onClick="Dropbox_Modalbox('file_upload','<?php echo base_path(); ?>','<?php echo htmlspecialchars($dropbox->id, ENT_QUOTES, 'UTF-8'); ?>','<?php echo htmlspecialchars($cat_id, ENT_QUOTES, 'UTF-8'); ?>');" class="drop_ico"><img src="<?php echo $themepath; ?>images/dropbox_up_s.png" width="30" height="28" alt="" class="viewdpb_img" />
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
				<?php
				$page_display_options = db_query('select display_options from {category}
					where category_id=:cat_id', array(':cat_id' => $cat_id))->fetchColumn();
				if ($page_display_options == 1) {
					echo "<div id='displayoptions_one'></div>";
				} else {
					echo "<div id='displayoptions_two'></div>";
				}
				?>

				<div class="pro_tb" id="show_sublevels">
					<?php


					$cat_topics = get_all_topics($cat_id, 0, 1, $currentregiontab, 1);
					if ($cat_topics) {
						foreach ($cat_topics as $topic) {
							$contentregions = array();
							$contentregions = Iscontentregionaccess($cat_id, $topic->topic_id, $currentregiontab);
							if (count($contentregions) > 0) {
								if (check_category_topic_access($cat_id, $topic->topic_id)) {
									if ((!is_vwr_user_role() && ($topic->expiry_date >= (strtotime(date("m/d/Y"))))) || is_vwr_user_role()) {
					?>

										<?php if ($page_display_options == 1) { ?>

											<div class="tb_box" onClick="window.open('<?php echo base_path() . 'category/' . base64_encode($cat_id) . '/topic/' . base64_encode($topic->topic_id); ?>','_self');">
												<div class="tb_img" file_id="<?php echo $topic->scan_file_id ;?>">
													<?php
													$tbimagepathnew = base_path() . variable_get('file_public_path', conf_path()) . '/files/topic/' . $topic->topic_image;
													$tbimagepathnew = str_replace("/sites/default/files/files/", "/sites/default/files/", $tbimagepathnew);
													if ($topic->scan_file_status == "SCAN_COMPLETED"  || $topic->scan_file_status == "") {
													?>
														<img alt="category" title="category" src="<?php echo $tbimagepathnew; ?>" width="88" height="88" alt="<?php echo $topic->topic_image; ?>" />
													<?php
													} elseif ($topic->scan_file_status == "SCAN_FAILED") {
														echo str_replace('|filename|', $topic->topic_image, variable_get('threat_detected'));
													} else {
														echo str_replace('|filename|', $topic->topic_image, variable_get('in_progress'));
													}
													?>
												</div>
												<h4 title="<?php echo $topic->topic_name; ?>" class="<?php echo ($topic->expiry_date < (strtotime(date("m/d/Y")))) ? 'doc_title_exp' : ''; ?>"><?php echo (strlen($topic->topic_name) > 21) ? substr($topic->topic_name, 0, 18) . '...' : $topic->topic_name; ?></h4>
												<p class="topic_overview"><?php echo $topic->teaser_text; ?></p>
											</div>
										<?php } ?>


										<?php if ($page_display_options == 2) { ?>

											<ul style="margin-bottom:10px;padding-bottom:10px;">
												<li style="list-style-type:none">
													<h2>
														<a style="color:#495676;cursor:pointer;margin-left:10px" href="<?php echo base_path() . 'category/' . base64_encode($cat_id) . '/topic/' . base64_encode($topic->topic_id); ?>">
															<?php echo (strlen($topic->topic_name) > 21) ? substr($topic->topic_name, 0, 18) . '...' : $topic->topic_name; ?>
														</a>
													</h2>
												</li>
											</ul>
										<?php } ?>



						<?php   		}
								}
							}
						}
					}
					if (user_access('add edit delete topic') && $create_access) { ?>
						<div class="addtpc_btn"><input type="submit" class="button" value="Add Sub-Category" onClick="addCategoryTopic('<?php echo $cat_id; ?>','topic','<?php echo 'category/' . $cat_id . '/topic/add'; ?>');" /></div>

					<?php } ?>
				</div>


				<div class="pro_tb">
					<?php
					$cat_topics = get_all_hyperlinks($cat_id, 0, 0, 0, $currentregiontab);
					if ($cat_topics) {
						foreach ($cat_topics as $topic) {
							$hyperlinkimage = $topic->hyperlink_image;
							$hyperlink_id = $topic->hyperlink_id;

					?>
							<div class="tb_box" style="cursor:auto">
								<div class="tb_img" file_id="<?php echo $topic->scan_file_id ;?>">
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
										<a onClick="editHyperlinkCategory('<?php echo $cat_id; ?>','category','<?php echo 'hyperlink/edit/' . $hyperlink_id; ?>','<?php echo 'cat_id=' . $cat_id . '&top_id=0&stop_id=0&itop_id=0'; ?>');" href="javascript:void(0);"><img src="<?php echo $themepath; ?>images/ico_7.png" width="18" height="19" alt="edit" /></a>
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

				<?php if (is_vwr_user_role() && has_page_access('edit')) { ?> <div class="addtpc_btn"><input type="submit" class="button" value="Create Hyperlink" onClick="addHyperlink('<?php echo $cat_id; ?>','hyperlink','<?php echo 'category/' . $cat_id . '/hyperlink/add'; ?>','<?php echo 'cat_id=' . $cat_id . '&top_id=0&stop_id=0&itop_id=0'; ?>');" /></div>
				<?php } ?>
			</div>
		</div>
	<?php
	} else {
		print theme('noaccess_error_theme', array('action' => '', 'level' => 'category'));
	}
	?>