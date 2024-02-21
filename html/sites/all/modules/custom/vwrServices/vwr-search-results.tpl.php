<?php
	if (user_is_anonymous()) {
		header("HTTP/1.1 401");
		exit;
	}

	$records_per_page = addslashes(htmlspecialchars(trim($_POST['records_per_page'])));
	$sort_results = addslashes(htmlspecialchars(trim($_POST['sort_results'])));
	$filter_option = addslashes(htmlspecialchars(trim($_POST['filter_option'])));
	$from_date = addslashes(htmlspecialchars(trim($_POST['from_date'])));
	$to_date = addslashes(htmlspecialchars(trim($_POST['to_date'])));
	$timestamp = strtotime(date('m/d/Y'));

	if (isset($_POST['search_keyword']) && $_POST['search_keyword'] != '' && is_string($_POST['search_keyword'])) {
		$keyword = addslashes(strip_tags($_POST['search_keyword']));
	} else {
		$keyword = '';
	}
	
	$search_query_condition = "file_status='1' AND expiry_date >= :expiry_dt AND (keyword LIKE :keyword OR file_title LIKE :keyword OR description LIKE :keyword)";
	if ($filter_option == 1) {
		$search_query_condition .= " AND created_date BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
	} elseif ($filter_option == 2) {
		$search_query_condition .= " AND expiry_date BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
	} elseif ($filter_option == 3) {
		$search_query_condition .= " AND expiry_date=" . $to_date . "'";
	} elseif ($filter_option == 4) {
		$search_query_condition .= " AND expiry_date BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
	}
	$cookieprocessregions = '';
	if (!isset($_COOKIE['cookieregion_name'])) {
		if (is_numeric($_SESSION['region_name']) && $_SESSION['region_name'] != '') {
			$cookieprocessregions = addslashes(strip_tags($_SESSION['region_name']));
		}
	} else {
		if (is_numeric($_COOKIE['cookieregion_name']) && $_COOKIE['cookieregion_name'] != '') {
			$cookieprocessregions = addslashes(strip_tags($_COOKIE['cookieregion_name']));
		}
	}
	if (!is_vwr_user_role()) {
		if ($user->uid) {
			$resultset = db_query('SELECT so.supplier_org_id FROM {users_info} AS u LEFT JOIN {supplier_organization} AS so ON so.supplier_org_id = u.supplier_org_name WHERE u.uid = :uid', array(':uid' => $user->uid))->fetchObject();
		}
		$isglobal = 1;
		if ($resultset->supplier_org_id > 0) {
			$isglobal = get_global_supplier($resultset->supplier_org_id);
			if ($isglobal <= 1) {
				$cookie_regions = array();
				$cookie_regions = explode(',', $cookieprocessregions);
				$cookiepreprocessregions = $cookieprocessregions;

				$cookieprocessregions = get_supplier_region($resultset->supplier_org_id);
				$supplierregion = $cookieprocessregions;
				if (count($cookie_regions) == 1) {
					if ($cookiepreprocessregions != $cookieprocessregions) {

						$cookieprocessregions = $cookie_regions[0];
					}

					if (!in_array($supplierregion, $cookie_regions)) {
						$cookieprocessregions = 0;
					}
				}
			}
		}
	}
	
	$region_query = " INNER JOIN {upload_documents_regions} as udr on udr.file_id = ud.file_id and udr.region_id in (:cookieprocessregions) and udr.status=1 INNER JOIN {manage_regions} AS vwrmr ON vwrmr.region_id=udr.region_id AND vwrmr.region_status=1 ";
	$grpby_file_id = " group by ud.file_id ";
	$total_count = db_query('SELECT COUNT(docs.file_id) FROM ( SELECT ud.file_id FROM {upload_documents} as ud ' . $region_query . ' WHERE ' . $search_query_condition . ' GROUP BY ud.file_id) AS docs ', array(':cookieprocessregions' => $cookieprocessregions, ':expiry_dt' => $timestamp, ':keyword' => '%' . db_like($keyword) . '%'))->fetchField();
	$start = 0;
	$end = $total_count;
	/* Filter Records per Page */
	if ($records_per_page != "") {
		$end = $records_per_page;
		$pieces_per_page = $records_per_page;
	} else {
		$end = $total_count;
		$pieces_per_page = 10;
	}
	/* Sort Results Date By Ascending, Descending */
	if ($sort_results == "") {
		$sort_results = 0;
	}
	$sort_type = array(0 => "ASC", 1 => "ASC", 2 => "DESC");
	?>
	<?php $url = $_SERVER['HTTP_REFERER'];
	if (!strpos($url, 'category')) {
		$top_style = '3px';
	} else {
		$top_style = '-27px';
	} ?>

	<div class="right_cont" style="top:<?php echo htmlspecialchars($top_style); ?>">
		<h3> Search Results</h3>
		<div class="search_results">
			<div class="result_details">
				<div class="kwd_top">
					<p class="result_keyword"><span><strong>Keyword</strong>='<?php echo htmlspecialchars($keyword); ?>'</span>
					</p>
					<div class="filter_result">
						<?php if ($total_count > 0) { ?>
							View:
							<select name="results_per_page" onchange="FilterByRecords('<?php echo htmlspecialchars($keyword); ?>',this.value,'<?php echo htmlspecialchars($sort_results); ?>');">
								<option selected="selected" value="">All</option>
								<option value="10" <?php if ($records_per_page == 10) { ?> selected <?php } ?>>10</option>
								<option value="20" <?php if ($records_per_page == 20) { ?> selected <?php } ?>>20</option>
								<option value="50" <?php if ($records_per_page == 50) { ?> selected <?php } ?>>50</option>
							</select>&nbsp;
							Sort:
							<select name="sort_results" onchange="FilterBySorting('<?php echo htmlspecialchars($keyword); ?>',this.value,'<?php echo htmlspecialchars($records_per_page); ?>');">
								<option selected="selected" value="">Date</option>
								<option value="1" <?php if ($sort_results == 1) { ?> selected <?php } ?>>Ascending</option>
								<option value="2" <?php if ($sort_results == 2) { ?> selected <?php } ?>>Descending</option>
							</select>
						<?php } ?>
						<input type="hidden" id="pieces_per_page" value="<?php echo htmlspecialchars($pieces_per_page); ?>" />
					</div>
				</div>
				<br /><br />
				<div id="searchpaginate2" class="paginationstyle" style="display:none"></div>
				<?php
				if ($total_count > 0) {
					
					$result = db_query('SELECT * FROM {upload_documents} as ud ' . $region_query . ' WHERE ' . $search_query_condition . $grpby_file_id . ' ORDER BY created_date ' . $sort_type[$sort_results] . ' limit ' . $start . ', ' . $end . '', array(':cookieprocessregions' => $cookieprocessregions, ':expiry_dt' => $timestamp, ':keyword' => '%' . db_like($keyword) . '%'));
					if ($result) {
						$r = 0;
						foreach ($result as $record) {
							$author_name = get_author_name($record->created_by);
							$category_name = get_category_name($record->cat_id);
							$file_creation_date = date("m/d/Y", $record->created_date);
							$file_size = filesize('sites/default/files/docs/' . $record->file_name);
							if ($file_size == 0) {
								$file_size = filesize('sites/default/files/docs/' . str_replace("&amp;", "&", $record->file_name));
							}
							$document_icon = getFiletype_Icon($record->file_name);
							//Check Search Results with User Permission
							if ($record->internal_topic_id != 0) {
								$topic_id = $record->internal_topic_id;
							} elseif ($record->sub_topic_id != 0) {
								$topic_id = $record->sub_topic_id;
							} elseif ($record->topic_id != 0) {
								$topic_id = $record->topic_id;
							} else {
								$topic_id = "";
							}
							$category_id = $record->cat_id;
							if (check_results_with_permission($category_id, $topic_id)) {
				?>
								<div class="document_results hidepiece">
									<div class="file_symbal">
										<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/<?php echo htmlspecialchars($document_icon); ?>" />
									</div>
									<div class="file_details">
										<p class="file_title"><a style="cursor:pointer;" onClick="window.open('<?php echo base_path(); ?>sites/default/files/docs/<?php echo str_replace("#", "%23", htmlspecialchars($record->file_name)); ?>','_blank')"><?php echo str_replace(htmlspecialchars($keyword), '<b>' . htmlspecialchars($keyword) . '</b>', htmlspecialchars($record->file_title)); ?></a></p>
										<p class="file_author">Updated by: <?php echo htmlspecialchars($author_name); ?>, Creation Date: <?php echo htmlspecialchars($file_creation_date); ?></p>
										<p class="file_desc"> Description: <?php if ($record->description != "") {
																				echo str_replace(htmlspecialchars($keyword), '<b>' . htmlspecialchars($keyword) . '</b>', htmlspecialchars($record->description));
																			} else {
																				echo "No Description";
																			} ?></p>
										<p class="file_category">
											<?php if (check_category_topic_expires($category_id, $topic_id) > 0) { ?>

												<?php if ($record->cat_id > 0 && !$record->topic_id) { ?>
													<a onclick="setCookie('currentregiontab',<?php echo htmlspecialchars($record->region_id); ?>);" href="<?php echo base_path() . 'category/' . htmlspecialchars($record->cat_id); ?>"><?php echo htmlspecialchars($category_name); ?></a>&nbsp;

												<?php }
												if ($record->topic_id > 0 && !$record->sub_topic_id) { ?>
													<?php echo htmlspecialchars($category_name); ?>&nbsp;<strong>&gt;</strong>&nbsp;
													<a onclick="setCookie('currentregiontab',<?php echo htmlspecialchars($record->region_id); ?>);" href="<?php echo base_path() . 'category/' . htmlspecialchars($record->cat_id) . '/topic/' . htmlspecialchars($record->topic_id); ?>"><?php echo htmlspecialchars(get_topic_name($record->topic_id)); ?></a>&nbsp;
												<?php } ?>

												<?php if ($record->sub_topic_id > 0 && !$record->internal_topic_id) { ?>
													<?php echo htmlspecialchars($category_name); ?>&nbsp;<strong>&gt;</strong>&nbsp;
													<?php echo htmlspecialchars(get_topic_name($record->topic_id)); ?>&nbsp;<strong>&gt;</strong>&nbsp;
													<a onclick="setCookie('currentregiontab',<?php echo htmlspecialchars($record->region_id); ?>);" href="<?php echo base_path() . 'category/' . htmlspecialchars($record->cat_id) . '/topic/' . htmlspecialchars($record->topic_id) . '/subtopic/' . htmlspecialchars($record->sub_topic_id); ?>"><?php echo htmlspecialchars(get_topic_name($record->sub_topic_id)); ?></a>&nbsp;
												<?php } ?>

												<?php if ($record->internal_topic_id > 0) { ?>
													<?php echo htmlspecialchars($category_name); ?>&nbsp;<strong>&gt;</strong>&nbsp;
													<?php echo htmlspecialchars(get_topic_name($record->topic_id)); ?>&nbsp;<strong>&gt;</strong>&nbsp;
													<?php echo htmlspecialchars(get_topic_name($record->sub_topic_id)); ?>&nbsp;<strong>&gt;</strong>&nbsp;
													<a onclick="setCookie('currentregiontab',<?php echo htmlspecialchars($record->region_id); ?>);" href="<?php echo base_path() . 'category/' . htmlspecialchars($record->cat_id) . '/topic/' . htmlspecialchars($record->topic_id) . '/subtopic/' . htmlspecialchars($record->sub_topic_id) . '/internaltopic/' . htmlspecialchars($record->internal_topic_id); ?>"><?php echo htmlspecialchars(get_topic_name($record->internal_topic_id)); ?></a>&nbsp;
												<?php }  ?>

											<?php } ?>

											- <?php echo htmlspecialchars($file_size); ?>KB
										</p><br /><br>

									</div>
								</div>
					<?php $r++;
							}
						}
					}
				}
				if ($r == 0) { ?>
					<br />
					<p style="padding-left:10px;">No result found for '<?php echo htmlspecialchars($keyword); ?>'</p>
				<?php } ?>
				<div id="searchpaginate" class="paginationstyle">
					<a href="#" rel="previous">Prev</a> <span class="flatview"></span> <a href="#" rel="next">Next</a>
				</div>
			</div><br /><br>
		</div>
	</div>

	<script language="text/javascript">
		var gallery = new virtualpaginate({
			piececlass: "document_results", //class of container for each piece of content
			piececontainer: 'div', //container element type (ie: "div", "p" etc)
			pieces_per_page: $('#pieces_per_page').attr('value'), //Pieces of content to show per page (1=1 piece, 2=2 pieces etc)
			defaultpage: 0, //Default page selected (0=1st page, 1=2nd page etc). Persistence if enabled overrides this setting.
			wraparound: false,
			persist: false //Remember last viewed page and recall it when user returns within a browser session?
		})
		gallery.buildpagination(["searchpaginate", "searchpaginate2"])
	</script>