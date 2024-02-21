<?php
	$fid = 0;
	$cat_topic_id = addslashes(htmlspecialchars($_POST['cat_topic_id']));
	$level = addslashes(htmlspecialchars($_POST['level']));
	$page_url = addslashes(htmlspecialchars($_POST['action_url']));
	if ($page_url != '') {
		if ((strpos($page_url, 'category') !== false) && (strpos($page_url, 'topic') === false) && (strpos($page_url, 'subtopic') === false) && (strpos($page_url, 'internaltopic') === false)) {
			$documentupload = "category";
		}
		if ((strpos($page_url, 'category') !== false) && (strpos($page_url, 'topic') !== false) && (strpos($page_url, 'subtopic') === false) && (strpos($page_url, 'internaltopic') === false)) {
			$documentupload = "topic";
		}
		if ((strpos($page_url, 'category') !== false) && (strpos($page_url, 'topic') !== false) && (strpos($page_url, 'subtopic') !== false) && (strpos($page_url, 'internaltopic') === false)) {
			$documentupload = "subtopic";
		}
		if ((strpos($page_url, 'category') !== false) && (strpos($page_url, 'topic') !== false) && (strpos($page_url, 'subtopic') !== false) && (strpos($page_url, 'internaltopic') !== false)) {
			$documentupload = "internaltopic";
		}
	} else {
		$documentupload = $level;
	}
	if (arg(2) && isset($_POST['fid'])) {
		$fid = ($_POST['fid'] == arg(2)) ? addslashes(htmlspecialchars(trim($_POST['fid']))) : 0;
	}
	if (!$fid) {
		$action_url = addslashes(strip_tags($_POST['action_url']));
		$params = 'cat_id=' . addslashes(strip_tags($_POST['cat_id'])) . '&top_id=' . addslashes(strip_tags($_POST['top_id'])) . '&stop_id=' . addslashes(strip_tags($_POST['stop_id'])) . '&itop_id=' . addslashes(strip_tags($_POST['itop_id']));
	} else {
		$record = db_select('upload_documents', 'ud')
			->fields('ud', array('file_title', 'file_name', 'keyword', 'description', 'expiry_date'))
			->condition('ud.file_id', $fid, '=')->execute()->fetchObject();

		$resultset = db_select("upload_documents_regions", "udr")
			->fields("udr", array("region_id"))
			->condition('udr.file_id', $fid, '=')
			->execute();
		
		$category_regions = array();
		while ($row = $resultset->fetchAssoc()) {
			$category_regions[$row['region_id']] = $row;
		}
	}
	?>
	<style type="text/css">
		div.simplemodal-container {
			height: 450px !important;
			top: 30px !important;
		}
	</style>
	<div class="pop_cont" id="cat_topic_container">
		<h3>Upload File</h3>
		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div class="poptxt cat_upld cat_upld_doc">
			<label>Title<span>*</span> :</label><input type="text" id="doc_title" value="<?php echo(!empty($record->file_title)) ? htmlspecialchars($record->file_title) : '';?>" />
			<label>Keywords<span>*</span> :</label><input type="text" id="doc_keyword" value="<?php echo(!empty($record->keyword)) ? htmlspecialchars($record->keyword) : ''; ?>" style="margin-bottom:2px;" />
			<div style="clear:both; color:red; margin: 0 0 12px 40px; ">(Use <strong>;</strong> As a seperator for adding multiple keywords)</div>
			<label>Description :</label><textarea id="doc_desc" cols="10" rows="5"><?php echo(!empty($record->description)) ? htmlspecialchars($record->description) : ''; ?></textarea>
			<?php if (!$fid) { ?>
				<label>Upload<span>*</span> :</label><input name="doc_file" type="file" id="doc_file" onchange="initiateScan()" >
				<font style="float:right;margin-top:-20px;">Limit 500MB</font></input><br />
			<?php } ?>

			<label id="regionchkbx">Select Regions<span>*</span> :</label>
			<span class="img_existed">
				<?php

				if (trim($documentupload) == 'category') {
					$regions = getcategoryregions($cat_topic_id);
				}
				if (trim($documentupload) == 'topic') {

					$categoryid = explode("&", $params);
					$id = explode("=", $categoryid[1]);

					if ($page_url != '') {
						$regions = getsubcategoryregions($id[1]);
					} else {
						$regions = getsubcategoryregions($cat_topic_id);
					}
				}
				if (trim($documentupload) == 'subtopic') {
					$topicid = explode("&", $params);
					$id = explode("=", $topicid[2]);
					if ($page_url != '') {
						$regions = gettopicregions($id[1]);
					} else {
						$regions = gettopicregions($cat_topic_id);
					}
				}
				if (trim($documentupload) == 'internaltopic') {
					$topicid = explode("&", $params);
					$id = explode("=", $topicid[3]);

					if ($page_url != '') {
						$regions = getsubtopicregions($id[1]);
					} else {
						$regions = getsubtopicregions($cat_topic_id);
					}
				}
				if ($regions) {
					(!empty($category_regions)) ? $categoryregionsprocess = array_keys($category_regions) : $categoryregionsprocess = array();
					$i = 0;
					foreach ($regions as $region_id => $reginprocessarray) {

						$checkedproperty = "";
						if (!empty($categoryregionsprocess)) {
							if (in_array($region_id, $categoryregionsprocess)) {
								$checkedproperty = "checked";
							}
						}
						if (count($regions) == 1) {

							$checkedproperty = "checked=checked";
							$disabled = "disabled=disabled";
						}

				?>

						<span id="region_checkboxes">
							<input type="checkbox" id="region_desc<?php echo $i; ?>" style="float:none !important;margin-left:-26px !important;width:67px !important;" value="<?php echo $region_id; ?>" name="region[]" <?php echo (!empty($disabled)) ? $disabled : ''; ?> <?php echo (!empty($checkedproperty)) ? $checkedproperty : ''; ?> />
						</span>
						<span class="regionlabel<?php echo htmlspecialchars($i); ?>" id="regioncheckboxesname<?php echo htmlspecialchars($i); ?>" style="margin-left:-20px;"><?php echo htmlspecialchars($reginprocessarray['region_name']); ?></span><br />
				<?php
						$i++;
					}
				}
				?></span>


			<label>Expiry Date<span>*</span> :</label><input type="text" id="expirydate" value="<?php echo (!empty($record->expiry_date)) ? date("m/d/Y", $record->expiry_date) : ''; ?>" />
		</div>
		<div id="uploadloading" style="display:none;text-align:center;">
			Please do not interrupt the process........ <br />
			<img src="<?php echo base_path() . drupal_get_path('theme', 'vwr'); ?>/images/loading.gif">
		</div>
		<div class="popBut1">
			<input type="hidden" id="file_id" name="file_id" value="" />
			<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="" />
			<?php if (!$fid) { ?>
				<input type="submit" class="button" onClick="uploadDocuments('<?php echo htmlspecialchars($cat_topic_id); ?>','<?php echo htmlspecialchars($level); ?>','<?php echo htmlspecialchars($action_url); ?>', '<?php echo htmlspecialchars($params); ?>');" value="Save " />
			<?php } else { ?>
				<input type="submit" class="button" onClick="updateDocuments('<?php echo htmlspecialchars($cat_topic_id); ?>','<?php echo htmlspecialchars($level); ?>', '<?php echo htmlspecialchars($fid); ?>', 'edit');" value="Update" />
			<?php } ?>
			<input type="submit" class="button modalCloseImg simplemodal-close" value="Cancel" />
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Page level file upload']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>