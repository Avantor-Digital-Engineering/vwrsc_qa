<script src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/dropbox.js"></script>
	<script src="<?php echo base_path() . drupal_get_path('module', 'categorymanager'); ?>/js/modalbox_dropbox.js"></script>
	<?php
	global $user;
	$regionquery = '';
	$categoryregionquery = '';

	if (!isset($_COOKIE['cookieregion_name'])) {

		$currentregionid = addslashes(htmlspecialchars(trim($_SESSION['region_name'])));

		$regionquery = 'and {dropbox_regions}.region_id in (:currentregionid) and {dropbox_regions}.status in (1)';
		$regiondeactivequery = " INNER JOIN {manage_regions} as vwrmr on vwrmr.region_id={dropbox_regions}.region_id and vwrmr.region_status=1 ";
		$categoryregionquery = 'and {category_regions}.region_id in (:currentregionid)';
	} else {
		$currentregionid = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));

		$regionquery = 'and {dropbox_regions}.region_id in (:currentregionid) and {dropbox_regions}.status in (1)';
		$regiondeactivequery = " INNER JOIN {manage_regions} as vwrmr on vwrmr.region_id={dropbox_regions}.region_id and vwrmr.region_status=1 ";
		$categoryregionquery = 'and {category_regions}.region_id in (:currentregionid)';
	}



	$themepath = base_path() . drupal_get_path('theme', 'vwr') . '/';
	$_SESSION['google_analytics_page_name'] = "View Dropbox Page";
	if ((in_array('vwr admin', $user->roles)) || (in_array('vwr internal', $user->roles))) {
		$uid = $user->uid;
		$select_user_title = db_query("SELECT title, instruction FROM {dropbox_instructions} ORDER BY created_date DESC LIMIT 0,1")->fetchObject();
		$dropbox_title = $select_user_title->title;
		$dropbox_instruction = $select_user_title->instruction;

	?>
		<div class="right_cont">
			<h3>
				<span id="reset_drop" style="float:left;"><?php if ($dropbox_title != "") {
																echo htmlspecialchars($dropbox_title);
															} else {
																echo "Dropbox";
															} ?></span>
				<span id="id_img" style="float:left;">&nbsp;&nbsp;
					<a href="javascript:void(0);" onclick="return view_dropbox_edit('0');"><img src="<?php echo $themepath; ?>images/ico_7.png" alt="dropbox" style="vertical-align:text-top; cursor:pointer;" /></a>
				</span>
				<span id="dropbox_whole_span" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="dropbox_name" id="dropbox_name" class="view_dropbox_input" value="<?php if ($dropbox_title != "") {
																													echo htmlspecialchars($dropbox_title);
																												} ?>" />&nbsp;&nbsp;
					<input type="button" name="save" value="Save" class="button" style="height:20px;width:50px;float:none;" onclick="dropbox_text_save('0');return false" />
					<input type="button" name="cancel" value="Cancel" class="button" style="height:20px;width:60px;float:none;" onclick="$('#reset_drop').show();$('#id_img').show();$('#dropbox_whole_span').hide();" />
				</span>
			</h3>
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span><?php print ($dropbox_title && $dropbox_title != "") ? htmlspecialchars($dropbox_title) : 'Dropbox'; ?></span>
			</div>

			<div class="drpbx_cont" style="border-bottom:none;">
				<p style="height:5px;"></p>
				<form name="dropboxlist" action="" method="post">
					<p class="sort_options" style="display:none;">
						<select name="search_date" id="search_date" onchange="FilterBySorting_dropbox(this.value);" class="view_dropbox_input">
							<option value="0" id="search_date" selected="selected">Select Date</option>
							<option value="start_date" <?php if ($_POST['search_date'] == 'start_date') { ?>selected="selected" <?php } ?>>Created Date</option>
							<option value="end_date" <?php if ($_POST['search_date'] == 'end_date') { ?>selected="selected" <?php } ?>>End Date</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="cat_search" id="cat_search" onchange="FilterBySorting_category(this.value);" class="view_dropbox_input">
							<option value="0" id="cat_search">Select Category</option>
							<?php

							$select_drop_dwon_category = db_query('
							SELECT {category}.category_name,{category}.category_id FROM {category},{category_regions} WHERE {category_regions}.category_id ={category}.category_id and {category}.category_status = 1 and {category_regions}.status=1
	' . $categoryregionquery . ' group by {category}.category_id ORDER BY category_name ASC', array(':currentregionid' => $currentregionid));
							if ($select_drop_dwon_category) {
								foreach ($select_drop_dwon_category as $cat_Name) {
									$category_name = $cat_Name->category_name;
							?>
									<option value="<?php echo $cat_Name->category_id; ?>" <?php if ($_POST['cat_search'] == $cat_Name->category_id) { ?>selected="selected" <?php } ?>><?php echo $category_name; ?></option>
							<?php
								}
							}
							?>
						</select>
					</p>
				</form>
				<p class="instruction_view">
					<span id="inst_text" style="display:none;"><?php if ($dropbox_instruction != "") {
																	echo nl2br(htmlspecialchars($dropbox_instruction));
																} else {
																	echo "Instruction";
																} ?></span>
					<span id="instruction" style="float:left;">
						<?php
						if ($dropbox_instruction != "") {
							echo nl2br(htmlspecialchars($dropbox_instruction));
						} else {
							echo "Instruction";
						}
						?>
						<span id="edit_icon"><span id="edit_inst"><a href="javascript:void(0);" onclick="return view_dropbox_edit('1');"><img src="<?php echo $themepath; ?>images/ico_7.png" alt="dropbox" style="vertical-align:middle; cursor:pointer;" /></a></span></span>
					</span>
					<span id="dropinst_whole_span" style="display:none;float:left;">&nbsp;&nbsp;&nbsp;&nbsp;
						<textarea name="dropbox_inst" id="dropbox_inst" class="view_dropbox_input" style="float:left;height:70px;width:300px;" /><?php if ($dropbox_instruction != "") {
																																						echo htmlspecialchars($dropbox_instruction);
																																					} else {
																																						echo "instruction";
																																					} ?></textarea>&nbsp;&nbsp;<br /><br /><br />
						<input type="button" name="save" value="Save" class="button" style="height:20px;width:50px;margin-top:5px;float:none;" onclick="dropbox_text_save('1');return false" />
						<input type="button" name="cancel" value="Cancel" class="button" style="height:20px;width:60px;float:none;" onclick="$('#instruction').show();$('#edit_icon').css('display','');$('#dropinst_whole_span').hide();" />
					</span>
				</p>
				<?php
				$delete_dropbox = addslashes(htmlspecialchars(trim($_POST['delete_dropbox'])));
				if ($delete_dropbox != "") {
					db_query('UPDATE {dropbox} SET deleted=1 WHERE id = :id', array(':id' => $delete_dropbox));
					db_query('DELETE FROM {dropbox_category_mapping} WHERE dbox_id = :dboxid', array(':dboxid' => $delete_dropbox));
					db_query('DELETE FROM {dropbox_supplier_access} WHERE dropbox_id = :dropbox_id', array(':dropbox_id' => $delete_dropbox));
					db_query('DELETE FROM {dropbox_vas_access} WHERE dropbox_id = :dropbox_id', array(':dropbox_id' => $delete_dropbox));
				}
				if (arg(2) == "add_success") {
					echo '<p class="result_success">Dropbox Created successfully</p>';
				} else if (arg(2) == "edit_success") {
					echo '<p class="result_success">Dropbox Updated successfully</p>';
				} else if (arg(2) == "delete_success") {
					echo '<p class="result_success">Dropbox Deleted successfully</p>';
				}
				$timestamp = strtotime(date("d-m-Y"));
				$cc_date = '';
				if ($_POST['search_date']) {					
					$cc_date = " ORDER BY {dropbox_regions}.region_id ASC, :search_date ASC ";
					echo "<script>$('.sort_options').show();</script>";
				}
				if ($_POST['cat_search']) {
					$flag = 1;
					$cat_id = addslashes(htmlspecialchars(trim($_POST['cat_search'])));
					if ($cc_date == '') {
						$cc_date = ' ORDER BY {dropbox_regions}.region_id ASC,created_date DESC, end_date DESC ';
					} else {
						$cc_date .= ' ,{dropbox_regions}.region_id ASC,created_date DESC';
					}
					echo "<script>$('.sort_options').show();</script>";
				}
				if (!$_POST['search_date'] && !$_POST['cat_search']) {
					$cc_date = ' ORDER BY {dropbox_regions}.region_id ASC,created_date DESC, end_date DESC ';
				}
				$timestamp = strtotime(date("m/d/Y"));
				$array_order = array(" end_date >= :timestamp AND ", " end_date < :timestamp AND ");
				$rv = 0;
				foreach ($array_order as $end_date_sort) {
					if ($flag == 1) {						
						if ($_POST['cat_search'])
							$cat_option = " {dropbox_category_mapping}.cat_id = :cat_id";

						$query = 'SELECT * from {dropbox_category_mapping},{dropbox},
						{dropbox_regions} ' . $regiondeactivequery . ' WHERE ' . $end_date_sort . $cat_option . ' 
						AND {dropbox_regions}.dropbox_id ={dropbox}.id 
						' . $regionquery . ' and {dropbox}.id = {dropbox_category_mapping}.dbox_id AND deleted=0 
						GROUP BY dbox_id' . $cc_date . '';

						$post_search_param = [':search_date' => addslashes(htmlspecialchars(trim($_POST['search_date'])))];
						$cat_search_param = [':cat_id' => $cat_id];
						$query_param = [':cat_id' => $cat_id, ':currentregionid' => $currentregionid, ':timestamp' => $timestamp];

						if ($_POST['search_date'])
							$query_param = array_merge($query_param, $post_search_param);
						if ($_POST['cat_search'])
							$query_param = array_merge($query_param, $cat_search_param);

						$select_details = db_query($query, $query_param);
					} else {						
						$query  = "SELECT * 
									FROM {dropbox},{dropbox_regions} 
										$regiondeactivequery 
									WHERE {dropbox_regions}.dropbox_id ={dropbox}.id 
										$regionquery 
									and 
										$end_date_sort deleted='0' 
									group by 
										id $cc_date ";

						$query_param = [':currentregionid' => $currentregionid, ':timestamp' => $timestamp];
						$post_search_param = [':search_date' => addslashes(htmlspecialchars(trim($_POST['search_date'])))];

						if ($_POST['search_date'])
							$query_param = array_merge($query_param, $post_search_param);
						$select_details = db_query($query, $query_param);
					}

					$count = $select_details->rowCount();
					if ($count > 0) {
						foreach ($select_details as $record_view) {
							echo "<script>$('.sort_options').show();</script>";
							$check_deleted_cat_topic = db_query('SELECT * FROM {dropbox_category_mapping} WHERE dbox_id=:id', array(':id' => $record_view->id));
							$deleted_categories = 0;
							foreach ($check_deleted_cat_topic as $deleted_cat_topic) {
								if (check_category_topic_deleted($deleted_cat_topic->cat_id, $deleted_cat_topic->topic_id) == 0) {
									$deleted_categories++;
								}
							}
							if ($check_deleted_cat_topic->rowCount() != $deleted_categories) {
								$rv++;
				?>
								<ul>
									<li class="drp_lst"><a href="javascript:void(0)" onClick="Dropbox_Modalbox_view('file_upload','<?php echo base_path(); ?>','<?php echo $record_view->id ?>');" class="drop_ico" title="Submit Files"><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/dropbox_up_s.png" alt="dropbox" title="Submit Files" /></a>
										<div class="drp_txt_view">

											<?php
											if ($record_view->end_date < $timestamp) {

											?>
												<a href="javascript:void(0)" onClick="Dropbox_Modalbox_view('file_upload','<?php echo base_path(); ?>','<?php echo $record_view->id ?>');" class="drop_ico" style="text-decoration:none;"><span class="drp_ttl" style="color:red;">
														<?php echo htmlspecialchars($record_view->title) . "  <b>(" . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $record_view->region_id))->fetchColumn()) . "</b>)"; ?></span></a> <span class="drp_dt" style="color:red;"><?php echo date("m/d/Y", htmlspecialchars($record_view->end_date)); ?></span>
											<?php
											} else {

											?>
												<span class="drp_ttl"><?php echo htmlspecialchars($record_view->title) . "  <b>(" . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $record_view->region_id))->fetchColumn()) . "</b>)"; ?></span>
												<span class="drp_dt"><?php echo date("m/d/Y", $record_view->end_date); ?></span>
												<?php
											}

											$result_cat = db_query('SELECT * FROM {dropbox_category_mapping} WHERE dbox_id=:id', array(':id' => $record_view->id));
											if ($result_cat) {
												foreach ($result_cat as $record_view_cat) {
													$Cat_id = $record_view_cat->cat_id;
													$Topic_id = $record_view_cat->topic_id;
													$region_id = $record_view_cat->region_id;
													$topic_name = get_topic_name($Topic_id);
												?>
													<span class="drp_lnk" style="line-height:12px;">
														<?php
														if ($Cat_id != "") {
															$get_cat_name = db_query('SELECT category_name,category_status FROM {category} WHERE category_id = :cat_id', array(':cat_id' => $Cat_id))->fetchObject();
															$cat_name = $get_cat_name->category_name;
															if ($Topic_id == 0 && $get_cat_name->category_status == 1) {

																$categoryids = $Cat_id . "_" . $region_id;
																$onlycategoryids = $Cat_id;
														?>
																<a href="javascript:void(0)" onclick="showcategorypagesfordropbox('<?php echo $categoryids; ?>',0,0,0,'cat','<?php echo $region_id; ?>')">
																	<?php
																	echo htmlspecialchars($cat_name) . " " . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $record_view_cat->region_id))->fetchColumn()); ?>
																</a>
															<?php
															} else {
																if ($topic_name != "") {
																	echo htmlspecialchars($cat_name) . " " . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $record_view_cat->region_id))->fetchColumn());
																}
															}
														}
														if ($Topic_id != 0 && $topic_name != "") {
															$link_url = get_link_url($Topic_id);
															$subcatidslists = $Topic_id . "_" . $region_id;
															$onlycategoryids = $Cat_id;
															$contentsubcat = db_query('select content_id from {content_regions} where content_id=:topic_id and content_type=1 and category_id=:cat_id and region_id=:region_id', array(':topic_id' => $Topic_id, ':cat_id' => $Cat_id, ':region_id' => $region_id));
															if ($contentsubcat) {
																foreach ($contentsubcat as $subcat) {

																	$topiclinks = "showcategorypagesfordropbox('$onlycategoryids','$subcat->content_id',0,0,'subcat','$region_id')";
																}
															}
															$contenttopic = db_query('select content_id from {content_regions} where content_id=:topic_id and content_type=2 and category_id=:cat_id and region_id=:region_id', array(':topic_id' => $Topic_id, ':cat_id' => $Cat_id, ':region_id' => $region_id));
															if ($contenttopic) {
																$sucatid = db_query('select parent_topic_id from {topic} where topic_id=:topic_id', array(':topic_id' => $Topic_id))->fetchColumn();
																foreach ($contenttopic as $topic) {

																	$topiclinks = "showcategorypagesfordropbox('$onlycategoryids','$sucatid','$topic->content_id',0,'topic','$region_id')";
																}
															}

															$contentsubtopic = db_query('select content_id from {content_regions} where content_id=:topic_id and content_type=3 and category_id=:cat_id and region_id=:region_id', array(':topic_id' => $Topic_id, ':cat_id' => $Cat_id, ':region_id' => $region_id));
															if ($contentsubtopic) {

																foreach ($contentsubtopic as $subtopic) {
																	$topicid = db_query('select parent_topic_id from {topic} where topic_id=:topic_id', array(':topic_id' => $Topic_id))->fetchColumn();
																	$subcatids = db_query('select parent_topic_id from {topic} where topic_id=:topicid', array(':topicid' => $topicid))->fetchColumn();
																	$topiclinks = "showcategorypagesfordropbox('$onlycategoryids','$subcatids','$topicid',$subtopic->content_id,'subtopic','$region_id')";
																}
															}
															?>
															&nbsp;&nbsp;&gt;&nbsp;&nbsp; <a href="javascript:void(0)" onclick="<?php echo htmlspecialchars($topiclinks); ?>">
																<?php echo htmlspecialchars($topic_name) . " " . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $record_view_cat->region_id))->fetchColumn()); ?></a>
														<?php
														}
														?>
													</span><br>
											<?php
												}
											}
											?>
										</div>
										<?php
										if (is_vwr_user_role()) {
										?>
											<a href="<?php echo base_path(); ?>ticketmanager/ticketsoverview?dropbox=<?php echo base64_encode($record_view->id); ?>" class="drop_edit" style="padding:2px 5px 0 0;" title="View Submissions"> 
												<img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/view_file.png" width="16" height="16" alt="View Submissions" title="View Submissions" />
											</a>
										<?php
										}
										if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
										?>
											<a href="<?php echo base_path() . 'vwr_dropbox/add_dropbox/' . base64_encode($record_view->id); ?>" class="drop_edit"> 
												<img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/ico_7.png" width="18" height="19" alt="edit" title="Edit" />
											</a>
											<a href="javascript:void(0);" class="drop_edit"><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/ico_8.png" width="18" height="19" alt="Delete" title="Delete" onclick="Delete_Dropbox('<?php echo base_path(); ?>','<?php echo $record_view->id; ?>');" /></a>
										<?php
										}
										?>
									</li>
								</ul>
				<?php
							}
						}
					}
				}
				if ($rv == 0) {
					echo '<div style="padding-top:121px; text-align:center;width:100%;">';
					echo "No Dropbox Available";
					echo '</div>';
				}
				?>
			</div>
		</div>
	<?php
	}
	?>
	<!--------------- Supplier ------------------>
	<?php
	if (in_array('supplier', $user->roles)) {

		if (isset($_POST['search_date'])) {
			if ($_POST['search_date'] == '1') {
				$cc_dates = "{dropbox}.start_date ASC";
			}
			if ($_POST['search_date'] == '2') {
				$cc_dates = "{dropbox}.end_date ASC";
			}
		} else {
			$cc_dates = '';
		}
		if (isset($_POST['cat_search'])) {
			$cat = "and cat_id=" . addslashes(htmlspecialchars(trim($_POST['cat_search'])));
		}
	?>
		<div class="right_cont">
			<?php
			$themepath = base_path() . drupal_get_path('theme', 'vwr') . '/';
			$select_title = db_query("SELECT title,instruction FROM {dropbox_instructions}
			ORDER BY title DESC LIMIT 0,1")->fetchObject();
			$u_title = $select_title->title;
			$dropbox_instruction = $select_title->instruction;
			?>
			<h3><?php if ($u_title != "") {
					echo htmlspecialchars($u_title);
				} else {
					echo "Dropbox";
				} ?></h3>
			<div class="inbread">
				<a href="<?php echo base_path(); ?>">VWR Home</a>&gt;<span><?php print ($u_title && $u_title != "") ? htmlspecialchars($u_title) : 'Dropbox'; ?></span>
			</div>

			<div class="drpbx_cont" style="border-bottom:none;">
				<p style="height:5px;"></p>
				<form name="dropboxlist" action="" method="post">
					<p class="sort_options" style="display:none;">
						<select name="search_date" id="search_date" onchange="FilterBySorting_dropbox(this.value);" class="view_dropbox_input">
							<option value="0" id="search_date" selected="selected">Select Date</option>
							<option value="1" <?php if (isset($_POST['search_date']) && ($_POST['search_date'] == '1')) { ?>selected="selected" <?php } ?>>create date</option>
							<option value="2" <?php if (isset($_POST['search_date']) && ($_POST['search_date'] == '2')) { ?>selected="selected" <?php } ?>>end date</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="cat_search" id="cat_search" onchange="FilterBySorting_category(this.value);" class="view_dropbox_input">
							<option value="0" id="cat_search">Select Category</option>
							<?php


							$result = get_all_categories($currentregionid);
							if ($result) {
								foreach ($result as $record) {
									if (check_category_topic_access($record->category_id, 0)) {
							?>
										<option value="<?php echo $record->category_id; ?>" <?php if ($_POST['cat_search'] == $record->category_id) { ?>selected="selected" <?php } ?>><?php echo $record->category_name; ?></option>
							<?php
									}
								}
							}
							?>
						</select>
					</p>
				</form>
				<p class="instruction_view">
					<span id="instruction" style="float:left;">
						<?php
						if ($dropbox_instruction != "") {
							echo nl2br(htmlspecialchars($dropbox_instruction));
						} else {
							echo "Instruction";
						}
						?>
					</span>
				</p>
				<?php


				$user->uid;
				$select_supplier_name = db_query('SELECT supplier_org_name FROM {users_info} where uid =:uid', array(':uid' => $user->uid))->fetchObject();
				$supplier_org_name = $select_supplier_name->supplier_org_name;
				$dropbox_cat_ids = array();
				$dropbox_topic_ids = array();
				$get_sup_org_id = db_query('SELECT vendor_id as supplier_org_id FROM {vendor} WHERE supplier_org_id=:supplier_org_id', array(':supplier_org_id' => addslashes($supplier_org_name)));
				foreach ($get_sup_org_id as $get_supplier_org_id_1) {
					$get_supplier_org_id = $get_supplier_org_id_1->supplier_org_id;
					$supplier_org_id = $get_supplier_org_id;
					$get_drop_box_id = db_query('Select * from {dropbox_supplier_access} where supplier_org_id=:supplier_org_id GROUP BY dropbox_id', array(':supplier_org_id' => $supplier_org_id));
					foreach ($get_drop_box_id as $get_drop_box_id_1) {
						$get_dropbox_details = db_query('Select * from {dropbox_category_mapping} where
						dbox_id = :dropbox_id order by region_id', array(':dropbox_id' => $get_drop_box_id_1->dropbox_id . $cat));
						foreach ($get_dropbox_details as $get_dropbox_details_1) {
							$cat_id = $get_dropbox_details_1->cat_id;
							$top_id = $get_dropbox_details_1->topic_id;
							$check_dropbox_details = db_query('Select * from {category_useraccess_mapping} 
							where category_id = :cat_id and topic_id=:top_id  
							and supplier_org_id IN (SELECT vendor_id FROM {vendor} WHERE supplier_org_id=:supplier_org_id)', array(':cat_id' => $cat_id, ':top_id' => $top_id, ':supplier_org_id' => addslashes($supplier_org_name)));
							$get_final_checking = $check_dropbox_details->rowCount();
							if ($get_final_checking == '1' || $get_final_checking > 1) {

								$drop_box_array[] = $get_drop_box_id_1->dropbox_id;
								if (!in_array($top_id, $dropbox_cat_ids[$cat_id])) {
									$dropbox_cat_ids[$cat_id][] = $top_id;
								}
								$drop_cate_id[$get_drop_box_id_1->dropbox_id] = $dropbox_cat_ids;
							}
						}
					}
				}
				$cc_date = ' ORDER BY created_date DESC ';
				$result = array_unique($drop_box_array);
				$result_drop_id = array_values($result);
				$drop_count = count($result_drop_id);
				$rv = 0;
				if ($drop_count > 0) {
					$i = "";
					$timestamp = strtotime(date("m/d/Y"));
				?>
					<ul class="search_cate">
						<?php
						$jk = 1;
						for ($i = $drop_count - 1; $i >= 0; $i--) { 

							if ($cc_dates != '') {
								$comma = ",";
							}
							$record_view  = db_query('SELECT * FROM {dropbox},{dropbox_regions}' .
								$regiondeactivequery . 'WHERE id=:id and {dropbox_regions}.
						dropbox_id ={dropbox}.id ' . $regionquery . ' AND deleted=0 AND 
						start_date <= :start_dt AND end_date >= :end_dt order by ' .
								$cc_dates . $comma . '{dropbox_regions}.region_id ASC', array(':currentregionid' => $currentregionid, ':id' => $result_drop_id[$i], ':start_dt' => $timestamp, ':end_dt' => $timestamp))->fetchObject();

							if (!empty($record_view)) {
								$dropbox_category_topic = $drop_cate_id[$result_drop_id[$i]];
								$dropbox_category = $dropbox_category_topic;
								$expired_categories = 0;
								$deleted_categories = 0;
								$total_rows = 0;
								foreach ($dropbox_category as $cat_id => $topic_id) {
									foreach ($topic_id as $topicid) {
										$total_rows++;
										if (check_category_topic_expires($cat_id, $topicid) == 0) {
											$expired_categories++;
										}
										if (check_category_topic_deleted($cat_id, $topicid) == 0) {
											$deleted_categories++;
										}
									}
								}
								if ($total_rows != $expired_categories && $total_rows != $deleted_categories) {
									$rv++;
									echo "<script>$('.sort_options').show();</script>";

									if (checkSupplierPagesDropbox($record_view->id, $dropbox_category_topic)) {
						?>
										<li class="drp_lst" id="<?php echo htmlspecialchars($record_view->start_date); ?>_<?php echo htmlspecialchars($record_view->end_date); ?>_<?php echo htmlspecialchars($jk); ?>">
											<a href="javascript:void(0)" onClick="Dropbox_Modalbox_view('file_upload','<?php echo base_path(); ?>','<?php echo htmlspecialchars($result_drop_id[$i]) ?>');" class="drop_ico" title="Submit Files"><img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/dropbox_up_s.png" width="30" height="28" alt="dropbox" title="Submit Files" /></a>
											<div class="drp_txt_view">
												<span class="drp_ttl">
													<a href="javascript:void(0)" onClick="Dropbox_Modalbox_view('file_upload','<?php echo base_path(); ?>','<?php echo htmlspecialchars($result_drop_id[$i]) ?>');" class="drop_ico" style="text-decoration:none;"><?php echo htmlspecialchars($record_view->title) . " <b>(" . htmlspecialchars(db_query("select region_shortname from {manage_regions} where region_id=:reg_id", array(':reg_id' => $record_view->region_id))->fetchColumn()) . "</b>)"; ?></a></span> <span class="drp_dt"><?php echo date("m/d/Y", htmlspecialchars($record_view->end_date)); ?></span>
												<?php
												foreach ($dropbox_category_topic as $category_id => $topic_id) {
													foreach ($topic_id as $topicid) {
														$check_category_map = db_query('SELECT * FROM {dropbox_category_mapping} WHERE dbox_id=:dbox_id AND cat_id=:cat_id AND topic_id=:topic_id', array(':dbox_id' => $record_view->id, ':cat_id' => $category_id, ':topic_id' => $topicid));
														if (check_category_topic_expires($category_id, $topicid) > 0 && $check_category_map->rowCount() > 0) {
															
															$region_id = db_select("dropbox_category_mapping", "dcm")
																->fields("dcm", array("region_id"))
																->condition('dcm.cat_id', $category_id, '=')
																->execute()->fetchColumn();
															$currentregions = explode(",", $currentregionid);
															if (in_array($region_id, $currentregions)) {
												?>
																<span class="drp_lnk >
							_<?php echo $category_id; ?>" id="cate_list_<?php echo $category_id; ?>" style="line-height:12px;">
																	<?php
																	if ($category_id != "") {
																		$get_cat_name = db_query('SELECT category_name,category_status FROM {category} WHERE category_id = :category_id', array(':category_id' => $category_id))->fetchObject();
																		$cat_name = $get_cat_name->category_name;
																		$topic_name = get_topic_name($topicid);
																		if ($topicid == 0 && $get_cat_name->category_status == 1) {

																			$categoryids = $category_id . "_" . $region_id;
																			$onlycategoryids = $category_id;
																			$region_id = db_query('SELECT region_id FROM {dropbox_category_mapping} WHERE cat_id=:cat_id', array(':cat_id' => $category_id))->fetchColumn();
																	?>
																			<a href="javascript:void(0)" onclick="showcategorypagesfordropbox('<?php echo htmlspecialchars($categoryids); ?>',0,0,0,'cat','<?php echo htmlspecialchars($region_id); ?>')">
																				<?php
																				echo htmlspecialchars($cat_name) . " " . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $region_id))->fetchColumn());
																				?>
																			</a>
																		<?php
																		} else {
																			$region_id = db_query('SELECT region_id FROM {dropbox_category_mapping} WHERE cat_id=:cat_id', array(':cat_id' => $category_id))->fetchColumn();
																			if ($topic_name != "") {
																				echo htmlspecialchars($cat_name) . " " . htmlspecialchars(db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $region_id))->fetchColumn());
																			}
																		}
																	}
																	if ($topicid != 0 && $topic_name != "") {
																		$link_url = get_link_url($topicid);
																		$topicidslists = $topicid . "_" . $region_id;
																		$onlycategoryids = $category_id;
																		
																		$contentsubcat = db_select("content_regions", "cr")
																			->fields("cr", array('content_id'))
																			->condition('cr.content_id', $topicid, '=')
																			->condition('cr.content_type', 1)
																			->condition('cr.region_id', $region_id, '=')
																			->execute();
																		if ($contentsubcat) {
																			foreach ($contentsubcat as $subcat) {

																				$topiclinks = "showcategorypagesfordropbox('$onlycategoryids','$subcat->content_id',0,0,'subcat','$region_id')";
																			}
																		}
																		
																		$contenttopic = db_select("content_regions", "cr")
																			->fields("cr", array('content_id'))
																			->condition('cr.content_id', $topicid, '=')
																			->condition('cr.content_type', 2)
																			->condition('cr.category_id', $category_id, '=')
																			->condition('cr.region_id', $region_id, '=')
																			->execute();
																		if ($contenttopic) {
																			
																			$sucatid = db_select("topic", "t")
																				->fields("t", array('parent_topic_id'))
																				->condition('t.topic_id', $topicid, '=')
																				->execute()->fetchColumn();
																			foreach ($contenttopic as $topic) {

																				$topiclinks = "showcategorypagesfordropbox('$onlycategoryids','$sucatid','$topic->content_id',0,'topic','$region_id')";
																			}
																		}

																		

																		$contentsubtopic = db_select("content_regions", "cr")
																			->fields("cr", array('content_id'))
																			->condition('cr.content_id', $topicid, '=')
																			->condition('cr.content_type', 3)
																			->condition('cr.category_id', $category_id, '=')
																			->condition('cr.region_id', $region_id, '=')
																			->execute();

																		if ($contentsubtopic) {

																			foreach ($contentsubtopic as $subtopic) {
																				
																				$topicid = db_select("topic", "t")
																					->fields("t", array('parent_topic_id'))
																					->condition('t.topic_id', $topicid, '=')
																					->execute()->fetchColumn();

																				
																				$subcatids = db_select("topic", "t")
																					->fields("t", array('parent_topic_id'))
																					->condition('t.topic_id', $topicid, '=')
																					->execute()->fetchColumn();
																				$topiclinks = "showcategorypagesfordropbox('$onlycategoryids','$subcatids','$topicid',$subtopic->content_id,'subtopic','$region_id')";
																			}
																		}

																		?>
																		&nbsp;&nbsp;&gt;&nbsp;&nbsp;
																		<a href="javascript:void(0)" onclick="<?php echo htmlspecialchars($topiclinks); ?>">
																			<?php
																			
																			echo htmlspecialchars($topic_name) . " " . htmlspecialchars(db_select("manage_regions", "mr")
																				->fields("mr", array('region_shortname'))
																				->condition('mr.region_id', $region_id, '=')
																				->execute()->fetchColumn());
																			
																			?>
																		</a>
																	<?php
																	}
																	?>
																</span><br>

												<?php }
														}
													}
												}
												?>
											</div>
											<div id="test_ids" style="display:none;"><?php echo "start:" . date("Y-m-d", $record_view->start_date);
																						echo "end:" . date("Y-m-d", $record_view->end_date); ?></div>
											<a href="<?php echo base_path(); ?>ticketmanager/ticketsoverview?dropbox=<?php  echo  base64_encode(htmlspecialchars($record_view->id)); ?>" class="drop_edit" style="padding:2px 5px 0 0;" title="View Submissions"> 
												<img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/view_file.png" width="16" height="16" alt="View Submissions" title="View Submissions" />
											</a>
											<?php
											if (user_access('add vwr dropbox') && has_page_access('dropbox')) {
											?>
												<a href="<?php echo base_path() . 'vwr_dropbox/add_dropbox/' . base64_encode(htmlspecialchars($record_view->id)); ?>" class="drop_edit"> 
													<img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/ico_7.png" width="18" height="19" alt="edit" title="Edit" />
												</a>
												<a href="javascript:void(0);" class="drop_edit">
													<img src="<?php echo $url = base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/ico_8.png" width="18" height="19" alt="Delete" title="Delete" onclick="Delete_Dropbox('<?php echo base_path(); ?>','<?php echo htmlspecialchars($record_view->id); ?>');" />
												</a>
											<?php
											}
											?>
										</li>
						<?php
										$jk++;
									}
								}
							}
						}
						?>
					</ul>
				<?php
				}
				if ($rv == 0) {
					echo '<div style="padding-top:121px; text-align:center;width:100%;">';
					echo "No Dropbox Available";
					echo '</div>';
				}
				?>
			</div>
		</div>
	<?php
	}
	?>