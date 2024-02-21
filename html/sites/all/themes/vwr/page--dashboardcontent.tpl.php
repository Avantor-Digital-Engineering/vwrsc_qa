<link href="<?php echo base_path() . path_to_theme(); ?>/styles/widgets.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_path() . path_to_theme(); ?>/styles/dashboard.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/dashboard.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/jqueryui.js"></script>
	<script type="text/javascript" src="<?php echo base_path() . path_to_theme(); ?>/scripts/sortable.js"></script>

	<?php
	global $user, $base_url;
	$timestamp = strtotime(date("m/d/Y"));
	$cookieprocessregions = '';
	if (!isset($_COOKIE['cookieregion_name'])) {
		$cookieprocessregions = addslashes(htmlspecialchars(trim($_SESSION['region_name'])));
	} else {
		$cookieprocessregions = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));
	}
	if ((!empty($user->uid) && arg(0) == 'user' && arg(1) != '') || ($is_front && $user->uid != '')) {

		$resultset = db_query('SELECT dashboard_count from {dashboard_user_map} where uid=:uid', array(':uid' => $user->uid))->fetchField(0);
		$dashboard_count = '';
		$category_list = '';
		$sub_cat_list = '';
		$dropboxes_list = '';

		if ($resultset != 0) {
			$select_categorysid = '';
			$selectIcons = $selectids = $selectdropids = $parentcatids = $selectedimages = $selecticonname = $cat_type = $dropbox_type = array();
			$validCategories = array();
			$validSubCategories = array();
			$validDropboxes = array();
			$validBoxes = array("Dropbox", "Supplier Org", "Users", "View Reports", "My Reports");
			
			$icons = db_select('dashboard_user_map', 'dum')
				->fields('dum')
				->condition('uid', $user->uid, '=')
				->execute();
			foreach ($icons as $record) {
				$select_categorysid = $record->category_id;
				$dashboard_count = $record->dashboard_count;
			}
			$combined_records = array();
			$categories_split = explode(",", $select_categorysid);
			$combined_records = $categories_split; 
			/**
			 * _ used for Weight
			 * @ used for Category/Subcategory
			 * # used for Ids
			 */
			sort($combined_records);
			$weight_array = array();
			$default_icons = array();
			$category_total_count = 0;
			$dropbox_total_count = 0;
			$subcategory_total_count = 0;
			foreach ($combined_records as $key => $val) {
				$split_cat = explode("@", $val);
				$weight_array[$split_cat[0]] = $split_cat[1];

				$recId = '';
				if (strstr($split_cat[1], 'subcat')) {
					$recId = explode("#", $split_cat[1]);
					$subcategory_details = array();
					$sub_cat_list .= $recId[1] . ",";
					$subcategory_total_count++;
					$subcategory_details[] = get_subcategorybyid($recId[1], $cookieprocessregions);
				} else if (strstr($split_cat[1], 'cat')) {
					$recId = explode("#", $split_cat[1]);
					$category_details = array();
					$category_list .= $recId[1] . ",";
					$category_total_count++;
					$category_details[] = get_categorybyid($recId[1], $cookieprocessregions);
				} else if (strstr($split_cat[1], 'dropboxes')) {
					$recId = explode("#", $split_cat[1]);
					$dropbox_details = array();
					$dropboxes_list .= $recId[1] . ",";
					$dropbox_total_count++;
					$dropbox_details[] = get_dropboxesbyid($recId[1], $cookieprocessregions);					
				} else if (strstr($split_cat[1], 'Dropbox')) {
					$default_position = explode("_", $split_cat[0]);
					$default_icons[$default_position[1]] = 'Dropbox';
				} else if (strstr($split_cat[1], 'Supplier Org')) {
					$default_position = explode("_", $split_cat[0]);
					$default_icons[$default_position[1]] = 'Supplier Org';
				} else if (strstr($split_cat[1], 'Users')) {
					$default_position = explode("_", $split_cat[0]);
					$default_icons[$default_position[1]] = 'Users';
				} else if (strstr($split_cat[1], 'View Reports')) {
					$default_position = explode("_", $split_cat[0]);
					$default_icons[$default_position[1]] = 'View Reports';
				} else if (strstr($split_cat[1], 'My Reports')) {
					$default_position = explode("_", $split_cat[0]);
					$default_icons[$default_position[1]] = 'My Reports';
				}
			}

			$category_list = substr($category_list, 0, -1);
			$sub_cat_list = substr($sub_cat_list, 0, -1);
			$dropboxes_list = substr($dropboxes_list, 0, -1);

			$cookieregionname = addslashes(htmlspecialchars(trim($cookieprocessregions)));
			$currentregion = "AND vwrcr.region_id in ($cookieregionname)";
			$selectall = "";

			if ($category_list != '') {
				if (is_vwr_user_role()) {
					$result = db_query(
						"SELECT 
						vwrc.category_id,
						vwrc.category_name,
						vwrc.category_image,
						vwrc.short_name FROM {category} as vwrc join {category_regions} as vwrcr on vwrc.category_id=vwrcr.category_id
						and vwrc.category_id IN ($category_list) and 
						vwrc.category_status=1 $currentregion ORDER BY vwrc.short_name ASC");
				} else {
					$result = db_query("SELECT vwrc.category_id,vwrc.category_name,
					vwrc.category_image,vwrc.short_name 
					FROM {category} as vwrc join {category_regions} as vwrcr 
					on vwrc.category_id=vwrcr.category_id and vwrc.category_id IN ($category_list) 
					and category_status=1 $currentregion and expiry_date >= $timestamp ORDER BY short_name ASC");
				}
				$cat_count = 0;
				foreach ($result as $record) {
					if (check_category_topic_access($record->category_id, 0)) {
						$cat_count++;
						$selectIcons[] = $record->short_name;
						$selectids[] = $record->category_id;
						$validCategories[] = $record->category_id;
						$parentcatids[] = '';
						$selectedimages[] = $record->category_image;
						$cat_type[] = 'category';
					}
				}
				$cat_mismatch = $category_total_count - $cat_count;
				if ($cat_mismatch > 0) {
					for ($i = 0; $i < $cat_mismatch; $i++) {
						$selectIcons[] = '';
						$selectids[] = '';
						$selectedimages[] = '';
						$parentcatids[] = '';
						$cat_type[] = '';
					}
				}
			}
			if ($sub_cat_list != '') {
				if (is_vwr_user_role()) {
					$subresult = db_query('SELECT topic_id,
					topic_name,topic_image,category_id,short_name FROM 
					{topic} WHERE topic_id IN (:sub_cat_list) and 
					topic_status=1 ORDER BY short_name ASC', array(':sub_cat_list' => $sub_cat_list));
				} else {
					$subresult = db_query('SELECT topic_id,
					topic_name,topic_image,category_id,
					short_name FROM {topic} where topic_id IN 
					(:sub_cat_list) and topic_status=1 && expiry_date >= :expiry_dt 
					ORDER BY short_name ASC', array(':sub_cat_list' => $sub_cat_list, ':expiry_dt' => $timestamp));
				}
				$sub_count = 0;
				foreach ($subresult as $subrecord) {
					if (check_category_topic_access($subrecord->category_id, $subrecord->topic_id)) {
						$sub_count++;
						$selectIcons[] = $subrecord->short_name;
						$selectids[] = $subrecord->topic_id;
						$validSubCategories[] = $subrecord->topic_id;
						$selectedimages[] = $subrecord->topic_image;
						$parentcatids[] = $subrecord->category_id;
						$cat_type[] = 'topic';
					}
				}
				$subcat_mismatch = $subcategory_total_count - $sub_count;
				if ($subcat_mismatch > 0) {
					for ($i = 0; $i < $subcat_mismatch; $i++) {
						$selectIcons[] = '';
						$selectids[] = '';
						$selectedimages[] = '';
						$parentcatids[] = '';
						$cat_type[] = '';
					}
				}
			}
			if (isset($dropbox_details) && ($dropbox_details[0] != "notexists")) {
				if ($dropboxes_list != '') {
					$timestampdrp = strtotime(date("m/d/Y"));
					if (is_vwr_user_role()) {
						$dropboxresult = db_query("SELECT drp.id,drp.title,
					drp.instruction FROM {dropbox} AS drp INNER JOIN {dropbox_regions} AS 
					drpreg ON drp.id=drpreg.dropbox_id AND drpreg.region_id in ($cookieprocessregions) 
					WHERE drp.deleted=0 AND drpreg.status=1 AND drp.id in ($dropboxes_list) group 
					by drpreg.dropbox_id ORDER BY drp.title ASC");
					} else {
						$dropboxresult = db_query("SELECT drp.id,drp.title,
					drp.instruction FROM {dropbox} AS drp INNER JOIN {dropbox_regions} AS 
					drpreg ON drp.id=drpreg.dropbox_id AND drpreg.region_id in ($cookieprocessregions) 
					WHERE drp.deleted=0 AND drpreg.status=1 AND drp.id in ($dropboxes_list) AND 
					drp.start_date <= $timestampdrp AND drp.end_date >= $timestampdrp group 
					by drpreg.dropbox_id ORDER BY drp.title ASC");
					}
					$dropbox_count = 0;
					foreach ($dropboxresult as $dropboxrecord) {

						$dropbox_count++;
						$selectIcons[] = $dropboxrecord->title;
						$selectids[] = $dropboxrecord->id;
						$validDropboxes[] = $dropboxrecord->id;
						$cat_type[] = 'dropbox';
					}
					$dropbox_mismatch = $dropbox_total_count - $dropbox_count;
					if ($dropbox_mismatch > 0) {
						for ($i = 0; $i < $dropbox_mismatch; $i++) {
							$selectIcons[] = '';
							$selectids[] = '';
							$validDropboxes[] = '';
							$cat_type[] = '';
						}
					}
				}
			}


			foreach ($default_icons as $key => $val) {
				array_splice($selectIcons, $key, 0, $val);
				array_splice($selectids, $key, 0, $val);

				array_splice($selectedimages, $key, 0, '');
				array_splice($parentcatids, $key, 0, '');
				array_splice($cat_type, $key, 0, '');
				array_splice($dropbox_type, $key, 0, '');
			}
			$selectCount = count($selectIcons);
		}
	}


	?>
	<?php
	if (arg(0) == 'user' &&  arg(1) != '') {
		drupal_set_title('Welcome to VWR - Supplier Central');
	}
	?>
	<input type="hidden" id="selectCount" value="<?php echo $selectCount; ?>">
	<div class="right_cont" style="top:3px">
		<div class="dashboard-title">
			<h3 style="float:left;">Dashboard</h3>
			<span class="dashboard-action-links">
				<a href="javascript:void(0);" style="color:#004D8F;" onclick="dashboardpopup('dashboard-popup');">Configure Dashboard</a>
				&nbsp;|&nbsp;
				<a href="javascript:void(0);" style="color:#004D8F;" onclick="dashboardSave();">Save Dashboard</a>
			</span>
		</div>
		<div style="clear:both;height:0px;"></div>
		<?php if ($selectCount != '') { ?>
			<div class="sortable">
				<ul id="ulAnswers" class="connectedSortable answers">
					<?php					
					$categoryregionfiltering = array();
					$subcategoryregionfiltering = array();
					$dropboxregionfiltering = array();
					$contentids = '';
					if ($category_list != '') {
						$contentids .= $category_list . ",";
					}

					if ($sub_cat_list != '') {
						$contentids .= $sub_cat_list . ",";
					}
					if (isset($dropboxes_list) && ($dropboxes_list != '')) {
						$drplist .= $dropboxes_list . ",";
						$dropsbox_list = getuserdashboardcontentdropboxesregions($drplist);
					}


					$c_list = getuserdashboardcontentcontentregions($contentids);

					$regions = array_flip(getregionshortnames());
					for ($i = 0; $i < $selectCount; $i++) {
						$w_list = explode("#", $weight_array['w_' . $i]);

						if (count($w_list) == 1) {
							$w_list[1] = $w_list[0];
						}
						$display_rec = '';
						$display_rec = array_keys($selectids, $w_list[1]);
						if (count($display_rec) > 1 && $w_list[0] == 'subcat') {
							$display_rec = $display_rec[1];
						} else if ($w_list[0] == 'subcat') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'cat') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'Dropbox') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'Users') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'Supplier Org') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'View Reports') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'My Reports') {
							$display_rec = $display_rec[0];
						} else if ($w_list[0] == 'dropboxes') {
							$display_rec = $display_rec[0];
						}

						if (in_array($selectids[$display_rec], $validCategories) || in_array($selectids[$display_rec], $validDropboxes) || in_array($selectids[$display_rec], $validSubCategories) || in_array($selectids[$display_rec], $validBoxes)) {
							$display = 'style="display:block"';
							$regionname = '';
							if (count(explode(',', $cookieprocessregions)) > 1) {
								if ($w_list[0] == 'cat') {
									$regionindex = 0;
									if (!in_array($selectids[$display_rec], $categoryregionfiltering)) {

										$regionindex = array_shift(array_keys($c_list[$selectids[$display_rec]]));
										if ($regionindex > 0) {
											unset($c_list[$selectids[$display_rec]][$regionindex]);
										}
										$regionname = $regions[$regionindex];
										$categoryregionfiltering[] = $selectids[$display_rec];
									} else {

										$regionindex = array_shift(array_keys($c_list[$selectids[$display_rec]]));
										if ($regionindex > 0) {
											unset($c_list[$selectids[$display_rec]][$regionindex]);
										}

										$regionname = $regions[$regionindex];
									}
								}
								if ($w_list[0] == 'subcat') {
									$regionindex = 0;
									if (!in_array($selectids[$display_rec], $subcategoryregionfiltering)) {
										$regionindex = array_shift(array_keys($c_list[$selectids[$display_rec]]));
										if ($regionindex > 0) {
											unset($c_list[$selectids[$display_rec]][$regionindex]);
										}
										$regionname = $regions[$regionindex];
										$subcategoryregionfiltering[] = $selectids[$display_rec];
									} else {
										$regionindex = array_shift(array_keys($c_list[$selectids[$display_rec]]));
										if ($regionindex > 0) {
											unset($c_list[$selectids[$display_rec]][$regionindex]);
										}
										$regionname = $regions[$regionindex];
									}
								}

								if ($w_list[0] == 'dropboxes') {
									$regionindex = 0;
									if (!in_array($selectids[$display_rec], $dropboxregionfiltering)) {
										$regionindex = array_shift(array_keys($dropsbox_list[$selectids[$display_rec]]));
										if ($regionindex > 0) {
											unset($dropsbox_list[$selectids[$display_rec]][$regionindex]);
										}
										$regionname = $regions[$regionindex];
										$dropboxregionfiltering[] = $selectids[$display_rec];
									} else {
										$regionindex = array_shift(array_keys($c_list[$selectids[$display_rec]]));
										if ($regionindex > 0) {
											unset($dropsbox_list[$selectids[$display_rec]][$regionindex]);
										}
										$regionname = $regions[$regionindex];
									}
								}
							}

							if (count(explode(',', $cookieprocessregions)) == 1) {
								$regions = array_flip(getregionshortnames());
								$regionname = $regions[$cookieprocessregions];
								if ($w_list[0] == 'cat') {
									if (!in_array($selectids[$display_rec], $categoryregionfiltering)) {
										$dashboardcat = getdashboardcategories($selectids[$display_rec], $cookieprocessregions, $contenttype = 0);
										$display = 'style="display:none"';
										if (!empty($dashboardcat)) {
											$display = 'style="display:block"';
										}
										$categoryregionfiltering[] = $selectids[$display_rec];
									} else {
										$display = 'style="display:none"';
									}
								}
								if ($w_list[0] == 'subcat') {
									if (!in_array($selectids[$display_rec], $subcategoryregionfiltering)) {
										$dashboardcat = getdashboardcategories($selectids[$display_rec], $cookieprocessregions, 1);
										$display = 'style="display:none"';
										if (!empty($dashboardcat)) {
											$display = 'style="display:block"';
										}

										$subcategoryregionfiltering[] = $selectids[$display_rec];
									} else {
										$display = 'style="display:none"';
									}
								}

								if ($w_list[0] == 'dropboxes') {

									if (!in_array($selectids[$display_rec], $dropboxregionfiltering)) {
										$dashboarddropboxes = getdashboarddropboxes($selectids[$display_rec], $cookieprocessregions);
										$display = 'style="display:none"';
										if (!empty($dashboarddropboxes)) {
											$display = 'style="display:block"';
										}

										$dropboxregionfiltering[] = $selectids[$display_rec];
									} else {
										$display = 'style="display:none"';
									}
								}
							}

							$catids = $weight_array['w_' . $i];
							if (strpos($catids, '#') !== false) {
								$splitids = explode("#", $catids);
								$titleforli = $splitids[0] . $splitids[1];
							} else {
								$titleforli = $weight_array['w_' . $i];
							}
					?>

							<li title="<?php echo $titleforli; ?>" class="content_ht_<?php echo $i; ?> drag-item-li" id="<?php echo $weight_array['w_' . $i]; ?>" <?php echo $display; ?>>
								<?php
								if ($w_list[0] == 'cat') {
								?>
									<span id="category_<?php echo htmlspecialchars($selectids[$display_rec]) . "_" . htmlspecialchars(db_query('select region_id from {manage_regions} where region_shortname=:regionname', array(':regionname' => $regionname))->fetchColumn()); ?>" class="currentregioncontent"></span>
								<?php }
								if ($w_list[0] == 'subcat') {
								?>
									<span id="subcat_<?php echo htmlspecialchars($selectids[$display_rec]) . "_" . htmlspecialchars(db_query('select region_id from {manage_regions} where region_shortname =:regionname', array(':regionname' => $regionname))->fetchColumn()); ?>" class="currentregioncontent"></span>
								<?php
								}
								if ($w_list[0] == 'dropboxes') {
								?>
									<span id="dropboxes_<?php echo htmlspecialchars($selectids[$display_rec]) . "_" . htmlspecialchars(db_query('select region_id from {manage_regions} where region_shortname =:regionname', array(':regionname' => $regionname))->fetchColumn()); ?>" class="currentregioncontent"></span>
								<?php
								}
								?>
								<div class="Rec">
									<div class="Handle widget-head">
										<a class="collapse hide<?php echo str_replace(array("#", ' '), '_', $weight_array['w_' . $i]); ?>" style="cursor:pointer" id="<?php echo str_replace(array("#", ' '), '_', $weight_array['w_' . $i]); ?>" onclick="iconsHide(this.id);"></a>

										<a class="expand expand<?php echo str_replace(array("#", ' '), '_', $weight_array['w_' . $i]); ?>" style="display:none;cursor:pointer;" id="<?php echo str_replace(array("#", ' '), '_', $weight_array['w_' . $i]); ?>" onclick="iconsShow(this.id);"></a>
										<?php if ($selectIcons[$display_rec] == 'Dropbox') {											
											$result = db_select('dropbox_instructions', 'di')
												->fields('di', array('title'))
												->orderBy('title', 'desc')
												->range(0, 1)->execute()->fetchObject();
											$dropbox_title = $result->title;
											if (in_array('supplier', $user->roles) && ($dropbox_title != "")) { ?>
												<h3><?php echo htmlspecialchars($dropbox_title); ?></h3>
											<?php       } else {

											?>
												<h3><?php echo $selectIcons[$display_rec]; ?></h3>
											<?php       }
										} else { ?>

											<h3><?php

												if ($w_list[0] != 'dropboxes') {
													echo $selectIcons[$display_rec];
												} else {
													$dropboxregionscount = db_query('select * from {dropbox_regions} where dropbox_id=:dropbox_id and status=1', array(':dropbox_id' => $selectids[$display_rec]));

													if ($dropboxregionscount->rowCount() == 1) {
														$regionidfromdropbox = db_query('select region_id from {dropbox_regions} where dropbox_id=:dropbox_id and status=1', array(':dropbox_id' => $selectids[$display_rec]))->fetchField();

														$dropboxregionactualname = db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $regionidfromdropbox))->fetchField();
													} else {
														if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '1')) {
															$dropboxregionactualname = "NA";
														}
														if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '2')) {
															$dropboxregionactualname = "EU";
														}
													}

													if (strlen($_COOKIE['cookieregion_name']) == 1) {

														echo substr($selectIcons[$display_rec], 0, 12) . "&nbsp;<b>" . htmlspecialchars($dropboxregionactualname) . "</b>";
													}

													if (strlen($_COOKIE['cookieregion_name']) != 1) {

														if ($dropboxregionscount->rowCount() == 1) {
															echo substr($selectIcons[$display_rec], 0, 12) . "&nbsp;<b>" . htmlspecialchars($dropboxregionactualname) . "</b>";
														} else {
															echo substr($selectIcons[$display_rec], 0, 12);
														}
													}
												}
											} ?>
											</h3>
											<a class="remove" style="cursor:pointer" id="img_<?php echo 'Rec' . ($i + 1); ?>" onclick="imageHide('<?php echo $i; ?>');"></a>
									</div>
									<div class="widget" id="widget_<?php echo str_replace(array("#", ' '), '_', $weight_array['w_' . $i]); ?>">
										<div class="widget-content">
											<?php if ($selectids[$display_rec] == 'Dropbox') { ?>
												<div class="wid-img">
													<img src="<?php echo base_path() . path_to_theme(); ?>/images/dropbox_up.png" width="89" height="85" alt="widget" />
												</div>
											<?php } else if ($selectids[$display_rec] == 'Supplier Org') { ?>
												<div class="wid-img">
													<img src="<?php echo base_path() . path_to_theme(); ?>/images/Supplier org.png" width="89" height="85" alt="widget" />
												</div>
											<?php } else if ($selectids[$display_rec] == 'Users') { ?>
												<div class="wid-img">
													<img src="<?php echo base_path() . path_to_theme(); ?>/images/user_icon.png" width="89" height="85" alt="widget" />
												</div>
											<?php } else if ($selectids[$display_rec] == 'View Reports' || $selectids[$display_rec] == 'My Reports') { ?>
												<div class="wid-img">
													<img src="<?php echo base_path() . path_to_theme(); ?>/images/user_icon.png" width="89" height="85" alt="widget" />
												</div>
											<?php } else { ?>
												<div class="wid-img-icon">
													<?php if ($cat_type[$display_rec] == 'topic') { ?>
														<img src="<?php echo '/sites/default/files/topic/' . $selectedimages[$display_rec]; ?>" style="text-align:center;" width="172" height="172" alt="widget" />
													<?php } else if ($cat_type[$display_rec] == 'category') { ?>
														<img src="<?php echo '/sites/default/files/category/' . $selectedimages[$display_rec]; ?>" style="text-align:center;" width="172" height="172" alt="widget" />
													<?php } ?>
												</div>
											<?php } ?>

											<?php if ($selectids[$display_rec] == 'Dropbox') {  ?>
												<div class="wid-act-icon">
													<ul>
														<?php if (has_page_access('dropbox') && is_vwr_user_role()) {	?>
															<li><a href="<?php echo base_path() . 'vwr_dropbox/add_dropbox'; ?>">Create Drop box</a></li>
															<li><a href="<?php echo base_path() . 'vwr_dropbox/viewdropbox'; ?>">View Drop box</a></li>
															<li><a href="<?php echo base_path() . 'ticketmanager/ticketsoverview'; ?>">View Submissions</a></li>
															<?php } else {															
															$result = db_select('dropbox_instructions', 'di')
																->fields('di', array('title'))
																->orderBy('di.title', 'DESC')
																->range(0, 1)->execute()->fetchObject();

															$dropbox_title = $result->title;
															if (in_array('supplier', $user->roles) && ($dropbox_title != "")) { ?>
																<li><a href="<?php echo base_path() . 'vwr_dropbox/viewdropbox'; ?>">Submit Files</a></li>
																<li><a href="<?php echo base_path() . 'ticketmanager/ticketsoverview'; ?>">View Submissions</a></li>
																<?php
																if (view_team_access($user->uid)) {
																?>
																	<li><a href="<?php echo base_path() . 'ticketmanager/viewteam'; ?>">View Team</a></li>
																<?php
																}
																?>
															<?php } else { ?>
																<li><a href="<?php echo base_path() . 'vwr_dropbox/viewdropbox'; ?>">View Drop box</a></li>
														<?php }
														} ?>
													</ul>
												</div>
											<?php } else if ($selectids[$i] == 'Supplier Org') { ?>
												<div class="wid-act-icon">
													<ul>
														<li><a href="<?php echo base_path() . 'usermanager/supplierorgoverview/users'; ?>">Users</a></li>
														<li><a href="<?php echo base_path() . 'usermanager/supplierorgoverview/vas'; ?>">VAS Tier</a></li>
														<li><a href="<?php echo base_path() . 'usermanager/supplierorgoverview/access'; ?>">Access Path</a></li>
													</ul>
												</div>
											<?php } else if ($selectids[$i] == 'Users') { ?>
												<div class="wid-act-icon">
													<ul>
														<?php if (has_user_access('confirm/update')) { ?>
															<li><a href="<?php echo base_path() . 'usermanager/useroverview/pendinguser'; ?>">View New Requests</a></li>
														<?php } ?>
														<li><a href="<?php echo base_path() . 'usermanager/useroverview'; ?>">View Users</a></li>
														<?php if (has_user_access('confirm/update')) { ?>
															<li class="tab"><a href="<?php echo base_path() . 'usermanager/useroverview/deactiveuser' ?>">Deactivation Requests</a></li>
														<?php } ?>
													</ul>
												</div>
											<?php } else if ($selectids[$i] == 'View Reports' || $selectids[$i] == 'My Reports') { ?>
												<div class="wid-act-icon">
													<ul>
														<?php
														if (is_vwr_user_role()) {
														?>
															<li><a href="<?php echo base_path() . 'bulk/overview'; ?>">View Reports</a></li>
														<?php
														} else {
														?>
															<li><a href="<?php echo base_path() . 'bulk/reports'; ?>">My Reports</a></li>
														<?php
														}
														if (has_page_access('dropbox') && is_vwr_user_role()) {
														?>
															<li><a href="<?php echo base_path() . 'bulk/create'; ?>">Add Bulk Upload</a></li>
														<?php
														}
														?>
													</ul>
												</div>
											<?php } else { ?>
												<div class="wid-act">
													<ul>

														<?php if ($cat_type[$display_rec] == 'category') {

															$catt = str_replace(array("#", ' '), '_', $weight_array['w_' . $i]);
															$categoryremove = str_replace("cat_", "", $catt);
															$categoryids = str_replace("regionid_", "", $categoryremove);
															$categoryidsonly = explode("_", $categoryids);
															$regionwidget = db_query("select * from  {dashboard_content_regions} where region_id in ($cookieprocessregions) and userid in ($user->uid) and content_id in ($categoryidsonly[0])");

															if ($regionwidget) {
																foreach ($regionwidget as $rw) {
																	if ($rw->region_id == 1) {
																		$categoryidslinkna = $categoryidsonly[0] . "_" . $rw->region_id;
																		echo "<a data-region=catnas id=category_naregionid_$categoryidslinkna onclick=showcategorypage('$categoryidslinkna','0','cat','$rw->region_id') class=viewlinks>&nbsp;&nbsp;&nbsp;View NA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
																	}
																	if ($rw->region_id == 2) {
																		$categoryidslinkeu = $categoryidsonly[0] . "_" . $rw->region_id;
																		echo "<a data-region=europeancats  id=category_euregionid_$categoryidslinkeu onclick=showcategorypage('$categoryidslinkeu','0','cat','$rw->region_id') class=viewlinks >&nbsp;&nbsp;&nbsp;View EU</a>";
																	}

														?>

															<?php
																}
															}


															?>

														<?php
														} else if ($cat_type[$display_rec] == 'topic') {
															$subcatt = str_replace(array("#", ' '), '_', $weight_array['w_' . $i]);
															$subcategoryremove = str_replace("subcat_", "", $subcatt);
															$subcategoryids = str_replace("regionid_", "", $subcategoryremove);
															$subcategoryidsonly = explode("_", $subcategoryids);
															$regionsubwidget = db_query("select * from  {dashboard_content_regions} where region_id in ($cookieprocessregions) and userid in ($user->uid) and content_id in ($subcategoryidsonly[0])");
															if ($regionsubwidget) {
																foreach ($regionsubwidget as $rsubw) {
																	if ($rsubw->region_id == 1) {
																		$categoryidslinkna = $categoryidsonly[0] . "_" . $rsubw->region_id;
																		echo "<a data-region=northamericansubcategories id=topic_naregionid_$subcategoryidsonly[0]_$rsubw->region_id onclick=showcategorypage('$parentcatids[$display_rec]','$subcategoryids','subcat','$rsubw->region_id') class=viewlinks >&nbsp;&nbsp;&nbsp;View NA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
																	}
																	if ($rsubw->region_id == 2) {
																		$categoryidslinkeu = $categoryidsonly[0] . "_" . $rsubw->region_id;
																		echo "<a data-region=europeansubs id=topic_europeregionid_$subcategoryidsonly[0]_$rsubw->region_id onclick=showcategorypage('$parentcatids[$display_rec]','$subcategoryids','subcat','$rsubw->region_id') class=viewlinks >&nbsp;&nbsp;&nbsp;View EU</a>";
																	}
																}
															}
														?>


														<?php
														} else if ($cat_type[$display_rec] == 'dropbox') {

															$dropboxttt = str_replace(array("#", ' '), '_', $weight_array['w_' . $i]);
															$dropboxesremove = str_replace("dropboxes_", "", $dropboxttt);
															$dropboxesids = str_replace("regionid_", "", $dropboxesremove);
															$dropboxesidsonly = explode("_", $dropboxesids);
															$regionsubwidgetdropbox = db_query("select * from  {dashboard_dropbox_regions} where region_id in ($cookieprocessregions) and userid in ($user->uid) and dropbox_id in ($dropboxesidsonly[0])");

															if ($regionsubwidgetdropbox) {
																foreach ($regionsubwidgetdropbox as $rsubdropbox) {
																	if ($rsubdropbox->region_id == 1) {

																		echo "<a data-region=northamericandropboxes id=dropboxes_naregionid_$dropboxesidsonly[0]_$rsubdropbox->region_id class=viewlinks style='display:none' >&nbsp;&nbsp;&nbsp;View NA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
																	}
																	if ($rsubdropbox->region_id == 2) {

																		echo "<a data-region=europeandropboxes id=dropboxes_europeregionid_$dropboxesidsonly[0]_$rsubdropbox->region_id class=viewlinks  style='display:none'>&nbsp;&nbsp;&nbsp;View EU</a>";
																	}
																}
															}
														?>


														<?php
														}

														?>
													</ul>
												</div>
											<?php } ?>
											<div class="wid-bot"></div>
										</div>
									</div>
								</div>
							</li>
					<?php
						}
					} ?>
				</ul>
			</div><!-- End demo -->
		<?php	} else { ?>
			<div style='margin:20px 0px 0px 10px;height:102px; line-height: 30px;'>Currently there are no items on your Dashboard. Please <a href="javascript:void(0);" style="color:#45557b;text-decoration:underline;" onclick="dashboardpopup('dashboard-popup');">click here</a> to configure</div>
		<?php  } ?>
		<div style='margin:20px 0px 0px 10px;height:102px; line-height: 30px; display:none;' id="dashboard_message">Currently there are no items on your Dashboard. Please <a href="javascript:void(0);" style="color:#45557b;text-decoration:underline;" onclick="dashboardpopup('dashboard-popup');">click here</a> to configure
		</div>
	</div>

	<div id="dashboard-modal-content1" style="display:none">
		<div class="pop_head">
			<div class="pop_logo"><img src="<?php echo $front_page . $directory ?>/images/pop_logo.png" width="153" height="46" alt="logo" /></div>
			<div class="pop_slog"><img src="<?php echo $front_page . $directory ?>/images/pop_slog.jpg" width="136" height="23" alt="slog" /></div>
			<div class="menu">
				<ul>
					<li><a href="#"></a></li>
				</ul>
			</div>
		</div>
		<div class="pop_cont" id="dashboard_container">

		</div>
		<input type="hidden" id="currentuser" value="<?php echo $user->uid; ?>">
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			var seen = {};
			$('ul#ulAnswers li').each(function() {
				var txt = $(this).attr('title');
				var ids = $(this).attr('id');
				if ((ids != 'Dropbox') && (ids != 'Supplier Org') && (ids != 'Users') && (ids != '')) {
					if (seen[txt]) {
						$(this).remove();
					} else {
						seen[txt] = true;
					}
				}
			});

		});
	</script>