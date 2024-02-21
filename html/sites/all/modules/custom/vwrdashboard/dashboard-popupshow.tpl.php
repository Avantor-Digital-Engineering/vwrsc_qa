<?php
	global $user;
	$icons = db_query('SELECT * FROM {dashboard_user_map} WHERE uid=:uid', array(':uid' => $user->uid));
	foreach ($icons as $record) {
		$selectedcatids = explode(',', $record->category_id);
	}
	$recId = $select_sub = $select_cat = '';
	foreach ($selectedcatids as $key => $val) {
		$split_selectcat = explode("@", $val);
		if (strstr($split_selectcat[1], 'subcat')) {
			$recId = explode("#", $split_selectcat[1]);
			$select_sub .= $recId[1] . ",";
		} else if (strstr($split_selectcat[1], 'cat')) {
			$recId = explode("#", $split_selectcat[1]);
			$select_cat .= $recId[1] . ",";
		} else if (strstr($split_selectcat[1], 'Dropbox')) {
			$select_dropbox = 1;
		} else if (strstr($split_selectcat[1], 'Supplier Org')) {
			$select_supplierorg = 1;
		} else if (strstr($split_selectcat[1], 'Users')) {
			$select_users = 1;
		} else if (strstr($split_selectcat[1], 'View Reports')) {
			$select_bulk = 1;
		} else if (strstr($split_selectcat[1], 'My Reports')) {
			$select_bulk = 1;
		}
	}
	$allcategory_list = explode(",", $select_cat);
	$allsubcategory_list = explode(",", $select_sub);
	$cat_listings = array();
	$subcat_listings = array();
	$all_categoriesfordash = db_query('SELECT * FROM {dashboard_content_regions} WHERE userid=:uid', array(':uid' => $user->uid));
	if ($all_categoriesfordash) {
		foreach ($all_categoriesfordash as $duser) {

			if ($duser->content_type == 0) {
				$cat_listings[] = $duser->content_id . " " . $duser->region_id;
			}
			if ($duser->content_type == 1) {
				$subcat_listings[] = $duser->content_id . " " . $duser->region_id;
			}
		}
	}

	$all_dropboxesfordash = db_query('SELECT * FROM {dashboard_dropbox_regions} WHERE userid=:uid', array(':uid' => $user->uid));
	if ($all_dropboxesfordash) {
		foreach ($all_dropboxesfordash as $dropboxuser) {

			$dropboxes_listings[] = $dropboxuser->dropbox_id . " " . $dropboxuser->region_id;
		}
	}

	?>
	<form name="iconform" id="iconform">
		<div class="pages-list">
			<?php $query = db_query("SELECT title FROM {dropbox_instructions} order by title desc LIMIt 0,1")->fetchObject();
			$dropbox_title = $query->title;
			if (in_array('supplier', $user->roles) && ($dropbox_title != "")) {
				$title = $dropbox_title;
			} else {
				$title = "Dropbox";
			}
			?>
			<input type="checkbox" name="names" style="display:none" class="default" value="Dropbox" <?php if ($select_dropbox == 1) {
																											echo "checked";
																										} ?>>
			<span style="color:#0024C0;padding-left:5px;display:none"><?php echo htmlspecialchars($title); ?></span><br />
			<?php
			if (is_vwr_user_role()) {
				$bulk_title = "View Reports";
			?>
				<input type="checkbox" name="names" class="default" style="display:none" value="Supplier Org" <?php if ($select_supplierorg == 1) {
																													echo "checked";
																												} ?>>
				<span style="color:#0024C0;padding-left:5px;display:none">Supplier Org</span><br />
				<input type="checkbox" name="names" class="default" style="display:none" value="Users" <?php if ($select_users == 1) {
																											echo "checked";
																										} ?>>
				<span style="color:#0024C0;padding-left:5px;display:none">Users</span><br />
			<?php
			} else {
				$bulk_title = "My Reports";
			}
			?>
			<input type="checkbox" name="names" class="default" style="display:none" value="<?php echo $bulk_title; ?>" <?php if ($select_bulk == 1) {
																															echo "checked";
																														} ?>>
			<span style="color:#0024C0;padding-left:5px;display:none"><?php echo $bulk_title; ?></span><br />
			<?php

			$timestamp = strtotime(date("d-m-Y"));
			$currentregionslist = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));
			$currentregionslisting = explode(",", $_COOKIE['cookieregion_name']);
			if (strlen($_COOKIE['cookieregion_name']) == 1) {
				$result = db_query('SELECT category.*,vwrmr.region_shortname,vwrmr.region_id FROM {category} as category join {category_regions}
			as category_regions on category.category_id=category_regions.category_id' . $currentregion . '
			INNER JOIN {manage_regions} as vwrmr on vwrmr.region_id=category_regions.region_id and vwrmr.region_status=1 
			WHERE category.category_status=1 AND category_regions.status=1 and category.expiry_date>=:expiry_dt		
			ORDER BY category.category_name ASC', array(':expiry_dt' => $timestamp));
			} else {
				$result = db_query('SELECT category.*,vwrmr.region_shortname,vwrmr.region_id FROM {category} as category join {category_regions}
			as category_regions on category.category_id=category_regions.category_id ' . $currentregion . '
			INNER JOIN {manage_regions} as vwrmr on vwrmr.region_id=category_regions.region_id and vwrmr.region_status=1 
			WHERE category.category_status=1 AND category_regions.status=1 and category.expiry_date>=:expiry_dt		
			group by category.category_name ORDER BY category.category_name ASC', array(':expiry_dt' => $timestamp));
			}
			if ($result) {
				foreach ($result as $record) {
					$displayinfo = "style='display:block'";
					if (is_vwr_user_role()) {
						$accessregionid = 0;
					} else {
						$accessregionid = $record->region_id;
					}
					if (check_category_topic_access($record->category_id, 0, $accessregionid)) {
						if (!in_array($record->region_id, $currentregionslisting)) {
							$displayinfo = "style='display:none'";
						}

			?>
						<div <?php echo $displayinfo; ?>>
							<input type="checkbox" id="<?php echo $record->category_id; ?>" name="names" class="category" value="cat#<?php echo $record->category_id; ?>#regionid#<?php echo $record->region_id; ?>" <?php if (in_array($record->category_id . " " . $record->region_id, $cat_listings)) {
																																																						echo "checked";
																																																					} ?>>
							<span style="color:#0024C0;padding-left:5px;">
								<?php
								$categoryregionscount = db_query('select * from {category_regions} where category_id=:category_id and status=1', array(':category_id' => $record->category_id));
								if ($categoryregionscount->rowCount() == 1) {
									$regionidfromcat = db_query('select region_id from {category_regions} where category_id=:category_id and status=1', array(':category_id' => $record->category_id))->fetchField();
									$regionactualname = db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $regionidfromcat))->fetchField();
								} else {
									if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '1')) {
										$regionactualname = "NA";
									}
									if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '2')) {
										$regionactualname = "EU";
									}
								}

								if (strlen($_COOKIE['cookieregion_name']) == 1) {

									echo htmlspecialchars($record->short_name) . "&nbsp;<b>" . htmlspecialchars($regionactualname) . "</b>";
								}

								if (strlen($_COOKIE['cookieregion_name']) != 1) {
									if ($categoryregionscount->rowCount() == 1) {
										echo htmlspecialchars($record->short_name) . "&nbsp;<b>" . htmlspecialchars($regionactualname) . "</b>";
									} else {
										echo $record->short_name;
									}
								}
								?>

							</span><br />
						</div>
						<?php
						$subresult = db_query('SELECT t.topic_id,t.topic_name,t.short_name,mr.region_shortname,mr.region_id FROM 
							{topic} as t INNER JOIN {content_regions} as cr
							on t.category_id=cr.category_id 
							and cr.region_id in(:region_id)  
							and cr.content_type in (1)
							INNER JOIN vwr_manage_regions as mr
							on mr.region_id=cr.region_id 
							AND t.category_id = :category_id AND 
							t.parent_topic_id=0 
							AND 
							t.topic_status=1 
							and 
							mr.region_status=1 
							and 
							cr.status=1 
							AND 
							t.expiry_date >= :expiry_dt
							group by t.topic_id,cr.region_id 
							ORDER BY t.topic_name ASC', array(':region_id' => $record->region_id, ':category_id' => $record->category_id, ':expiry_dt' => $timestamp));
						if ($subresult) {
							foreach ($subresult as $subrecord) {
								$displayinfo = "style='display:block'";
								if (is_vwr_user_role()) {
									$subaccessregionid = 0;
								} else {
									$subaccessregionid = $subrecord->region_id;
								}
								if (check_category_topic_access($record->category_id, $subrecord->topic_id, $subaccessregionid)) {
									if (!in_array($subrecord->region_id, $currentregionslisting)) {
										$displayinfo = "style='display:none'";
									}
						?><div <?php echo $displayinfo; ?>>
										<input type="checkbox" id="<?php echo $subrecord->topic_id; ?>" name="names" class="subcategory" value="subcat#<?php echo $subrecord->topic_id; ?>#regionid#<?php echo $subrecord->region_id; ?>" <?php if (in_array($subrecord->topic_id . " " . $record->region_id, $subcat_listings)) {
																																																											echo "checked";
																																																										} ?>>
										<span style="color:#0024C0;padding-left:5px;">
											<?php
											$subcategoryregionscount = db_query('select * from {content_regions} where content_id = :content_id and status=1', array(':content_id' => $subrecord->topic_id));
											if ($subcategoryregionscount->rowCount() == 1) {
												$regionidfromsubcat = db_query('select region_id from {content_regions} where content_id=:content_id and status=1', array(':content_id' => $subrecord->topic_id))->fetchField();
												$subregionactualname = db_query('select region_shortname from {manage_regions} where region_id=:region_id', array(':region_id' => $regionidfromsubcat))->fetchField();
											} else {
												if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '1')) {
													$subregionactualname = "NA";
												}
												if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '2')) {
													$subregionactualname = "EU";
												}
											}


											if (strlen($_COOKIE['cookieregion_name']) == 1) {

												echo htmlspecialchars($subrecord->short_name) . "&nbsp;<b>" . htmlspecialchars($subregionactualname) . "</b>";
											}

											if (strlen($_COOKIE['cookieregion_name']) != 1) {

												if ($subcategoryregionscount->rowCount() == 1) {
													echo htmlspecialchars($subrecord->short_name) . "&nbsp;<b>" . htmlspecialchars($subregionactualname) . "</b>";
												} else {
													echo $subrecord->short_name;
												}
											}
											?>


										</span>

										<br />
									</div>
			<?php   }
							}
						}
					}
				}
			} ?>
			<p>&nbsp;</p>
			<span style="margin-left:60px"><b style="color:#0024C0">-Dropboxes-</b> </span>
			<p>&nbsp;</p>
			<?php
			$currentregionid = addslashes(htmlspecialchars(trim($_COOKIE['cookieregion_name'])));

			$regionquery = 'and {dropbox_regions}.region_id in (:currentregionid) and {dropbox_regions}.status in (1)';
			$regiondeactivequery = " INNER JOIN {manage_regions} as vwrmr on vwrmr.region_id={dropbox_regions}.region_id and vwrmr.region_status=1 ";
			$categoryregionquery = 'and {category_regions}.region_id in (' . $currentregionid . ')';

			$timestamp = strtotime(date("m/d/Y"));
			if (is_vwr_user_role()) {
				$select_details = db_query('SELECT * FROM {dropbox},{dropbox_regions}' .
					$regiondeactivequery . ' WHERE {dropbox_regions}.dropbox_id ={dropbox}.id ' .
					$regionquery . ' and :end_date_sort and deleted =0 group by id ORDER BY {dropbox_regions}.region_id ASC,created_date DESC,
		end_date DESC', array(':currentregionid' => $currentregionid, ':end_date_sort' => $timestamp));
			} else {

				$select_details = db_query('SELECT * FROM {dropbox},{dropbox_regions} 
		' . $regiondeactivequery . ' WHERE {dropbox_regions}.
		dropbox_id ={dropbox}.id ' . $regionquery . ' AND deleted=0 AND 
		start_date <= :start_dt AND end_date >= :end_dt order by 
		{dropbox_regions}.region_id ASC', array(':start_dt' => $timestamp, ':end_dt' => $timestamp, ':currentregionid' => $currentregionid));
				$count = $select_details->rowCount();
			}

			foreach ($select_details as $record_view) {


			?>
				<div style="display:block">
					<input type="checkbox" id="<?php echo $record_view->id; ?>" name="names" class="dropboxes" value="dropboxes#<?php echo $record_view->id; ?>#regionid#<?php echo $record_view->region_id; ?>" <?php if (in_array($record_view->id . " " . $record_view->region_id, $dropboxes_listings)) {
																																																					echo "checked";
																																																				} ?>>
					<span style="color:#0024C0;padding-left:5px;">

						<?php						
						$dropboxregionscount = db_query('select * from {dropbox_regions} where dropbox_id=:id and status=1', array(':id' => $record_view->id));
						if ($dropboxregionscount->rowCount() == 1) {
							$regionidfromdropbox = db_query('select region_id from {dropbox_regions} where dropbox_id=:id and status=1', array(':id' => $record_view->id))->fetchField();
							$dropboxregionactualname = db_query('select region_shortname from {manage_regions} where region_id=:id', array(':id' => $regionidfromdropbox))->fetchField();
						} else {
							if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '1')) {
								$dropboxregionactualname = "NA";
							}
							if ((strlen($_COOKIE['cookieregion_name']) == 1) && ($_COOKIE['cookieregion_name'] == '2')) {
								$dropboxregionactualname = "EU";
							}
						}


						if (strlen($_COOKIE['cookieregion_name']) == 1) {

							echo htmlspecialchars($record_view->title) . "&nbsp;<b>" . htmlspecialchars($dropboxregionactualname) . "</b>";
						}

						if (strlen($_COOKIE['cookieregion_name']) != 1) {

							if ($dropboxregionscount->rowCount() == 1) {
								echo htmlspecialchars($record_view->title) . "&nbsp;<b>" . htmlspecialchars($dropboxregionactualname) . "</b>";
							} else {
								echo $record_view->title;
							}
						}

						?>
					</span>
					<br />
				</div>



			<?php
			}

			?>


		</div>
		<div class="popBut dashboard-confirm-btn" id="dashboard_popup">
			<input type="button" class="button" value="Confirm" onclick="checkbox_test();" />
			<input type="button" class="button simplemodal-close" value="Cancel" onclick="$('a.simplemodal-close').click();"><span id="dashboard_loader" style="display:none;margin-left:5px"></span>
		</div>
	</form>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>